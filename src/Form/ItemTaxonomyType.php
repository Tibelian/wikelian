<?php

namespace App\Form;

use App\Entity\Taxonomy;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemTaxonomyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
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
        $builder
            ->add('term', ChoiceType::class, [
                'required' => true,
                'choices' => $termOptions
            ])
            ->add('value', CKEditorType::class, [
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Taxonomy::class,
        ]);
    }
}
