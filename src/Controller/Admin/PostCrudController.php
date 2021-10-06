<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\TaxonomyType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\CrudControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Registry\CrudControllerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
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
        $view = Action::new('show', 'Show')
            ->linkToRoute("post", function(Post $post): array {
                return [
                    'slug' => $post->getSlug(),
                ];
            })
        ;
        return $actions
            ->add(Crud::PAGE_EDIT, Action::DELETE)
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $view)
            ->update(Crud::PAGE_EDIT, 'show', function(Action $action) {
                return $action->setIcon('fa fa-eye');
            })
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {

        $viewsOptions = [];
        if ($pageName == Crud::PAGE_NEW) {
            $viewsOptions['data'] = 0;
        }

        return [
            TextField::new('title'),

            SlugField::new('slug')
                ->setTargetFieldName("title")
                ->hideOnIndex(),
                
            ImageField::new('thumbnail')
                ->setBasePath('images/uploaded')
                ->setTextAlign(TextAlign::LEFT)
                ->hideOnForm(),

            TextareaField::new('thumbnailFile')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),

            TextField::new('description')
                ->hideOnIndex(),

            AssociationField::new('category')
                ->setFormTypeOptions(['required' => true]),

            TextEditorField::new('content'),

            HiddenField::new('views')
                ->setFormTypeOptions($viewsOptions),

            CollectionField::new('taxonomies')
                ->allowAdd()
                ->setEntryIsComplex(false)
                ->showEntryLabel(false)
                ->setEntryType(TaxonomyType::class)
                ->addCssClass("mb-5")
                ->setRequired(true)
                ->hideOnIndex(),

        ];
    }
    
}
