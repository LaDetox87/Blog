<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/blogtemplate.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
    public function troisarticles(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/3_articles.html.twig', [
            'articles' => $articleRepository->findlast3articles(),
        ]);
    }
    #[Route('/article/select', name: 'recherche')]
    public function RechercherArticle(ArticleRepository $ArticleRepository): Response
    {
        $form = $this->createFormBuilder(null, [
            'attr' => ['class' => 'd-flex']
        ])
        ->setAction($this->generateUrl('app_article_about'))
        ->add('elt', TextType::class, ['label' => false,
        'attr' => ['Placeholder' => 'Rechercher',
        'class' => 'form-control me-2'
        ]])
        ->add('submit', SubmitType::class, [
            'attr' => ['class' => 'btn btn-outline-success']
        ])
        ->setMethod('GET')
        ->getForm();
        return $this->render('article/rechercher.html.twig', [
            'form' =>$form->createview()
        ]);
    }

    #[Route('/articleabout', name: 'app_article_about', methods:['GET', 'POST'])]
    public function articleabout(ArticleRepository $articleRepository, Request $request): Response
    {
        $form = ($request->get('form'));
        $word = $form['elt'];
       
        return $this->render('article/blogtemplate.html.twig', [
            'articles' => $articleRepository->findarticleabout($word),
        ]);
    }

    #[Route('/{id}/categorie', name: 'app_article_par_categorie', methods:['GET'])]
    public function listingarticles(ArticleRepository $ArticleRepository, Categorie $categorie): Response
    {
        return $this->render('article/blogtemplate.html.twig', [
            'articles' => $ArticleRepository->findByCategorie($categorie),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
