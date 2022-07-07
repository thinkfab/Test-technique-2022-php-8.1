<?php

namespace App\Controller;

use App\Contracts\Manager\TagManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomeController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @return Response
     */
    #[Route('/read-me/installation', name: 'consignes_installation')]
    public function installation(): Response
    {
        return $this->render('home/installation.html.twig');
    }

    /**
     * @return Response
     */
    #[Route('/read-me/consignes', name: 'consignes')]
    public function consignes(): Response
    {
        return $this->render('home/consignes.html.twig');
    }

    /**
     * @param TagManagerInterface $tagManager
     * @return Response
     */
    #[Route('/read-me/examples', name: 'consignes_examples')]
    public function examples(
        Request $request,
        TagManagerInterface $tagManager
    ): Response {
        $page = $request->query->get('page', 1);
        $tags = $tagManager->findAllTags(5, $page);
        return $this->render('home/examples.html.twig', array(
            'tags' => $tags
        ));
    }

}
