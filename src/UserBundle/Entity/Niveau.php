<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Niveau
 *
 * @ORM\Table(name="niveau")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\NiveauRepository")
 */
class Niveau
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
     * @ORM\Column(name="titre", type="string", length=32, unique=true)
     */
    private $titre;

    /**
     * @var int
     *
     * @ORM\Column(name="points_classement_min", type="integer")
     */
    private $pointsClassementMin;

	/**
	 * @var int
	 *
	 * @ORM\OneToOne(targetEntity="Niveau")
	 */
    private $niveauParent;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Niveau
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set pointsClassementMin
     *
     * @param integer $pointsClassementMin
     *
     * @return Niveau
     */
    public function setPointsClassementMin($pointsClassementMin)
    {
        $this->pointsClassementMin = $pointsClassementMin;

        return $this;
    }

    /**
     * Get pointsClassementMin
     *
     * @return int
     */
    public function getPointsClassementMin()
    {
        return $this->pointsClassementMin;
    }

    /**
     * Set niveauParent
     *
     * @param \UserBundle\Entity\Niveau $niveauParent
     *
     * @return Niveau
     */
    public function setNiveauParent(\UserBundle\Entity\Niveau $niveauParent = null)
    {
        $this->niveauParent = $niveauParent;

        return $this;
    }

    /**
     * Get niveauParent
     *
     * @return \UserBundle\Entity\Niveau
     */
    public function getNiveauParent()
    {
        return $this->niveauParent;
    }
}
