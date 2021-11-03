<?php

namespace App\Form;

use App\Entity\Taxonomy;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MobTaxonomyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $termOptions = [
            'Image' => 'mob_image',
            'Level' => 'mob_level',
            'HP' => 'mob_hp',
            'Spawn' => 'mob_spawn',
            'Drop' => 'mob_drop',
            'Weakness' => 'mob_weakness',
        ];
        $builder
            ->add('term', ChoiceType::class, [
                'required' => true,
                'choices' => $termOptions
            ])
            ->add('value', CKEditorType::class, [
                'required' => true,
            ])
            ->add('post_id', HiddenType::class, [
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
