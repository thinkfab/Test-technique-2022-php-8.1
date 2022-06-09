<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // TODO: garder ceci afin de pouvoir ameliorer le dashboard par la suite
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Eunnow Site');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linktoUrl('Back to the website', 'fas fa-person-walking-arrow-right', $this->generateUrl('homepage'));
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-tags', Tag::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comments', Commentaire::class);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateFormat('dd-mm-yyyy')
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(2);
    }
}
