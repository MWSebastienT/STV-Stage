<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassePromo
 *
 * @ORM\Table(name="classe_promo")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\ClassePromoRepository")
 */
class ClassePromo
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
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Promo",inversedBy="classePromo")
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Classe",inversedBy="lesPromos")
     */
    private $classe;



    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;


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
     * Set promo
     *
     * @param \BackBundle\Entity\Promo $promo
     *
     * @return ClassePromo
     */
    public function setPromo(\BackBundle\Entity\Promo $promo = null)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return \BackBundle\Entity\Promo
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * Set classe
     *
     * @param \BackBundle\Entity\Classe $classe
     *
     * @return ClassePromo
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

    /**
     * Set label
     *
     * @param string $label
     *
     * @return ClassePromo
     */
    public function setLabel()
    {
        $class = $this->getClasse()->getLabel();
        $promo = $this->getPromo()->getLabel();
        $this->label = $class.' - '.$promo;

        return $this;
    }

    public function __toString()
    {
        return $this->label;
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
}
