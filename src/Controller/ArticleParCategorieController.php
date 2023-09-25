<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleParCategorieController extends AbstractController
{
    #[Route('/article/par/categorie', name: 'app_article_par_categorie')]
    public function index(): Response
    {
        return $this->render('article_par_categorie/index.html.twig', [
            'controller_name' => 'ArticleParCategorieController',
        ]);
    }
    #[Route('/article/{categorieid}', name: 'app_article_par_categorie', methods:['GET', 'HEAD'])]
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('c')
            ->setParameter('val', $value)
            ->andWhere('c.id= = :val')
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
