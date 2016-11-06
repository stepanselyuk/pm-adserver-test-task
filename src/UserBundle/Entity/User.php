<?php

namespace UserBundle\Entity;

use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use UserBundle\Security\ApiKeyGenerator;

/**
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    const DEFAULT_TIME_ZONE = 'UTC';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name = '';

    /**
     * @var Carbon
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $apiKey;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    protected $isEmailVerified = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $timeZone;

    /**
     * Default constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->roles = [static::ROLE_DEFAULT];
        $this->createdAt = Carbon::now();
        $this->apiKey = ApiKeyGenerator::generate();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return ucwords($this->name);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        parent::setEmail($email);

        $this->username = $email;

        return $this;
    }

    /**
     * @param string $timeZone
     *
     * @return self
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * @return string
     */
    public function getTimeZone()
    {
        if (empty($this->timeZone)) {
            return self::DEFAULT_TIME_ZONE;
        }

        return $this->timeZone;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param bool $isEmailVerified
     *
     * @return self
     */
    public function setIsEmailVerified($isEmailVerified)
    {
        $this->isEmailVerified = $isEmailVerified;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEmailVerified()
    {
        return $this->isEmailVerified;
    }

    /**
     * If user is enabled, non-locked and email is verified.
     *
     * @return bool
     */
    public function isOk()
    {
        return $this->isEnabled() && $this->isAccountNonLocked() && $this->isEmailVerified();
    }

    /**
     * @return string
     */
    public function getTimeZoneOffset()
    {
        $timezone = $this->getTimeZone();

        if (empty($timezone)) {
            $timezone = self::DEFAULT_TIME_ZONE;
        }

        $time = new \DateTime('now', new \DateTimeZone($timezone));

        return $time->format('P');
    }

    /**
     * @return self
     */
    public function resetApiKey()
    {
        $this->apiKey = ApiKeyGenerator::generate();

        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param Carbon $createdAt
     * @return self
     */
    public function setCreatedAt(Carbon $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
