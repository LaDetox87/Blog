<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findByCategorie($categorie): array
    {
        return $this->createQueryBuilder('a')
            ->setParameter('val', $categorie)
            ->join('a.UneCategorie', 'c')
            ->andWhere('c.id = :val')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findlast3articles(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findarticleabout(string $word): array
    {
        return $this->createQueryBuilder('a')
            ->setParameter('word', "%".$word."%")
            ->andWhere("a.titre like :word OR a.libelle like :word")
            ->getQuery()
            ->getResult()
        ;
    }
}
