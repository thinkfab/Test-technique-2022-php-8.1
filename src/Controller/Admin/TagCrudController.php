<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('intitule', 'tag.intitule_label');
        yield SlugField::new('slug', 'article.slug_label')->setTargetFieldName('intitule');
        yield ColorField::new('color', 'tag.color_label')->showValue();
    }

}
