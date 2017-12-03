<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promo
 *
 * @ORM\Table(name="promo")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\PromoRepository")
 */
class Promo
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
     * @ORM\Column(name="label", type="string")
     */
    private $label;


    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\ClassePromo",inversedBy="lesPromos",cascade={"persist"})
     */
    private $classe;


    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity="BackBundle\Entity\ClassePromo",mappedBy="promo",cascade={"persist"})
     */
    private $classePromo;


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
     * @return Promo
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

    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Promo
     */
    public function setYear($year)
    {
        /* on stock la date en int pour pouvoir faire +1 dans le label ^^ */

        $year2 = $year + 1;
        $label = $year.'/'.$year2;
        $this->setLabel($label);
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    public function __toString()
    {
        return $this->label;
    }

    /**
     * Add classePromo
     *
     * @param \BackBundle\Entity\ClassePromo $classePromo
     *
     * @return Promo
     */
    public function addClassePromo(\BackBundle\Entity\ClassePromo $classePromo)
    {
        $this->classePromo[] = $classePromo;

        return $this;
    }

    /**
     * Remove classePromo
     *
     * @param \BackBundle\Entity\ClassePromo $classePromo
     */
    public function removeClassePromo(\BackBundle\Entity\ClassePromo $classePromo)
    {
        $this->classePromo->removeElement($classePromo);
    }

    /**
     * Get classePromo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassePromo()
    {
        return $this->classePromo;
    }

    /**
     * Set classe
     *
     * @param \BackBundle\Entity\Classe $classe
     *
     * @return Promo
     */
    public function setClasse(\BackBundle\Entity\Classe $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \BackBundle\Entity\Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }
}
