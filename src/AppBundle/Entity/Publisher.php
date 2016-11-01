<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publisher
 *
 * @ORM\Table(
 *     name="publishers",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="idx_token_key", columns={"token_key"})}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublisherRepository")
 */
class Publisher
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     */
    private $name;

    /**
     * Revenue share in percents, range 0...1 where 1 is 100%.
     * 
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, name="revenue_share")
     */
    private $revenueShare;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40, nullable=true, name="token_key")
     */
    private $tokenKey;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Publisher
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set revenueShare
     *
     * @param float $revenueShare
     *
     * @return Publisher
     */
    public function setRevenueShare($revenueShare)
    {
        $this->revenueShare = $revenueShare;

        return $this;
    }

    /**
     * Get revenueShare
     *
     * @return float
     */
    public function getRevenueShare()
    {
        return $this->revenueShare;
    }

    /**
     * Set tokenKey
     *
     * @param string $tokenKey
     *
     * @return Publisher
     */
    public function setTokenKey($tokenKey)
    {
        $this->tokenKey = $tokenKey;

        return $this;
    }

    /**
     * Get tokenKey
     *
     * @return string
     */
    public function getTokenKey()
    {
        return $this->tokenKey;
    }
}

