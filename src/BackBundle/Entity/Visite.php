<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visite
 *
 * @ORM\Table(name="visite")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\VisiteRepository")
 */
class Visite
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
 * @ORM\Column(name="date", type="string")
 */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="obs", type="string", length=255)
     */
    private $obs;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Stage",inversedBy="visite")
     */
    private $leStage;


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
     * Set obs
     *
     * @param string $obs
     *
     * @return Visite
     */
    public function setObs($obs)
    {
        $this->obs = $obs;

        return $this;
    }

    /**
     * Get obs
     *
     * @return string
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * Set leStage
     *
     * @param \BackBundle\Entity\Stage $leStage
     *
     * @return Visite
     */
    public function setLeStage(\BackBundle\Entity\Stage $leStage = null)
    {
        $this->leStage = $leStage;

        return $this;
    }

    /**
     * Get leStage
     *
     * @return \BackBundle\Entity\Stage
     */
    public function getLeStage()
    {
        return $this->leStage;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Visite
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    public function __toString()
    {
        return $this->date;
    }
}
