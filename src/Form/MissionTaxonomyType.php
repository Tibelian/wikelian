<?php

namespace App\Form;

use App\Entity\Taxonomy;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionTaxonomyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $termOptions = [];
        // max 20 quests per mission
        for ($i = 1; $i <= 20; $i++) {
            $termOptions = array_merge($termOptions, [
                $i.". Level" => "quest_level_".$i,
                $i.". Requirement" => "quest_requirement_".$i,
                $i.". Reward" => "quest_reward_".$i,
                $i.". Cooldown" => "quest_cooldown_".$i,
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
