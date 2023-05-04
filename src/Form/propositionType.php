<?php

namespace App\Form;

use App\Entity\proposition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class propositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isOwner = $options['is_owner'];
        $builder
            // ->add('id')
            ->add('proposition')
            
            // ->add('offre')
            // ->add('user')
            ->add('Description')
            ->add('created_at')
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => 'en_attente',
                    'Accepter' => 'accepte',
                    'Réfuser' => 'refuse',
                    'En cours' => 'en_cours',
                ],
                'disabled' => !$isOwner,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => proposition::class,
            'is_owner' => false,
        ]);
    }
}
