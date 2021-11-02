<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImportDatabaseType extends AbstractType
{
    private $itemTypes = ['ITEM_NONE','ITEM_WEAPON','ITEM_ARMOR','ITEM_USE','ITEM_AUTOUSE','ITEM_MATERIAL','ITEM_SPECIAL','ITEM_TOOL','ITEM_LOTTERY','ITEM_ELK','ITEM_METIN','ITEM_CONTAINER','ITEM_FISH','ITEM_ROD','ITEM_RESOURCE','ITEM_CAMPFIRE','ITEM_UNIQUE','ITEM_SKILLBOOK','ITEM_QUEST','ITEM_POLYMORPH','ITEM_TREASURE_BOX','ITEM_TREASURE_KEY','ITEM_SKILLFORGET','ITEM_GIFTBOX','ITEM_PICK','ITEM_HAIR','ITEM_TOTEM','ITEM_BLEND','ITEM_COSTUME','ITEM_DS','ITEM_SPECIAL_DS','ITEM_EXTRACT','ITEM_SECONDARY_COIN','ITEM_RING','ITEM_BELT'];
    private $mobTypes = ['UNDEFINED','ANIMAL','UNDEAD','DEVIL','DESERT','HUMAN','ORC','MILGYO','INSECT','FIRE','ICE'];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('db_host', TextType::class)
            ->add('db_user', TextType::class)
            ->add('db_pass', TextType::class, [
                'required' => false
            ])
            ->add('db_name', HiddenType::class, [
                'data' => 'player'
            ])
            ->add('db_port', IntegerType::class, [
                'data' => 3306
            ])
            ->add('pref_icons', ChoiceType::class, [
                'choices' => [
                    'Without icons' => '',
                    'M2IconDB - m2icondb.com' => 'https://img.m2icondb.com/',
                    'Metin2CMS ItemDB - metin2cms.cf' => 'https://metin2cms.cf/items/img/icons/',
                ]
            ])
            ->add('pref_3dmodel', ChoiceType::class, [
                'choices' => [
                    'Without 3D Models' => '',
                    'M2IconDB - m2icondb.com' => 'https://m2icondb.com/3d',
                ]
            ])
        ;
        
        $allCategories = $options['doctrine']->getRepository(Category::class)->findAll();

        foreach ($this->itemTypes as $type)
        { 
            $options = [
                'class' => Category::class,
                'choices' => $allCategories,
                'required' => false,
            ];
            $defaultCat = $this->checkCategory($type, $allCategories);
            if ($defaultCat !== null)  {
                $options = array_merge($options, [
                    'data' => $defaultCat
                ]);
            }
            $builder
                ->add($type, EntityType::class, $options);
        }
        
        foreach ($this->mobTypes as $type)
        { 
            $options = [
                'class' => Category::class,
                'choices' => $allCategories,
                'required' => false,
            ];
            $defaultCat = $this->checkCategory($type, $allCategories);
            if ($defaultCat !== null)  {
                $options = array_merge($options, [
                    'data' => $defaultCat
                ]);
            }
            $builder
                ->add('MOB_'.$type, EntityType::class, $options);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'doctrine' => null,
        ]);
    }

    private function checkCategory(string $type, array $categories): ?Category
    {
        /*
        $name = str_replace("ITEM_", "", $type);
        foreach ($categories as $cat)
        {
            if(
                strpos(strtolower($cat->getName()), strtolower($name)) !== false
                ||
                strpos(strtolower($name), strtolower($cat->getName())) !== false
            ) {
                return $cat;
            }
        }
        */
        return null;
    }
}
