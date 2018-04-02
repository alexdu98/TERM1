<?php

namespace AppBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;

class JugementExtension extends \Twig_Extension
{

	private $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function nbPhrasesSignale()
	{
		return $this->em->getRepository('AppBundle:Phrase')->countSignale();
	}

	public function nbGlosesSignale()
	{
		return $this->em->getRepository('AppBundle:Glose')->countSignale();
	}

	public function getFunctions()
	{
		return array(
			new \Twig_SimpleFunction('nbPhrasesSignale', array(
				$this,
				'nbPhrasesSignale',
			)),
			new \Twig_SimpleFunction('nbGlosesSignale', array(
				$this,
				'nbGlosesSignale',
			)),
		);
	}

	public function getName()
	{
		return 'Signale';
	}
}