<?php

namespace AppBundle\Form\Signalement;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignalementAddType extends AbstractType
{

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->addEventListener(FormEvents::POST_SUBMIT, function($event)
		{
			$event->stopPropagation();
		}, 900);
		$builder
			->add('description', TextareaType::class, array(
				'label' => 'Description',
				'attr' => array('placeholder' => 'Détaillez le motif du signalement'),
			))
			->add('categorieSignalement', EntityType::class, array(
				'class' => 'AppBundle\Entity\CategorieSignalement',
				'choice_label' => 'nom',
				'label' => 'Catégorie',
				'required' => true,
				'attr' => array('placeholder' => 'Détaillez le motif du signalement'),
			))
			// Cas: signaler les objets (glosesn membre et phrase) dans une seule modal
			->add('typeObjet', EntityType::class, array(
				'class' => 'AppBundle\Entity\TypeObjet',
				'choice_label' => 'nom',
				'label' => 'Type de l\'objet',
				'required' => true,
			))
			->remove('dateCreation')
			->remove('dateDeliberation')
			->add('objetId', ChoiceType::class, array(
				'label' => 'Objet',
				'required' => true,
			))
			->remove('verdict')
			->remove('auteur')
			->remove('juge')
			->add('signaler', SubmitType::class, array(
				'label' => 'Signaler',
				'attr' => array(
					'class' => 'btn btn-primary',
				),
			));

	}

	public function setDefaultOptions(OptionsResolver $resolver)
	{
//		$resolver->setDefaults(array(
//			'validation_groups' => false,
//		));
	}

	public function getParent()
	{
		return SignalementType::class;
	}

}
