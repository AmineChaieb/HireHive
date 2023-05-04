<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;


class UserCrudController extends AbstractCrudController
{
    
    
    
    public static function getEntityFqcn(): string
    {
        return User::class;
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
            ->setUploadDir('public/images/user'),
            DateTimeField::new('created_at')
            ->setFormTypeOption('disabled','disabled'),   
            TextEditorField::new('description'),
            
        ];
    }

    // public function configureFields(string $PAGE_INDEX): iterable
    // {
    //     return [
    //         ImageField::new('image_name')
    //         ->setBasePath('images/user')
    //         ->setUploadDir('public/images/user')
    //         ->setUploadedFileNamePattern('[randomhash].[extension]')
    //         ->setRequired(false)
    //     ];
    // }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->add(crud::PAGE_INDEX, Action::DETAIL)
        ->update(crud::PAGE_INDEX,Action::NEW,function(Action $action){
        return $action->setIcon('fa fa-user');
        })
        ->update(crud::PAGE_INDEX,Action::EDIT,function(Action $action){
        return $action->setIcon('fa fa-edit');
        })
        ->update(crud::PAGE_INDEX,Action::DETAIL,function(Action $action){
        return $action->setIcon('fa fa-eye');
        })
        ->update(crud::PAGE_INDEX,Action::DELETE,function(Action $action){
        return $action->setIcon('fa fa-trash');
        });
    }

    
    
    
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        ->add('id')
        ->add('email')
        ->add('name')
        ->add('last_name')
        ->add('address')
        ->add('gender')
        ->add('region')
        ->add('birth_date');
        
    }
}
