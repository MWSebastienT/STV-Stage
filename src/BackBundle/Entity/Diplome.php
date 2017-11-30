<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diplome
 *
 * @ORM\Table(name="diplome")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\DiplomeRepository")
 */
class Diplome
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;



    public function __toString()
    {
        return $this->label;
    }

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
     * Set label
     *
     * @param string $label
     *
     * @return Diplome
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="activeStatus", type="boolean")
     */
    private $activeStatus;

    /**
     * Set activeStatus
     *
     * @param boolean $activeStatus
     *
     * @return Diplome
     */
    public function setActiveStatus($activeStatus)
    {
        $this->activeStatus = $activeStatus;

        return $this;
    }

    /**
     * Get activeStatus
     *
     * @return boolean
     */
    public function getActiveStatus()
    {
        return $this->activeStatus;
    }
}
