<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * MotAmbigu
 *
 * @ORM\Table(
 *     name="mot_ambigu",
 *     indexes={
 *         @ORM\Index(name="ix_motamb_dtcreat", columns={"date_creation"}),
 *         @ORM\Index(name="ix_motamb_dtmodif", columns={"date_modification"}),
 *         @ORM\Index(name="ix_motamb_modifid", columns={"modificateur_id"}),
 *         @ORM\Index(name="ix_motamb_autid", columns={"auteur_id"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="uc_motamb_val", columns={"valeur"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MotAmbiguRepository")
 */
class MotAmbigu
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
     * @ORM\Column(name="valeur", type="string", length=32, unique=true, options={"collation":"utf8_bin"})
     */
    private $valeur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modification", type="datetime", nullable=true)
     */
    private $dateModification;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="signale", type="boolean")
	 */
	private $signale;

	/**
	 * @var bool
	 *
	 * @ORM\Column(name="visible", type="boolean")
     */
	private $visible;

	/**
	 * @ORM\ManyToOne(targetEntity="Membre", inversedBy="motsAmbigus")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $auteur;

	/**
	 * @ORM\ManyToOne(targetEntity="Membre")
	 */
	private $modificateur;

    /**
     * @ORM\ManyToMany(targetEntity="Glose", inversedBy="motsAmbigus", cascade={"persist"})
     * @ORM\JoinTable(name="mot_ambigu_glose")
     */
    private $gloses = array();


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
	    $this->signale = false;
	    $this->visible = true;
	    $this->gloses = new ArrayCollection();
    }

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
     * Get dateCreation
     *
     * @return \DateTime
     */
	public function getDateCreation()
    {
	    return $this->dateCreation;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return MotAmbigu
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateModification
     *
     * @return \DateTime
     */
	public function getDateModification()
    {
	    return $this->dateModification;
    }

    /**
     * Set dateModification
     *
     * @param \DateTime $dateModification
     *
     * @return MotAmbigu
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get visible
     *
     * @return bool
     */
	public function getVisible()
    {
	    return $this->visible;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return MotAmbigu
     */
	public function setVisible($visible)
    {
	    $this->visible = $visible;

        return $this;
    }

    /**
     * Add glose
     *
     * @param Glose $glose
     *
     * @return MotAmbigu
     */
    public function addGlose(Glose $glose)
    {
        $this->gloses[] = $glose;

        return $this;
    }

    /**
     * Remove glose
     *
     * @param Glose $glose
     */
    public function removeGlose(Glose $glose)
    {
        $this->gloses->removeElement($glose);
    }

    /**
     * Get gloses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGloses()
    {
        return $this->gloses;
    }

	/**
	 * Add glose if not exist
	 *
	 * @param Glose $glose
	 *
	 * @return MotAmbigu
	 */
	public function addGloseIfNotExist(Glose $glose)
	{
		$this->gloses[ $glose->getId() ] = $glose;

		return $this;
	}

	/**
	 * Get signale
	 *
	 * @return boolean
	 */
	public function getSignale()
	{
		return $this->signale;
	}

	/**
	 * Set signale
	 *
	 * @param boolean $signale
	 *
	 * @return MotAmbigu
	 */
	public function setSignale($signale)
	{
		$this->signale = $signale;

		return $this;
	}

	/**
	 * Get auteur
	 *
	 * @return Membre
	 */
	public function getAuteur()
	{
		return $this->auteur;
	}

	/**
	 * Set auteur
	 *
	 * @param Membre $auteur
	 *
	 * @return MotAmbigu
	 */
	public function setAuteur(Membre $auteur)
	{
		$this->auteur = $auteur;

		return $this;
	}

	/**
	 * Get modificateur
	 *
	 * @return Membre
	 */
	public function getModificateur()
	{
		return $this->modificateur;
	}

	/**
	 * Set modificateur
	 *
	 * @param Membre $modificateur
	 *
	 * @return MotAmbigu
	 */
	public function setModificateur(Membre $modificateur = null)
	{
		$this->modificateur = $modificateur;

		return $this;
	}

	/**
	 * Normalise le mot ambigu
	 */
	public function normalize()
	{
		// Supprime les espaces multiples
		$this->setValeur(preg_replace('#\s+#', ' ', $this->getValeur()));

        // Trim
        $this->setValeur(trim($this->getValeur()));
	}

	/**
	 * Get valeur
	 *
	 * @return string
	 */
	public function getValeur()
	{
		return $this->valeur;
	}

	/**
	 * Set valeur
	 *
	 * @param string $valeur
	 *
	 * @return MotAmbigu
	 */
	public function setValeur($valeur)
	{
		$this->valeur = $valeur;

		return $this;
	}

    public function __toString()
    {
        return $this->valeur;
    }

}
