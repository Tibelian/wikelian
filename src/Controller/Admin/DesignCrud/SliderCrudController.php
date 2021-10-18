<?php

namespace App\Controller\Admin\DesignCrud;

use App\Entity\Design\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
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
        return [
            ImageField::new('image')
                ->setBasePath('images/uploaded')
                ->setTextAlign(TextAlign::LEFT)
                ->hideOnForm(),

            TextareaField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),

            ChoiceField::new('position')
                ->setChoices([
                    'Homepage' => 'homepage',
                    'Category page' => 'categorypage',
                    'Post page' => 'postpage',
                ])
                ->allowMultipleChoices(),
    
            ColorField::new('background')->showValue(true),

            TextEditorField::new('content'),
            
            BooleanField::new('isEnabled'),
        ];
    }

}
