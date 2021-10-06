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
            "CLASSES" => "job",
            "SOCKETS" => "sockets",
            "DROP METINS" => "drop_stone",
            "DROP MONSTERS" => "drop_monster",
            "DROP CHESTS" => "drop_chest",
            "3D Model" => "model3d",
        ];
        for ($i = 0; $i <= 10; $i++) {
            $termOptions = array_merge($termOptions, [
                "ITEM NAME +" . $i => "upgrade_name_" . $i,
                "ITEM ATTRIBUTE +" . $i => "upgrade_attribute_" . $i,
                "UPGRADE ITEM REQUIREMENT +" . $i => "upgrade_requirement_" . $i,
            ]);
        }

        return [
            ChoiceField::new('term')->setChoices($termOptions),
            TextareaField::new('value'),
            AssociationField::new('post'),
        ];
    }
    
}
