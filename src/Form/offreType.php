<?php

namespace App\Form;

use App\Entity\offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class offreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date', DateType::class, [
                'attr' => ['class' => 'js-datepicker'],
           ])
            ->add('localisation')
            ->add('contact')
            ->add('budget')
            ->add('budget_max')
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => offre::class,
        ]);
    }
}
