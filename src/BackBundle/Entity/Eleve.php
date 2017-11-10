<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eleve
 *
 * @ORM\Table(name="eleve")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\EleveRepository")
 */
class Eleve
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
     * @var \DateTime
     *
     * @ORM\Column(name="bacyear", type="datetime")
     */
    private $bacyear;


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
     * Set bacyear
     *
     * @param \DateTime $bacyear
     *
     * @return Eleve
     */
    public function setBacyear($bacyear)
    {
        $this->bacyear = $bacyear;

        return $this;
    }

    /**
     * Get bacyear
     *
     * @return \DateTime
     */
    public function getBacyear()
    {
        return $this->bacyear;
    }
}

