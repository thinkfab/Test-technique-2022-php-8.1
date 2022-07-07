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
        return $this->render('home/consignes.html.twig', array(
            'display_button' => true
        ));
    }

    /**
     * @return Response
     */
    #[Route('/read-me/consignes/junior-php-sf', name: 'consignes_junior_php')]
    public function consignesJunior(): Response
    {
        return $this->render('home/consignes/junior-php.html.twig');
    }

    /**
     * @return Response
     */
    #[Route('/read-me/consignes/confirmed-php-sf', name: 'consignes_confirmed_php')]
    public function consignesConfirmedPhp(): Response
    {
        return $this->render('home/consignes/confirmed-php.html.twig');
    }

    /**
     * @return Response
     */
    #[Route('/read-me/consignes/confirmed-react', name: 'consignes_confirmed_react')]
    public function consignesConfirmedReact(): Response
    {
        return $this->render('home/consignes/confirmed-react.html.twig');
    }

    /**
     * @param Request $request
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

    /**
     * @return Response
     */
    #[Route('/react/index-copy', name: 'react_spa_page')]
    public function reactPage(): Response {
        return $this->render('home/react.html.twig');
    }

}
