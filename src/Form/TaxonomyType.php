<?php

namespace App\Form;

use App\Entity\Taxonomy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxonomyType extends AbstractType
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
                "Item Name +" . $i => "upgrade_name_" . $i,
                "Item Attribute +" . $i => "upgrade_attribute_" . $i,
                "Item Requirement +" . $i => "upgrade_requirement_" . $i,
            ]);
        }
        $builder
            ->add('term', ChoiceType::class, [
                'choices' => $termOptions
            ])
            ->add('value', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Taxonomy::class,
        ]);
    }
}
