<?php

namespace App\Controller\Admin\PostCrud;

use App\Entity\Post;
use App\Entity\Post\Mission;
use App\Form\MissionTaxonomyType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\TextAlign;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mission::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->where("entity.type = 'mission'");
        return $response;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->showEntityActionsInlined(true)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
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
            ->add(Crud::PAGE_INDEX, $view)
            ->add(Crud::PAGE_EDIT, $view)
            ->update(Crud::PAGE_EDIT, 'show', function(Action $action) {
                return $action->setIcon('fa fa-eye');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function(Action $action) {
                return $action->setCssClass('d-none');
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

            TextEditorField::new('content')->setFormType(CKEditorType::class),

            HiddenField::new('views')
                ->setFormTypeOptions($viewsOptions),

            HiddenField::new('type')
                ->setFormTypeOptions(['data' => 'mission'])
                ->onlyOnForms(),

            CollectionField::new('taxonomies')
                ->allowAdd()
                ->setEntryIsComplex(false)
                ->showEntryLabel(false)
                ->setEntryType(MissionTaxonomyType::class)
                ->addCssClass("mb-5")
                ->setRequired(true)
                ->hideOnIndex(),

        ];
    }
    
}
