<?php

namespace AmbigussBundle\Repository;

/**
 * PhraseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PhraseRepository extends \Doctrine\ORM\EntityRepository
{
    public function getClassementPhrases($limit){
	    return $this->createQueryBuilder('p')->select("p.id, p.contenu, p.dateCreation, p.gainCreateur")->distinct()
		    ->addSelect('(SELECT COUNT(lp2.id) FROM AmbigussBundle\Entity\AimerPhrase lp2 WHERE lp2.phrase = p.id AND lp2.active = 1) as nbLikes')
		    ->leftJoin("p.likesPhrase", "lp", 'WITH', 'lp.id = p.id')
            ->groupBy('p.id')
            ->orderBy('nbLikes', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

	public function getClassementPhrasesUser($user)
	{
		return $this->createQueryBuilder('p')->select('p.id, p.contenu, p.dateCreation, p.gainCreateur')->distinct()
			->addSelect('(SELECT COUNT(lp2.id) FROM AmbigussBundle\Entity\AimerPhrase lp2 WHERE lp2.phrase = p.id AND lp2.active = 1) as nbLikes')
			->leftJoin("p.likesPhrase", "lp", 'WITH', 'lp.id = p.id')
			->where('p.auteur = :user')->setParameter('user', $user)
			->groupBy('p.id')
			->orderBy('p.gainCreateur', 'DESC')
			->getQuery()->getResult();
	}

    public function getSignale()
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.auteur', 'a', 'WITH', 'g.auteur = a.id')->addSelect('a')
            ->leftJoin('g.modificateur', 'm', 'WITH', 'g.modificateur = m.id')->addSelect('m')
            ->where('g.signale = 1')
            ->andWhere('g.visible=1')
            ->getQuery()->getResult();
    }

	/**
	 * Retoune un tableau de tableau avec un champ correspondant à l'id d'une phrase non joué et existante depuis plus de $dureeAv par le membre
	 *
	 * @param $membre
	 * @param $maxResult
	 * @param $dureeAvantJouabiliteSecondes
	 *
	 * @return array
	 */
	public function findIdPhrasesNotPlayedByMembre($membre, $dureeAvantJouabiliteSecondes)
	{
		$date = new \DateTime();
		$dateMin = $date->setTimestamp($date->getTimestamp() - $dureeAvantJouabiliteSecondes);

		$sub = $this->_em->getRepository('AmbigussBundle:Partie')->createQueryBuilder('pa')
			->select('identity(pa.phrase)')
			->where('pa.joueur = :membre')
			->andWhere('pa.joue = 1');

		$q = $this->createQueryBuilder('ph');

		return $q->select('ph.id')
			->where($q->expr()->notIn('ph.id', $sub->getDQL()))
			->andWhere('ph.dateCreation < :dateMin')
			->andWhere('ph.auteur != :membre')
			->setParameter('dateMin', $dateMin->format('Y-m-d H:i:s'))
			->setParameter('membre', $membre)
			->getQuery()->getArrayResult();
	}

	public function countAll()
	{
		return $this->createQueryBuilder('p')
			->select('count(p) nbPhrases')
			->getQuery()->getSingleResult();
	}

	public function findLike($contenuPur)
	{
		return $this->createQueryBuilder('p')
			->select('p.id, p.contenu, p.auteur, p.dateCreation, p.modificateur, p.dateModification, p.signale, p.visible, p.gainCreateur')
			->where('p.contenuPur LIKE :contenuPur')->setParameter('contenuPur', '%' . $contenuPur . '%')
			->getQuery()->getResult();
	}

	public function countSignale()
	{
		return $this->createQueryBuilder('p')
			       ->select('count(p) signale')
			       ->where('p.signale = 1')
			       ->getQuery()->getSingleResult()['signale'];
	}

	public function getStat()
	{
		$array = array();

		$array['total'] = $this->createQueryBuilder('p')
			                  ->select('count(p) total')
			                  ->getQuery()->getSingleResult()['total'];

		$dateJ30 = new \DateTime();
		$dateJ30->setTimestamp($dateJ30->getTimestamp() - (3600 * 24 * 30));
		$array['creationJ30'] = $this->createQueryBuilder('p')
			                        ->select('count(p) creationJ30')
			                        ->where('p.dateCreation > :j30')->setParameter('j30', $dateJ30)
			                        ->getQuery()->getSingleResult()['creationJ30'];

		$dateJ7 = new \DateTime();
		$dateJ7->setTimestamp($dateJ7->getTimestamp() - (3600 * 24 * 7));
		$array['creationJ7'] = $this->createQueryBuilder('p')
			                       ->select('count(p) creationJ7')
			                       ->where('p.dateCreation > :j7')->setParameter('j7', $dateJ7)
			                       ->getQuery()->getSingleResult()['creationJ7'];

		$dateH24 = new \DateTime();
		$dateH24->setTimestamp($dateH24->getTimestamp() - (3600 * 24));
		$array['creationH24'] = $this->createQueryBuilder('p')
			                        ->select('count(p) creationH24')
			                        ->where('p.dateCreation > :h24')->setParameter('h24', $dateH24)
			                        ->getQuery()->getSingleResult()['creationH24'];

		$array['signale'] = $this->createQueryBuilder('p')
			                    ->select('count(p) signale')
			                    ->where('p.signale = 1')
			                    ->getQuery()->getSingleResult()['signale'];

		$array['moyGain'] = $this->createQueryBuilder('p')
			                    ->select('avg(p.gainCreateur) moyGain')
			                    ->getQuery()->getSingleResult()['moyGain'];

		return $array;
	}
}
