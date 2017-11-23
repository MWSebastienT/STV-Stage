<?php

namespace ConnexionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * LogBruteForce
 *
 * @ORM\Table(name="log_brute_force")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\LogBruteForceRepository")
 */
class LogBruteForce
{


    public function __construct()
    {
        $this->dateFailure = new \DateTime('now');
    }

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
     * @ORM\Column(name="ip", type="string", length=20)
     */
    private $ip;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $dateFailure;


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
     * Set ip
     *
     * @param string $ip
     *
     * @return LogBruteForce
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set dateFailure
     *
     * @param \dateTime $dateFailure
     *
     * @return LogBruteForce
     */
    public function setDateFailure(\dateTime $dateFailure)
    {
        $this->dateFailure = $dateFailure;

        return $this;
    }

    /**
     * Get dateFailure
     *
     * @return \dateTime
     */
    public function getDateFailure()
    {
        return $this->dateFailure;
    }
}
