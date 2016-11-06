<?php

/**
 * Json Object Type for Doctrine.
 */

namespace Common\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * Class JsonObjectType.
 */
class JsonObjectType extends Type
{
    const TYPE_NAME = 'json_object';

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getJsonTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!is_object($value)) {
            throw new ConversionException(sprintf('Expected Object value, got "%s"', gettype($value)));
        }

        $data = $this->makeArrayFromObject($value);
        $data['@type'] = self::TYPE_NAME;

        return json_encode($data);
    }

    /**
     * @param $object
     *
     * @return array
     */
    private function makeArrayFromObject($object)
    {
        $data = [];

        try {
            $ref = new \ReflectionClass($object);
            $dlevel = &$data;

            do {
                $dlevel['@class'] = $ref->getName();
                foreach ($ref->getProperties() as $property) {
                    // for protected and private properties
                    $property->setAccessible(true);
                    $dlevel[$property->getName()]
                        = is_object($value = $property->getValue($object)) ?
                        $this->makeArrayFromObject($value) : $value;
                }

                if ($ref = $ref->getParentClass()) {
                    $dlevel['@parent'] = [];
                    $dlevel = &$dlevel['@parent'];
                }
            } while ($ref !== false);
        } catch (\ReflectionException $e) {
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Doctrine\DBAL\Types\ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = is_resource($value) ? stream_get_contents($value) : $value;

        $data = json_decode($value, true);

        if (!array_key_exists('@type', $data)) {
            throw new ConversionException(
                sprintf('Could not convert database value. Value is not compatible with Doctrine %s type.', self::TYPE_NAME)
            );
        }

        return $this->makeObjectFromArray($data);
    }

    /**
     * @param array $data
     *
     * @return object
     */
    private function makeObjectFromArray($data)
    {
        if (!array_key_exists('@class', $data) || !class_exists($data['@class'])) {
            $data['@class'] = \stdClass::class;
        }

        $ref = new \ReflectionClass($data['@class']);
        $object = $ref->newInstanceWithoutConstructor();

        $dlevel = &$data;
        $operateObject = $object;

        do {

            /** @var \ReflectionProperty[] $objectPropList */
            $objectPropList = [];

            array_map(function (\ReflectionProperty $property) use (&$objectPropList) {
                $objectPropList[$property->getName()] = $property;
            }, $ref->getProperties());

            foreach ($dlevel as $propName => $propValue) {
                if (strpos($propName, '@') === 0) {
                    continue;
                }

                if (!array_key_exists($propName, $objectPropList)) {
                    continue;
                }

                // for protected and private properties
                $objectPropList[$propName]->setAccessible(true);

                if (!$objectPropList[$propName]->isStatic()) {
                    $objectPropList[$propName]->setValue(
                        $operateObject,
                        is_array($propValue) ? $this->makeObjectFromArray($propValue) : $propValue
                    );
                } else {
                    $objectPropList[$propName]->setValue($propValue);
                }
            }

            if (array_key_exists('@parent', $dlevel)) {
                if ($dlevel['@class'] !== \stdClass::class
                    && class_exists($dlevel['@parent']['@class'])
                ) {
                    $ref = $ref->getParentClass();
                }

                $dlevel = &$dlevel['@parent'];
            } else {
                $ref = false;
            }
        } while ($ref !== false);

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::TYPE_NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return !$platform->hasNativeJsonType();
    }
}
