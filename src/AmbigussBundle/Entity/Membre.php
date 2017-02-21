<?php

namespace AmbigussBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Membre
 *
 * @ORM\Table(name="membre")
 * @ORM\Entity(repositoryClass="AmbigussBundle\Repository\MembreRepository")
 * @UniqueEntity(fields="pseudo", message="Ce pseudo existe déjà.")
 * @UniqueEntity(fields="email", message="Cette adresse mail existe déjà.")
 */
class Membre implements UserInterface, \Serializable
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
     * @ORM\Column(name="pseudo", type="string", length=32, unique=true)
     *
     * @Assert\Regex(
     *     pattern = "#^[a-zA-Z0-9_\.\\-]{3,32}$#",
     *     message = "Pseudo invalide. (3 à 32 caractères alphanumérique)"
     * )
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, unique=true)
     *
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=72)
     *
     * UpperCase|LowerCase & Number|SpecialChar between 6 and 72 char (si je me suis pas trompé)
     * @Assert\Regex(
     *     pattern = "#(?=^.{6,72}$)((?=.*\d)|(?=.*\W+))(?![.\n])((?=.*[A-Z])|(?=.*[a-z])).*$#",
     *     message = "Mot de passe invalide. (alphabétique et numérique ou spécial de 6 à 72 caractères)"
     * )
     */
    private $mdp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscription", type="datetime")
     */
    private $dateInscription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_connexion", type="datetime", nullable=true)
     */
    private $dateConnexion;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=8, nullable=true)
     *
     * @Assert\Regex(
     *     pattern = "#Homme|Femme#",
     *     message = "Sexe invalide. (Homme ou Femme)"
     * )
     */
    private $sexe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="datetime", nullable=true)
     *
     * @Assert\DateTime()
     */
    private $dateNaissance;

    /**
     * @var int
     *
     * @ORM\Column(name="points_classement", type="integer")
     */
    private $pointsClassement;

    /**
     * @var int
     *
     * @ORM\Column(name="credits", type="integer")
     */
    private $credits;

    /**
     * @var string
     *
     * @ORM\Column(name="cle_oubli_mdp", type="string", length=128, nullable=true)
     */
    private $cleOubliMdp;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean")
     *
     * @Assert\NotBlank
     */
    private $newsletter;

    /**
     * @var bool
     *
     * @ORM\Column(name="banni", type="boolean")
     *
     * @Assert\NotBlank
     */
    private $banni;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire_ban", type="string", length=128, nullable=true)
     */
    private $commentaireBan;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deban", type="datetime", nullable=true)
     *
     * @Assert\DateTime()
     */
    private $dateDeban;

    /**
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity="Niveau")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity="MembreRole", mappedBy="membre")
     */
    private $membreRoles;


	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->dateInscription = new \DateTime();
		$this->pointsClassement = 0;
		$this->credits = 0;
		$this->newsletter = true;
		$this->banni = true;
		$this->commentaireBan = "En attente de la validation de l'email";
		$this->membreRoles = new ArrayCollection();
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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Membre
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Membre
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set mdp
     *
     * @param string $mdp
     *
     * @return Membre
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get mdp
     *
     * @return string
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     *
     * @return Membre
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * Set dateConnexion
     *
     * @param \DateTime $dateConnexion
     *
     * @return Membre
     */
    public function setDateConnexion($dateConnexion)
    {
        $this->dateConnexion = $dateConnexion;

        return $this;
    }

    /**
     * Get dateConnexion
     *
     * @return \DateTime
     */
    public function getDateConnexion()
    {
        return $this->dateConnexion;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Membre
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Membre
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set pointsClassement
     *
     * @param integer $pointsClassement
     *
     * @return Membre
     */
    public function setPointsClassement($pointsClassement)
    {
        $this->pointsClassement = $pointsClassement;

        return $this;
    }

    /**
     * Get pointsClassement
     *
     * @return int
     */
    public function getPointsClassement()
    {
        return $this->pointsClassement;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     *
     * @return Membre
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Get credits
     *
     * @return int
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set cleOublimdp
     *
     * @param string $cleOubliMdp
     *
     * @return Membre
     */
    public function setCleOubliMdp($cleOubliMdp)
    {
        $this->cleOubliMdp = $cleOubliMdp;

        return $this;
    }

    /**
     * Get cleOubliMdp
     *
     * @return string
     */
    public function getCleOubliMdp()
    {
        return $this->cleOubliMdp;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return Membre
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set banni
     *
     * @param boolean $banni
     *
     * @return Membre
     */
    public function setBanni($banni)
    {
        $this->banni = $banni;

        return $this;
    }

    /**
     * Get banni
     *
     * @return bool
     */
    public function getBanni()
    {
        return $this->banni;
    }

    /**
     * Set commentaireBan
     *
     * @param string $commentaireBan
     *
     * @return Membre
     */
    public function setCommentaireBan($commentaireBan)
    {
        $this->commentaireBan = $commentaireBan;

        return $this;
    }

    /**
     * Get commentaireBan
     *
     * @return string
     */
    public function getCommentaireBan()
    {
        return $this->commentaireBan;
    }

    /**
     * Set dateDeban
     *
     * @param \DateTime $dateDeban
     *
     * @return Membre
     */
    public function setDateDeban($dateDeban)
    {
        $this->dateDeban = $dateDeban;

        return $this;
    }

    /**
     * Get dateDeban
     *
     * @return \DateTime
     */
    public function getDateDeban()
    {
        return $this->dateDeban;
    }

    /**
     * Set groupe
     *
     * @param \AmbigussBundle\Entity\Groupe $groupe
     *
     * @return Membre
     */
    public function setGroupe(\AmbigussBundle\Entity\Groupe $groupe)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \AmbigussBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set niveau
     *
     * @param \AmbigussBundle\Entity\Niveau $niveau
     *
     * @return Membre
     */
    public function setNiveau(\AmbigussBundle\Entity\Niveau $niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return \AmbigussBundle\Entity\Niveau
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**     
     * Add membreRole       
     *      
     * @param \AmbigussBundle\Entity\MembreRole $membreRole     
     *      
     * @return Membre       
     */     
    public function addMembreRole(\AmbigussBundle\Entity\MembreRole $membreRole)        
    {       
        $this->membreRoles[] = $membreRole;     
        
        $membreRole->setMembre($this);      
        
        return $this;       
    }       
        
    /**     
     * Remove membreRole        
     *      
     * @param \AmbigussBundle\Entity\MembreRole $membreRole     
     */     
    public function removeMembreRole(\AmbigussBundle\Entity\MembreRole $membreRole)     
    {       
        $this->membreRoles->removeElement($membreRole);     
    }       
        
    /**     
     * Get membreRoles      
     *      
     * @return \Doctrine\Common\Collections\Collection      
     */     
    public function getMembreRoles()        
    {       
        return $this->membreRoles;      
    }


	/**
	 * IMPLEMENTS UserInterface
	 */

	/**
	 * Get roles (droits)
	 *
	 * @return array
	 */
	public function getRoles()
    {
		$roles = ["ROLE_VISITEUR"];

        $roles = array_merge($roles, $this->getGroupe()->getRoles());

        foreach ($this->getMembreRoles() as $membreRole) {
            $roles[] = $membreRole->getRole()->getNom();
        }       

        return $roles;
	}

	/**
	 * Get password (mdp)
	 *
	 * @return string
	 */
	public function getPassword(){
		return $this->getMdp();
	}

    /** 
     * Get salt 
     *  
     * @return null (no use with BCryptEncoder) 
     */
	public function getSalt(){
		return null;
	}

	/**
	 * Get username (pseudo)
	 *
	 * @return string
	 */
	public function getUsername(){
		return $this->getPseudo();
	}

	public function eraseCredentials(){}


	/**
	 * IMPLEMENTS Serializable
	 */

	public function serialize(){
		return serialize(array(
			$this->id,
			$this->pseudo,
            $this->email,
			$this->mdp
		));
	}

	public function unserialize($serialized){
		list (
			$this->id,
			$this->pseudo,
            $this->email,
			$this->mdp,
			) = unserialize($serialized);
	}


    /**
     * AUTRES
     */

    /**
     * Génère, initialise et retourne une clé
     *
     * @return string
     */
    public function generateCle(){
        $cle = hash('sha256', uniqid(rand(), true) . "N1TDf^%PEc!G*s$");
        $this->setCleOubliMdp($cle);
        return $cle;
    }
}