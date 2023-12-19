<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Form\CategoryType;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

class CategorieController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entity
    ) {
    }

    /**
     * @return Response
     */
    #[Route('/categorie/liste', name: 'categorie_index')]
    public function index(): Response
    {
        $queryBuilder = $this->entity->getRepository(Category::class)->paginatorCategory();
        $pagerfanta = new Pagerfanta(new QueryAdapter($queryBuilder));
        $pagerfanta->setMaxPerPage(10);
        return $this->render('categorie/index.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }

    /**
     * @return Response
     */
    #[Route('/categorie-new', name: 'categorie_new')]
    public function categoryNew(Request $request): Response
    {
        $category = new Category();

        $formCategory = $this->createForm(CategoryType::class, $category);
        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() && $formCategory->isValid()) {

            $this->entity->persist($category);
            $this->entity->flush();

            $this->addFlash('success', 'Votre Catégorie a bien été ajouté !');

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/new.html.twig', [
            'form' => $formCategory->createView(),
        ]);
    }

    #[Route('/categorie-edit/{id}', name: 'categorie_edit')]
    public function categoryEdit(int $id, Request $request): Response
    {
        $category = $this->entity->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'Aucune categorie trouvé avec ce titre' . $category->getTitle()
            );
        }

        $formEditCategory = $this->createForm(CategoryType::class, $category);
        $formEditCategory->handleRequest($request);


        if ($formEditCategory->isSubmitted() && $formEditCategory->isValid()) {

            $formData = $formEditCategory->getData();

            $category->setTitle($formData->getTitle())
                ->setUpdatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')));

            $this->entity->flush();

            $this->addFlash('success', 'Votre Categorie a bien été modifié !');
            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/edit.html.twig', [
            'form' => $formEditCategory->createView()
        ]);
    }


    #[Route('/categorie-delete/{id}', name: 'categorie_delete')]
    public function categoryDelete(int $id): Response
    {
        $category = $this->entity->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'Aucune categorie trouvé avec ce titre' . $category->getTitle()
            );
        }

        $articlesCount = $category->getArticles()->count();

        if ($articlesCount > 0) {
            $this->addFlash('danger', 'La catégorie ne peut pas être supprimée, car un ou plusieurs articles sont liés à celle-ci.');
            return $this->redirectToRoute('categorie_index');
        }
        $this->entity->remove($category);
        $this->entity->flush();

        $this->addFlash('success', 'Votre Categorie a bien été supprimé !');

        return $this->redirectToRoute('categorie_index');
    }
}
