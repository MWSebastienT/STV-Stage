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
     * @ORM\OneToMany(targetEntity="BackBundle\Entity\HistoryClasse",mappedBy="classe",cascade={"persist","remove"})
     */
    private $history;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\ClassePromo",cascade={"persist","remove"})
     */
    private $classePromo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activeStatus", type="boolean")
     */
    private $activeStatus;

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

    /**
     * Add history
     *
     * @param \BackBundle\Entity\HistoryClasse $history
     *
     * @return Classe
     */
    public function addHistory(\BackBundle\Entity\HistoryClasse $history)
    {
        $this->history[] = $history;

        return $this;
    }

    /**
     * Remove history
     *
     * @param \BackBundle\Entity\HistoryClasse $history
     */
    public function removeHistory(\BackBundle\Entity\HistoryClasse $history)
    {
        $this->history->removeElement($history);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistory()
    {
        return $this->history;
    }

    public function __toString()
    {
        return $this->label;
    }

    /**
     * Add eleve
     *
     * @param \ConnexionBundle\Entity\User $eleve
     *
     * @return Classe
     */
    public function addEleve(\ConnexionBundle\Entity\User $eleve)
    {
        $this->eleve[] = $eleve;

        return $this;
    }

    /**
     * Remove eleve
     *
     * @param \ConnexionBundle\Entity\User $eleve
     */
    public function removeEleve(\ConnexionBundle\Entity\User $eleve)
    {
        $this->eleve->removeElement($eleve);
    }

    /**
     * Get eleve
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEleve()
    {
        return $this->eleve;
    }


    /**
     * Set activeStatus
     *
     * @param boolean $activeStatus
     *
     * @return Classe
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

    /**
     * Set classePromo
     *
     * @param \BackBundle\Entity\ClassePromo $classePromo
     *
     * @return Classe
     */
    public function setClassePromo(\BackBundle\Entity\ClassePromo $classePromo = null)
    {
        $this->classePromo = $classePromo;

        return $this;
    }

    /**
     * Get classePromo
     *
     * @return \BackBundle\Entity\ClassePromo
     */
    public function getClassePromo()
    {
        return $this->classePromo;
    }
}
