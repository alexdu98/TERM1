<?php
namespace AmbigussBundle\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MotAmbiguAddPhraseType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('valeur', TextType::class, array(
				'label' => 'Mot ambigu',
				'attr' => array('placeholder' => 'Mot ambigu', 'class' => 'amb', 'readonly' => 'true', 'style'=> 'width : auto', 'max_lenght' => 100000),
				'invalid_message' => 'Mot ambigu invalide',
			))
			->add('gloses', EntityType::class, array(
				'class' => 'AmbigussBundle\Entity\Glose',
				'choice_label' => 'valeur',
				'label' =>  'Choisissez la glose associée',
				'mapped' => false,
				'attr' => array( 'style' => 'width : auto')
			))
			->add('poidsReponse', EntityType::class, array(
				'class' => 'AmbigussBundle\Entity\PoidsReponse',
				'choice_label' => 'poidsReponse',
				'label' =>  'Choississez le poids de cette glose',
				'mapped' => false,
				'attr' => array( 'style' => 'width : 60px')
				)
			);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AmbigussBundle\Entity\MotAmbigu'
		));
	}
	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'ambigussbundle_motambigu';
	}
}