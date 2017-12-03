<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="entreprise")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\EntrepriseRepository")
 */
class Entreprise
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="CA", type="integer")
     */
    private $cA;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=255)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var int
     *
     * @ORM\Column(name="telephone", type="integer")
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity="BackBundle\Entity\Stage", mappedBy="leEntreprise")
     */
    private $lesStages;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\typeEntreprise")
     */
    private $leTypeEnt;

    /**
     * @ORM\ManyToMany(targetEntity="ConnexionBundle\Entity\User")
     */
    private $lesReferentPro;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Entreprise
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set cA
     *
     * @param integer $cA
     *
     * @return Entreprise
     */
    public function setCA($cA)
    {
        $this->cA = $cA;

        return $this;
    }

    /**
     * Get cA
     *
     * @return int
     */
    public function getCA()
    {
        return $this->cA;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Entreprise
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return Entreprise
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return Entreprise
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }



    /**
     * Set country
     *
     * @param string $country
     *
     * @return Entreprise
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Entreprise
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }



    /**
     * Set leTypeEnt
     *
     * @param \BackBundle\Entity\Entreprise $leTypeEnt
     *
     * @return Entreprise
     */
    public function setLeTypeEnt(\BackBundle\Entity\typeEntreprise $leTypeEnt = null)
    {
        $this->leTypeEnt = $leTypeEnt;

        return $this;
    }

    /**
     * Get leTypeEnt
     *
     * @return \BackBundle\Entity\typeEntreprise
     */
    public function getLeTypeEnt()
    {
        return $this->leTypeEnt;
    }


    public function __toString()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lesReferentPro = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lesStages = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Add lesStage
     *
     * @param \BackBundle\Entity\Stage $lesStage
     *
     * @return Entreprise
     */
    public function addLesStage(\BackBundle\Entity\Stage $lesStage)
    {
        $this->lesStages[] = $lesStage;

        return $this;
    }

    /**
     * Remove lesStage
     *
     * @param \BackBundle\Entity\Stage $lesStage
     */
    public function removeLesStage(\BackBundle\Entity\Stage $lesStage)
    {
        $this->lesStages->removeElement($lesStage);
    }

    /**
     * Get lesStages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLesStages()
    {
        return $this->lesStages;
    }

    /**
     * Add lesReferentPro
     *
     * @param \ConnexionBundle\Entity\User $lesReferentPro
     *
     * @return Entreprise
     */
    public function addLesReferentPro(\ConnexionBundle\Entity\User $lesReferentPro)
    {
        $this->lesReferentPro[] = $lesReferentPro;

        return $this;
    }

    /**
     * Remove lesReferentPro
     *
     * @param \ConnexionBundle\Entity\User $lesReferentPro
     */
    public function removeLesReferentPro(\ConnexionBundle\Entity\User $lesReferentPro)
    {
        $this->lesReferentPro->removeElement($lesReferentPro);
    }

    /**
     * Get lesReferentPro
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLesReferentPro()
    {
        return $this->lesReferentPro;
    }
}
