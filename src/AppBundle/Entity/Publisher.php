<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publisher
 *
 * @ORM\Table(name="publisher")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PublisherRepository")
 */
class Publisher
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="revenueShare", type="float")
     */
    private $revenueShare;

    /**
     * @var string
     *
     * @ORM\Column(name="tokenKey", type="string", length=40)
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

