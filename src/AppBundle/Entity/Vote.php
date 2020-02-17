<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(
 *     name="vote",
 *     indexes={
 *         @ORM\Index(name="ix_vot_jugid", columns={"jugement_id"}),
 *         @ORM\Index(name="ix_vot_typvotid", columns={"type_vote_id"}),
 *         @ORM\Index(name="ix_vot_autid", columns={"auteur_id"}),
 *         @ORM\Index(name="ix_vot_dtcreat", columns={"date_creation"}),
 *         @ORM\Index(name="ix_vot_dtmodif", columns={"date_modification"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="uc_vot_jugemidautid", columns={"jugement_id", "auteur_id"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 */
class Vote
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
     * @ORM\ManyToOne(targetEntity="Jugement")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jugement;

    /**
     * @ORM\ManyToOne(targetEntity="TypeVote")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeVote;

    /**
     * @ORM\ManyToOne(targetEntity="Membre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auteur;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
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
     * @return Vote
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
     * @return Vote
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get jugement
     *
     * @return Jugement
     */
	public function getJugement()
    {
	    return $this->jugement;
    }

    /**
     * Set jugement
     *
     * @param Jugement $jugement
     *
     * @return Vote
     */
    public function setJugement(Jugement $jugement)
    {
        $this->jugement = $jugement;

        return $this;
    }

    /**
     * Get typevote
     *
     * @return TypeVote
     */
	public function getTypeVote()
    {
	    return $this->typeVote;
    }

    /**
     * Set typevote
     *
     * @param TypeVote $typevote
     *
     * @return Vote
     */
    public function setTypeVote(TypeVote $typevote)
    {
        $this->typeVote = $typevote;

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
     * @return Vote
     */
    public function setAuteur(Membre $auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

}