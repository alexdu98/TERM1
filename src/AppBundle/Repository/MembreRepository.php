<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Membre;

class MembreRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Retourne le tableau des $limit premiers joueurs
     *
     * @param int $limit
     * @return array
     */
	public function getClassementGeneral(int $limit){
		return $this->createQueryBuilder('m')
            ->select('m.id, m.username, m.dateInscription, m.pointsClassement')
			->leftJoin("m.phrases", "p")->addSelect('count(distinct p.id) as nbPhrases')
			->leftJoin("p.jAime", "lp", 'with', 'lp.active = 1')->addSelect('count(distinct lp.id) as nbJAime')
			->where("m.pointsClassement > 0")
			->groupBy('m.id')
			->orderBy('m.pointsClassement', 'DESC')
			->setMaxResults($limit)
			->getQuery()->getResult();
	}

    /**
     *
     *
     * @param Membre $membre
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
	public function getPositionClassement(Membre $membre)
	{
		return $this->createQueryBuilder('m')
			->select('count(m) position')
			->where("m.pointsClassement > :points")->setParameter("points", $membre->getPointsClassement())
			->orderBy('m.pointsClassement', 'DESC')
			->getQuery()->getOneOrNullResult()['position'] + 1;
	}

    /**
     * Retourne le nombre de membres activés
     *
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
	public function countEnabled()
	{
		return $this->createQueryBuilder('m')
			->select('count(m) total')
            ->where('m.enabled = 1')
			->getQuery()->getSingleResult()['total'];
	}

    /**
     * Retourne un tableau de statistiques de l'entité
     *
     * @return array
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
	public function getStat()
	{
		$array = array();

		$array['total'] = $this->createQueryBuilder('m')
			                  ->select('count(m) total')
			                  ->getQuery()->getSingleResult()['total'];

		$dateJ30 = new \DateTime();
		$dateJ30->setTimestamp($dateJ30->getTimestamp() - (3600 * 24 * 30));
		$array['inscriptionJ30'] = $this->createQueryBuilder('m')
			                           ->select('count(m) inscriptionJ30')
			                           ->where('m.dateInscription > :j30')->setParameter('j30', $dateJ30)
			                           ->getQuery()->getSingleResult()['inscriptionJ30'];

		$dateJ7 = new \DateTime();
		$dateJ7->setTimestamp($dateJ7->getTimestamp() - (3600 * 24 * 7));
		$array['inscriptionJ7'] = $this->createQueryBuilder('m')
			                          ->select('count(m) inscriptionJ7')
			                          ->where('m.dateInscription > :j7')->setParameter('j7', $dateJ7)
			                          ->getQuery()->getSingleResult()['inscriptionJ7'];

		$dateH24 = new \DateTime();
		$dateH24->setTimestamp($dateH24->getTimestamp() - (3600 * 24));
		$array['inscriptionH24'] = $this->createQueryBuilder('m')
			                           ->select('count(m) inscriptionH24')
			                           ->where('m.dateInscription > :h24')->setParameter('h24', $dateH24)
			                           ->getQuery()->getSingleResult()['inscriptionH24'];

		$array['bannis'] = $this->createQueryBuilder('m')
			                   ->select('count(m) bannis')
			                   ->where('m.banni = 1')
			                   ->getQuery()->getSingleResult()['bannis'];

		$array['inactifs'] = $this->createQueryBuilder('m')
			                     ->select('count(m) inactifs')
			                     ->where('m.enabled = 0')
			                     ->getQuery()->getSingleResult()['inactifs'];

		$array['newsletter'] = $this->createQueryBuilder('m')
			                       ->select('count(m) newsletter')
			                       ->where('m.newsletter = 1')
			                       ->getQuery()->getSingleResult()['newsletter'];

        $array['service'] = $this->createQueryBuilder('m')
            ->select('count(m) service')
            ->where('m.facebookId is not null')
            ->orWhere('m.twitterId is not null')
            ->orWhere('m.googleId is not null')
            ->getQuery()->getSingleResult()['service'];

		$array['homme'] = $this->createQueryBuilder('m')
			                  ->select('count(m) homme')
			                  ->where('m.sexe = :sexe')->setParameter('sexe', 'Homme')
			                  ->getQuery()->getSingleResult()['homme'];

		$array['femme'] = $this->createQueryBuilder('m')
			                  ->select('count(m) femme')
			                  ->where('m.sexe = :sexe')->setParameter('sexe', 'Femme')
			                  ->getQuery()->getSingleResult()['femme'];

		$array['moyPoints'] = $this->createQueryBuilder('m')
			                      ->select('avg(m.pointsClassement) moyPoints')
			                      ->getQuery()->getSingleResult()['moyPoints'];

		$array['moyCredits'] = $this->createQueryBuilder('m')
			                       ->select('avg(m.credits) moyCredits')
			                       ->getQuery()->getSingleResult()['moyCredits'];

		return $array;
	}

}
