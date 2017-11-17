<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscription
 *
 * @ORM\Table(name="inscription")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\InscriptionRepository")
 */
class Inscription
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
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Classe")
     */
    private $laClasse;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Promo")
     */
    private $laPromo;

    /**
     * @ORM\ManyToOne(targetEntity="ConnexionBundle\Entity\User")
     */
    private $leEleve;


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
     * Set laClasse
     *
     * @param \BackBundle\Entity\Classe $laClasse
     *
     * @return Inscription
     */
    public function setLaClasse(\BackBundle\Entity\Classe $laClasse = null)
    {
        $this->laClasse = $laClasse;

        return $this;
    }

    /**
     * Get laClasse
     *
     * @return \BackBundle\Entity\Classe
     */
    public function getLaClasse()
    {
        return $this->laClasse;
    }

    /**
     * Set laPromo
     *
     * @param \BackBundle\Entity\Promo $laPromo
     *
     * @return Inscription
     */
    public function setLaPromo(\BackBundle\Entity\Promo $laPromo = null)
    {
        $this->laPromo = $laPromo;

        return $this;
    }

    /**
     * Get laPromo
     *
     * @return \BackBundle\Entity\Promo
     */
    public function getLaPromo()
    {
        return $this->laPromo;
    }

    /**
     * Set leEleve
     *
     * @param \BackBundle\Entity\Eleve $leEleve
     *
     * @return Inscription
     */
    public function setLeEleve(\BackBundle\Entity\Eleve $leEleve = null)
    {
        $this->leEleve = $leEleve;

        return $this;
    }

    /**
     * Get leEleve
     *
     * @return \BackBundle\Entity\Eleve
     */
    public function getLeEleve()
    {
        return $this->leEleve;
    }
}
