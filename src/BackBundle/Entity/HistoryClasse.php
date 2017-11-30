<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoryClasse
 *
 * @ORM\Table(name="history_classe")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\HistoryClasseRepository")
 */
class HistoryClasse
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
     * @ORM\ManyToOne(targetEntity="ConnexionBundle\Entity\User")
     */
    private $eleve;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Classe",inversedBy="history")
     */
    private $classe;

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
     * Set activeStatus
     *
     * @param boolean $activeStatus
     *
     * @return HistoryClasse
     */
    public function setActiveStatus($activeStatus)
    {
        $this->activeStatus = $activeStatus;

        return $this;
    }

    /**
     * Get activeStatus
     *
     * @return bool
     */
    public function getActiveStatus()
    {
        return $this->activeStatus;
    }

    /**
     * Set eleve
     *
     * @param \ConnexionBundle\Entity\User $eleve
     *
     * @return HistoryClasse
     */
    public function setEleve(\ConnexionBundle\Entity\User $eleve = null)
    {
        $this->eleve = $eleve;

        return $this;
    }

    /**
     * Get eleve
     *
     * @return \ConnexionBundle\Entity\User
     */
    public function getEleve()
    {
        return $this->eleve;
    }

    /**
     * Set classe
     *
     * @param \BackBundle\Entity\Classe $classe
     *
     * @return HistoryClasse
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
