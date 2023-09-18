<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Utilisateur;
use App\Entity\Categorie;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $categories = array();
        $auteurs = array();

        for ($i = 0; $i < 20; $i++) {
            $product = new Categorie();
            $product->setLibelle('categorie'.$i);
            $manager->persist($product);
            $manager->flush();
            array_push($categories,$product);
        }

        for ($i = 0; $i < 20; $i++) {
            $product = new Utilisateur();
            $product->setPseudo('user'.$i);
            $product->setNom('nom'.$i);
            $product->setMdp('mdp'.$i);
            $product->setMail('mail'.$i);
            $manager->persist($product);
            $manager->flush();
            array_push($auteurs,$product);
        }

        for ($i = 0; $i < 20; $i++) {
            $product = new Article();
            $product->setLibelle('user'.$i);
            $product->setTitre('titre'.$i);
            $product->setDate($faker->dateTime());
            $product->setAuteur($auteurs[random_int(0,sizeof($auteurs)-1)]);
            $product->setUneCategorie($categories[random_int(0,sizeof($categories)-1)]);
            $manager->persist($product);
            $manager->flush();
        }
    }
}
