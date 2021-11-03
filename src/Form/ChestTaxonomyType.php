<?php

namespace App\Form;

use App\Entity\Taxonomy;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChestTaxonomyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $termOptions = [
            'Level' => 'chest_level',
            'Origin' => 'chest_origin',
            'Drop' => 'chest_drop',
        ];
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
