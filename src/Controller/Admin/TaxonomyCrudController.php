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
use FOS\CKEditorBundle\Form\Type\CKEditorType;

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
            ->update(Crud::PAGE_INDEX, Action::DELETE, function(Action $action) {
                return $action->setCssClass('d-none');
            })
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {

        // items
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

        // chests
        $termOptions = array_merge($termOptions, [
            'Level' => 'chest_level',
            'Origin' => 'chest_origin',
            'Drop' => 'chest_drop',
        ]);
        
        // maps
        $termOptions = array_merge($termOptions, [
            "Image" => "image",
            "Entry Requirement" => "entry_requirement",
            "Spawn Monster" => "spawn_monster",
            "Spawn Stones" => "spawn_stone",
            "Spawn Ore Vein" => "spawn_ore",
        ]);

        // missions
        for ($i = 1; $i <= 20; $i++) {
            $termOptions = array_merge($termOptions, [
                $i.". Level" => "quest_level_".$i,
                $i.". Requirement" => "quest_requirement_".$i,
                $i.". Reward" => "quest_reward_".$i,
                $i.". Cooldown" => "quest_cooldown_".$i,
            ]);
        }

        // mobs
        $termOptions = array_merge($termOptions, [
            'Image' => 'mob_image',
            'Level' => 'mob_level',
            'HP' => 'mob_hp',
            'Spawn' => 'mob_spawn',
            'Drop' => 'mob_drop',
            'Weakness' => 'mob_weakness',
        ]);

        return [
            ChoiceField::new('term')->setChoices($termOptions),
            TextareaField::new('value')->setFormType(CKEditorType::class),
            AssociationField::new('post'),
        ];
    }
    
}
