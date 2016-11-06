<?php

namespace Common\Infrastructure\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Common\Application\TransactionManager;

class DoctrineTransactionManager implements TransactionManager
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function flush()
    {
        $this->objectManager->flush();
    }

    public function persist($object)
    {
        $this->objectManager->persist($object);
    }
}
