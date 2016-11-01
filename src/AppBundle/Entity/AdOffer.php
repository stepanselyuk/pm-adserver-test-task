<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AdOffer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2048, nullable=false)
     */
    private $previewUrl;

    /**
     * @ORM\Column(type="string", length=2048, nullable=false)
     */
    private $impressionUrl;

    /**
     * @ORM\Column(type="string", length=2048, nullable=false)
     */
    private $clickUrl;

    /**
     * @ORM\Column(type="boolean", nullable=false, options={"default":1})
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":0,"unsigned":true})
     */
    private $budget;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":0})
     */
    private $installsDailyCap;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":0})
     */
    private $installsMonthlyCap;

    /**
     * @ORM\Column(type="string", nullable=false, options={"default":"web"})
     */
    private $platform;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $osMinVersion;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $osMaxVersion;

    /**
     * @ORM\Column(type="float", nullable=false, options={"default":0})
     */
    private $rating;

    /**
     * @ORM\Column(type="string", nullable=false, options={"default":"Install"})
     */
    private $actionText;
}