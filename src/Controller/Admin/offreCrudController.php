<?php

namespace App\Controller\Admin;

use App\Entity\offre;
use Doctrine\ORM\Query\AST\UpdateItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class offreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return offre::class;
    }

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

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('titre'),
            TextEditorField::new('description'),
            TextField::new('localisation'),
            ChoiceField::new('statut')
            ->setChoices([
                'En attente' => 'En attente',
                'Accepter' => 'Accepter',
                'Refuser' => 'Refuser',
            ])
            ->allowMultipleChoices(false),
        ];
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
        ->add('id')
        ->add('titre')
        ->add('description')
        ->add('date')
        ->add('localisation')
        ->add('contact')
        ->add('budget')
        ->add('budget_max')
        ->add('statut');
        
    }
}
