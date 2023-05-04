<?php

namespace App\Controller;

use App\Entity\offre;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[Route('/user')]
class UserController extends AbstractController
{
    


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/{id}', name: 'app_profile', methods: ['GET'])]
    public function showProfile(User $user, EntityManagerInterface $entityManager): Response
    {
        $related_offers = $entityManager->getRepository(Offre::class)->findBy([
            'user' => $user,
        ]);
        return $this->render('user/show2.html.twig', [
            'user' => $user,
            'related_offers' => $related_offers,
        ]);
    }
    

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                ));
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);

        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('name'),
            TextField::new('last_name'),
            EmailField::new('email')
            ->setFormTypeOption('disabled','disabled'),
            ArrayField::new('roles'),
            TextField::new('address'),
            ChoiceField::new('gender')
            ->setRequired(true)   
            ->setChoices([
               'Male' => 'male',
               'Female' => 'female',
               ])
               ->setFormTypeOptions([
                'expanded' => true,
                'multiple' => false,
               ])
               ->allowMultipleChoices(false),
               
            ChoiceField::new('region')
               ->setChoices([
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
               ])
               ->allowMultipleChoices(false),
            DateField::new('birth_date'),
            ChoiceField::new('region')
               ->setChoices([
                   'informatique' => 'informatique',
                   'design' => 'design',
               ])
               ->allowMultipleChoices(false),
            IntegerField::new('phone'),
            IntegerField::new('experience'),
            IntegerField::new('salaire'),
            ImageField::new('image')
            ->setFormType(VichImageType::class)
            ->setUploadDir('public/images/user')
            ->setFormTypeOption('allow_download', false),
            DateTimeField::new('created_at')
            ->setFormTypeOption('disabled','disabled'),   
            TextEditorField::new('description'),
            
        ];
    }

}
