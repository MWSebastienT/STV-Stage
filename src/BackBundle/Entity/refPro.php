<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * refPro
 *
 * @ORM\Table(name="ref_pro")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\refProRepository")
 */
class refPro
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
     * @ORM\Column(name="fonction", type="string", length=255)
     */
    private $fonction;


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
     * Set fonction
     *
     * @param string $fonction
     *
     * @return refPro
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }
}

