<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stage
 *
 * @ORM\Table(name="stage")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\StageRepository")
 */
class Stage
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
     * @ORM\Column(name="dateDebut", type="string")
     */
    private $dateDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="dateFin", type="string")
     */
    private $dateFin;

    /**
     * @ORM\ManyToMany (targetEntity="BackBundle\Entity\Techno", cascade={"persist"})
     */
    private $lesTechno;

    /**
     * @ORM\ManyToOne(targetEntity="ConnexionBundle\Entity\User",inversedBy="stage")
     */
    private $leEleve;

    /**
     * @ORM\ManyToOne(targetEntity="ConnexionBundle\Entity\User")
     */
    private $leReferentPro;

    /**
     * @ORM\ManyToOne(targetEntity="ConnexionBundle\Entity\User")
     */
    private $leReferentPeda;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Entreprise")
     */
    private $leEntreprise;

    /**
     * @ORM\OneToMany(targetEntity="BackBundle\Entity\Visite",mappedBy="leStage",cascade={"persist","remove"})
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Stage
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param string $dateFin
     *
     * @return Stage
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return string
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }



    /**
     * Set leEleve
     *
     * @param \ConnexionBundle\Entity\User $leEleve
     *
     * @return Stage
     */
    public function setLeEleve(\ConnexionBundle\Entity\User $leEleve = null)
    {
        $this->leEleve = $leEleve;

        return $this;
    }

    /**
     * Get leEleve
     *
     * @return \ConnexionBundle\Entity\User
     */
    public function getLeEleve()
    {
        return $this->leEleve;
    }

    /**
     * Set leReferentPro
     *
     * @param \ConnexionBundle\Entity\User $leReferentPro
     *
     * @return Stage
     */
    public function setLeReferentPro(\ConnexionBundle\Entity\User $leReferentPro = null)
    {
        $this->leReferentPro = $leReferentPro;

        return $this;
    }

    /**
     * Get leReferentPro
     *
     * @return \ConnexionBundle\Entity\User
     */
    public function getLeReferentPro()
    {
        return $this->leReferentPro;
    }

    /**
     * Set leReferentPeda
     *
     * @param \ConnexionBundle\Entity\User $leReferentPeda
     *
     * @return Stage
     */
    public function setLeReferentPeda(\ConnexionBundle\Entity\User $leReferentPeda = null)
    {
        $this->leReferentPeda = $leReferentPeda;

        return $this;
    }

    /**
     * Get leReferentPeda
     *
     * @return \ConnexionBundle\Entity\User
     */
    public function getLeReferentPeda()
    {
        return $this->leReferentPeda;
    }

    /**
     * Set leEntreprise
     *
     * @param \BackBundle\Entity\Entreprise $leEntreprise
     *
     * @return Stage
     */
    public function setLeEntreprise(\BackBundle\Entity\Entreprise $leEntreprise = null)
    {
        $this->leEntreprise = $leEntreprise;

        return $this;
    }

    /**
     * Get leEntreprise
     *
     * @return \BackBundle\Entity\Entreprise
     */
    public function getLeEntreprise()
    {
        return $this->leEntreprise;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lesTechno = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lesTechno
     *
     * @param \BackBundle\Entity\Techno $lesTechno
     *
     * @return Stage
     */
    public function addLesTechno(\BackBundle\Entity\Techno $lesTechno)
    {
        $this->lesTechno[] = $lesTechno;

        return $this;
    }

    /**
     * Remove lesTechno
     *
     * @param \BackBundle\Entity\Techno $lesTechno
     */
    public function removeLesTechno(\BackBundle\Entity\Techno $lesTechno)
    {
        $this->lesTechno->removeElement($lesTechno);
    }

    /**
     * Get lesTechno
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLesTechno()
    {
        return $this->lesTechno;
    }

    /**
     * Add leStage
     *
     * @param \BackBundle\Entity\Visite $leStage
     *
     * @return Stage
     */
    public function addLeStage(\BackBundle\Entity\Visite $leStage)
    {
        $this->leStage[] = $leStage;

        return $this;
    }

    /**
     * Remove leStage
     *
     * @param \BackBundle\Entity\Visite $leStage
     */
    public function removeLeStage(\BackBundle\Entity\Visite $leStage)
    {
        $this->leStage->removeElement($leStage);
    }

    /**
     * Get leStage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLeStage()
    {
        return $this->leStage;
    }
}
