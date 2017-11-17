<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table(name="classe")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\ClasseRepository")
 */
class Classe
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

    /**
     * @ORM\ManyToMany (targetEntity="BackBundle\Entity\Promo", cascade={"persist"})
     */
    private $lesPromos;


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
     * @return Classe
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
     * Constructor
     */
    public function __construct()
    {
        $this->lesPromos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get lesPromos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLesPromos()
    {
        return $this->lesPromos;
    }

    /**
     * Add lesPromo
     *
     * @param \BackBundle\Entity\Promo $lesPromo
     *
     * @return Classe
     */
    public function addLesPromo(\BackBundle\Entity\Promo $lesPromo)
    {
        $this->lesPromos[] = $lesPromo;

        return $this;
    }

    /**
     * Remove lesPromo
     *
     * @param \BackBundle\Entity\Promo $lesPromo
     */
    public function removeLesPromo(\BackBundle\Entity\Promo $lesPromo)
    {
        $this->lesPromos->removeElement($lesPromo);
    }
}
