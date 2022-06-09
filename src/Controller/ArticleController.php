<?php

namespace App\Controller;

use App\Contracts\Manager\ArticleManagerInterface;
use App\Contracts\Manager\TagManagerInterface;
use App\Helper\UrlHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @param string $slug
     * @param ArticleManagerInterface $articleManager
     * @return Response
     */
    #[Route('/{slug}', name: 'article_index')]
    public function articleAction(
        string $slug,
        ArticleManagerInterface $articleManager
    ): Response {
        $article = $articleManager->getArticleVmBySlug($slug);
        return $this->render('article/index.html.twig', array(
            'article' => $article
        ));
    }

    /**
     * @param string $slugTag
     * @param string $slug
     * @param ArticleManagerInterface $articleManager
     * @param TagManagerInterface $tagManager
     * @return Response
     */
    #[Route('/tag/{slugTag}/{slug}/', name: 'article_with_tag')]
    public function articleWithTagAction(
        string $slugTag,
        string $slug,
        ArticleManagerInterface $articleManager,
        TagManagerInterface $tagManager
    ): Response {
        $article = $articleManager->getArticleVmBySlug($slug);
        $tag = $tagManager->findOneBySlug($slugTag);
        return $this->render('article/index.html.twig', array(
            'article'   => $article,
            'tag'       => $tag
        ));
    }

    /**
     * @param string $slug
     * @param TagManagerInterface $tagManager
     * @param ArticleManagerInterface $articleManager
     * @return Response
     */
    #[Route('/tag/{slug}', name: 'article_filter_by_tag')]
    public function filterByTag(
        string $slug,
        TagManagerInterface $tagManager,
        ArticleManagerInterface $articleManager
    ): Response {
        $tag = $tagManager->findOneBySlug($slug);
        $articles = $articleManager->getArticlesByTag($tag);
        return $this->render('article/filtered_by_tag.html.twig', array(
            'tag' => $tag,
            'articles' => $articles
        ));
    }
}
