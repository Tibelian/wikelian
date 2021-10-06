<?php

namespace App\Controller\Admin;

use App\Entity\Taxonomy;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class TaxonomyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Taxonomy::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->showEntityActionsInlined(true)
        ;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::DELETE)
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {

        $termOptions = [
            "VNUM" => "vnum",
            "Classes" => "job",
            "Sockets" => "sockets",
            "3D Model" => "model3d",
            "Drop Metins" => "drop_stone",
            "Drop Monsters" => "drop_monster",
            "Drop Chests" => "drop_chest",
        ];
        for ($i = 0; $i <= 10; $i++) {
            $termOptions = array_merge($termOptions, [
                "Item Name +" . $i => "item_name_" . $i,
                "Item Attribute +" . $i => "item_attribute_" . $i,
                "Item Requirement +" . $i => "item_requirement_" . $i,
                "Item Upgrade Requirement +" . $i => "upgrade_requirement_" . $i,
            ]);
        }

        return [
            ChoiceField::new('term')->setChoices($termOptions),
            TextareaField::new('value'),
            AssociationField::new('post'),
        ];
    }
    
}
