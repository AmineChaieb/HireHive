<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password', PasswordType::class, [
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
            // ->add('imageName')
            ->add('last_name')
            ->add('address')
            ->add('URL_web')
            ->add('URL_git')
            ->add('URL_twitter')
            ->add('URL_insta')
            ->add('URL_fb')
            ->add('gender', ChoiceType::class, [
                'label' => false,
                'expanded' => true,
                'choices' => [
                    'Male' => 'male',
                    'Female' => 'female'
                ],
                'placeholder' => 'Choose a gender',
                'required' => true,
                'label_attr' => [    
                ],
            ])
            ->add('region', ChoiceType::class, [
                'attr' => ['class' => ''],
                'choices'=> [
                'Ariana' => 'Ariana',
               'Béja' => 'Béja',
               'Ben Arous' => 'Ben Arous',
               'Bizerte' => 'Bizerte',
               'Gabès' => 'Gabès',
               'Gafsa' => 'Gafsa',
               'Jendouba' => 'Jendouba',
               'Kairouan' => 'Kairouan',
               'Kasserine' => 'Kasserine',
               'Kebili' => 'Kebili',
               'Kef' => 'Kef',
               'Mahdia' => 'Mahdia',
               'Manouba' => 'Manouba',
               'Medenine' => 'Medenine',
               'Monastir' => 'Monastir',
               'Nabeul' => 'Nabeul',
               'Sfax' => 'Sfax',
               'Sidi Bouzid' => 'Sidi Bouzid',
               'Siliana' => 'Siliana',
               'Sousse' => 'Sousse',
               'Tataouine' => 'Tataouine',
               'Tozeur' => 'Tozeur',
               'Tunis' => 'Tunis',
               'Zaghouan' => 'Zaghouan',
                ],
                'placeholder' => 'Choisir votre region',
                'required' => true,
            ])
            ->add('birth_date', BirthdayType::class, [
                'attr' => ['class' => ''],
                'label' => false,
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'required' => true,
                'years' => range(date('Y') - 100, date('Y') - 18),
                'months' => range(1, 12),
                'days' => range(1, 31),
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'error_bubbling' => true,
                'invalid_message' => 'Please enter a valid date of birth.',
                'constraints' => [
                    new NotBlank(['message' => 'Please enter your date of birth.']),
                ],
                
            ])
            ->add('phone')
            ->add('activity', ChoiceType::class, [
                'attr' => ['class' => ''],
                'choices'=> [
                    'Informatique'=> 'Informatique',
                    'Designer'=> 'Designer'
                ],
                'placeholder' => 'Choisir votre activité',
                'required' => true,
            ])
            ->add('experience')
            ->add('salaire')
            ->add('description', null, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                ],
                'required' => false,
            ])
            
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'mapped' => true,
                'attr' => [
                    'accept' => 'image/*',
                    
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
