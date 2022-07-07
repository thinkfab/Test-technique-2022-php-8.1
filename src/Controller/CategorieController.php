<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('/categorie/liste', name:'categorie_index')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig');
    }
}
