<?php

namespace AmbigussBundle\Repository;

/**
 * GloseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GloseRepository extends \Doctrine\ORM\EntityRepository
{
	public function findGlosesValueByMotAmbiguValue($valeurMA){
		return $this->createQueryBuilder('g')->select('g.id, g.valeur')
			->innerJoin("g.motsAmbigus", "ma", "WITH", "ma.valeur = :valeurMA")->setParameter('valeurMA', $valeurMA)
			->orderBy("g.valeur")
			->getQuery()->getResult();
	}

	public function findByValeurAutoComplete($valeur){
		return $this->createQueryBuilder('g')->select('g.valeur')
			->where('g.valeur LIKE :valeur')->setParameter('valeur', $valeur . '%')
			->getQuery()->getResult();
	}

	public function findOneOrCreate($glose)
	{
		$entity = $this->findOneByValeur($glose->getValeur());
		if($entity == null){
			$this->_em->persist($glose);
			$this->_em->flush();
			return $glose;
		}
		return $entity;
	}

	public function getSignale()
	{
		return $this->createQueryBuilder('g')
			->innerJoin('g.auteur', 'a', 'WITH', 'g.auteur = a.id')->addSelect('a')
			->leftJoin('g.modificateur', 'm', 'WITH', 'g.modificateur = m.id')->addSelect('m')
			->where('g.signale = 1')
			->getQuery()->getResult();
	}

	public function countSignale()
	{
		return $this->createQueryBuilder('g')
			       ->select('count(g) signale')
			       ->where('g.signale = 1')
			       ->getQuery()->getSingleResult()['signale'];
	}

	public function getStat()
	{
		$array = array();

		$array['total'] = $this->createQueryBuilder('g')
			                  ->select('count(g) total')
			                  ->getQuery()->getSingleResult()['total'];

		$dateJ30 = new \DateTime();
		$dateJ30->setTimestamp($dateJ30->getTimestamp() - (3600 * 24 * 30));
		$array['creationJ30'] = $this->createQueryBuilder('g')
			                        ->select('count(g) creationJ30')
			                        ->where('g.dateCreation > :j30')->setParameter('j30', $dateJ30)
			                        ->getQuery()->getSingleResult()['creationJ30'];

		$dateJ7 = new \DateTime();
		$dateJ7->setTimestamp($dateJ7->getTimestamp() - (3600 * 24 * 7));
		$array['creationJ7'] = $this->createQueryBuilder('g')
			                       ->select('count(g) creationJ7')
			                       ->where('g.dateCreation > :j7')->setParameter('j7', $dateJ7)
			                       ->getQuery()->getSingleResult()['creationJ7'];

		$dateH24 = new \DateTime();
		$dateH24->setTimestamp($dateH24->getTimestamp() - (3600 * 24));
		$array['creationH24'] = $this->createQueryBuilder('g')
			                        ->select('count(g) creationH24')
			                        ->where('g.dateCreation > :h24')->setParameter('h24', $dateH24)
			                        ->getQuery()->getSingleResult()['creationH24'];

		$array['signale'] = $this->createQueryBuilder('g')
			                    ->select('count(g) signale')
			                    ->where('g.signale = 1')
			                    ->getQuery()->getSingleResult()['signale'];

		return $array;
	}
}
