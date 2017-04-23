<?php

namespace AmbigussBundle\Repository;

/**
 * MotAmbiguRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MotAmbiguRepository extends \Doctrine\ORM\EntityRepository
{
	public function findOneOrCreate($motAmbigu)
	{
		$entity = $this->findOneByValeur($motAmbigu->getValeur());
		if($entity == null){
			$this->_em->persist($motAmbigu);
			$this->_em->flush();
			return $motAmbigu;
		}
		return $entity;
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

}
