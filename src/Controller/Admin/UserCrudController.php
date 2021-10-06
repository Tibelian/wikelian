<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Field\PasswordField;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::DELETE)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            EmailField::new('email'),
            PasswordField::new('plainPassword')->setRequired(true)->onlyOnForms(),
            ChoiceField::new('roles')->setChoices([
                'User' => 'ROLE_USER',
                'Editor' => 'ROLE_EDITOR',
                'Moderator' => 'ROLE_MOD',
                'Administrator' => 'ROLE_ADMIN',
            ])->allowMultipleChoices(true),
        ];
    }
}
