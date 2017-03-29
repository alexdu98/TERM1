<?php

namespace AmbigussBundle\Repository;

/**
 * MotAmbiguPhraseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MotAmbiguPhraseRepository extends \Doctrine\ORM\EntityRepository
{
	public function findByIdPhrase($idPhrase){
		return $this->createQueryBuilder('pma')
			->innerJoin("pma.motAmbigu", "ma", "WITH", "pma.motAmbigu = ma.id")->addSelect("ma")
			->innerJoin("ma.gloses", "g")->addSelect("g")
			->where("pma.phrase = :phrase")->setParameter("phrase", $idPhrase)
			->getQuery()->getResult();
	}

	/**
	 * Retoune un tableau de tableau avec un champ correspondant à l'id d'une phrase non joué par le membre
	 * @param $membre
	 *
	 * @return array
	 */
	public function findIdPhrasesNotPlayedByMembre($membre){
		return $this->createQueryBuilder('pma')->select('identity(pma.phrase)')->distinct()
			->leftJoin('pma.reponses', 'r', "WITH", "pma.id = r.motAmbiguPhrase AND r.auteur = :auteur")
			->setParameter('auteur', $membre)
			->where('r.id is null')
			->getQuery()->getArrayResult();
	}

	/**
	 * Retoune un tableau de tableau avec un champ correspondant à l'id d'une phrase non joué par l'ip depuis since
	 * @param $ip
	 * @param $since
	 *
	 * @return array
	 */
	public function findIdPhrasesNotPlayedByIpSince($ip, $since){
		return $this->createQueryBuilder('pma')->select('identity(pma.phrase)')->distinct()
			->leftJoin('pma.reponses', 'r', "WITH", "pma.id = r.motAmbiguPhrase AND r.ip = :ip AND r.dateReponse >= :since")
			->setParameter('ip', $ip)->setParameter('since', $since)
			->where('r.id is null')
			->getQuery()->getArrayResult();
	}

	/**
	 * Retourne un tableau de tableau avec un champ correspondant à l'id d'une phrase qui est l'une des moins jouée
	 * @param $maxResult
	 *
	 * @return array
	 */
	public function findIdPhrasesByLessNumberReponse($maxResult){
		return $this->createQueryBuilder('pma')->select('identity(pma.phrase), count(pma.phrase) as nbRep')
			->leftJoin('pma.reponses', 'r', "WITH", "pma.id = r.motAmbiguPhrase")
			->groupBy('pma.phrase')
			->orderBy('r.dateReponse')
			->setMaxResults($maxResult)
			->getQuery()->getArrayResult();
	}
}
