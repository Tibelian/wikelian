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
            "CLASSES" => "job",
            "SOCKETS" => "sockets",
            "3D Model" => "model3d",
            "DROP METINS" => "drop_stone",
            "DROP MONSTERS" => "drop_monster",
            "DROP CHESTS" => "drop_chest",
        ];
        for ($i = 0; $i <= 10; $i++) {
            $termOptions = array_merge($termOptions, [
                "ITEM NAME +" . $i => "upgrade_name_" . $i,
                "ITEM ATTRIBUTE +" . $i => "upgrade_attribute_" . $i,
                "ITEM REQUIREMENT +" . $i => "upgrade_requirement_" . $i,
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
