<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\User;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('user', 'global.author_label')
            ->hideOnIndex()->hideWhenUpdating();
        yield BooleanField::new('isPublished', 'global.is_published');
        yield TextField::new('titre', 'article.title_label');
        yield SlugField::new('slug', 'article.slug_label')->setTargetFieldName('titre');
        yield DateTimeField::new('createdAt', 'global.created_at')->hideOnForm();
        yield TextEditorField::new('content', 'article.content_label')->hideOnIndex();
        yield AssociationField::new('tags', 'tag.label')
            ->setFormTypeOption('choice_label', 'intitule')
            ->setFormTypeOption('by_reference', false);
    }

    public function createEntity(string $entityFqcn)
    {
        /** @var User $user */
        $user = $this->getUser();
        $article = new Article();
        $article->setCreatedAt(new DateTimeImmutable())
            ->setIsPublished(false);
        return $article;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('article.label')
            ->setEntityLabelInPlural('article.label_plurialized')
            ->setDefaultSort(array(
                'createdAt' => 'DESC'
            ));

    }
}
