<?php

namespace AmbigussBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MotAmbiguType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('valeur', TextType::class, array(
	        	'label' => 'Mot ambigu',
		        'attr' => array('placeholder' => 'Mot ambigu'),
		        'invalid_message' => 'Mot ambigu invalide',
		        'disabled' => true
	        ))
	        ->add('gloses', EntityType::class, array(
		        'class' => 'AmbigussBundle\Entity\Glose',
		        'choice_label' => 'valeur',
		        'label' =>  'Glose',
		        'mapped' => false
	        ));
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