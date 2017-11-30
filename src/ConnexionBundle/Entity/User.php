<?php

namespace ConnexionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\UserRepository")
 * @ORM\AttributeOverrides({
 *              @ORM\AttributeOverride(name="email", column=@ORM\Column(nullable=true)),
 *              @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(nullable=true))
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /* mes attributs rajouté en plus de ceux de fos suer */

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=20, nullable=true)
     */
    protected $firstName;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\ClassePromo")
     */
    private $classePromo;


    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=20, nullable=true)
     */
    protected $lastName;

    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer", length=20, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=20, nullable=true)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=20, nullable=true)
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="zipCode", type="string", length=20, nullable=true)
     */
    protected $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="obtention_bac", type="string",nullable=true, nullable=true)
     */
    protected $obtention_bac;

    /**
     * @ORM\ManyToMany (targetEntity="BackBundle\Entity\Diplome", cascade={"persist"})
     */
    private $lesDiplomes;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Entreprise", inversedBy="lesReferentPro")
     */
    private $leEntreprise;

    /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\HistoryClasse")
     */
    protected $history;




    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
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
     * Set address
     *
     * @param string $adress
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return User
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
     * Add lesDiplome
     *
     * @param \BackBundle\Entity\Diplome $lesDiplome
     *
     * @return User
     */
    public function addLesDiplome(\BackBundle\Entity\Diplome $lesDiplome)
    {
        $this->lesDiplomes[] = $lesDiplome;

        return $this;
    }

    /**
     * Remove lesDiplome
     *
     * @param \BackBundle\Entity\Diplome $lesDiplome
     */
    public function removeLesDiplome(\BackBundle\Entity\Diplome $lesDiplome)
    {
        $this->lesDiplomes->removeElement($lesDiplome);
    }

    /**
     * Get lesDiplomes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLesDiplomes()
    {
        return $this->lesDiplomes;
    }


    /**
     * Set leEntreprise
     *
     * @param \BackBundle\Entity\Entreprise $leEntreprise
     *
     * @return User
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
     * Set obtentionBac
     *
     * @param string $obtentionBac
     *
     * @return User
     */
    public function setObtentionBac($obtentionBac)
    {
        $this->obtention_bac = $obtentionBac;

        return $this;
    }

    /**
     * Get obtentionBac
     *
     * @return string
     */
    public function getObtentionBac()
    {
        return $this->obtention_bac;
    }



    /**
     * Set classe
     *
     * @param \BackBundle\Entity\Classe $classe
     *
     * @return User
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
     * Set classePromo
     *
     * @param \BackBundle\Entity\ClassePromo $classePromo
     *
     * @return User
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

    /**
     * Set history
     *
     * @param \BackBundle\Entity\HistoryClasse $history
     *
     * @return User
     */
    public function setHistory(\BackBundle\Entity\HistoryClasse $history = null)
    {
        $this->history = $history;

        return $this;
    }

    /**
     * Get history
     *
     * @return \BackBundle\Entity\HistoryClasse
     */
    public function getHistory()
    {
        return $this->history;
    }
}
