<?php

namespace App\Form;

use App\Entity\User;
use PhpParser\Node\Stmt\Label;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('name')
            ->add('last_name')
            ->add('address')
            ->add('gender', ChoiceType::class, [
                'expanded'=> 'true',
                'choices'=> [
                    'Male' => 'male',
                    'Female' => 'female'
                ],
                
                'placeholder' => 'Choose a gender',
                'required' => true,
                
            ])
            ->add('region', ChoiceType::class, [
                'choices'=> [
                    'Monastir'=> 0,
                    'Tunis'=> 1
                ],
                'placeholder' => 'Choisir votre region',
                'required' => true,
            ])
            ->add('birth_date',BirthdayType::class, [
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('phone')
            ->add('activity', ChoiceType::class, [
                'choices'=> [
                    'Informatique'=> 0,
                    'Designer'=> 1
                ],
                'placeholder' => 'Choisir votre activité',
                'required' => true,
            ])
            ->add('experience', null, [
                'required' => false,
            ])
            ->add('salaire', null, [
                'required' => false,
            ])
            ->add('imageFile', VichImageType::class,[
                'label' => 'Inserer votre image',
                'label_attr' =>[
                    'class' => 'form-label mt-4'
                ],
                'required' => false,
            ])
            //->add('created-at')
            ->add('description',TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
