<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 26/06/2017
 * Time: 09:51
 */

namespace BM\ApiBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BM\ApiBundle\Entity\Article;

class LoadArticleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $datas = array(
            'article1' => array(
                'marque' => 'Apple',
                'model' => 'Iphone 6',
                'description' => 'Déverrouillez votre nouvel iPhone 6 à l\'aide de votre empreinte pour acheter de la musique, profiter des meilleurs jeux et applications de l\'Apple Store et synchronisez le avec l\'Apple Watch!',
                'prix' => '500.00',
            ),
            'article2' => array(
                'marque' => 'Apple',
                'model' => 'Iphone 6 Plus',
                'description' => 'Déverrouillez votre nouvel iPhone 6 plus à l\'aide de votre empreinte pour acheter de la musique, profiter des meilleurs jeux et applications de l\'Apple Store et synchronisez le avec l\'Apple Watch!',
                'prix' => '650.00',
            ),
            'article3' => array(
                'marque' => 'Apple',
                'model' => 'Iphone 7',
                'description' => 'Déverrouillez votre nouvel iPhone 7 à l\'aide de votre empreinte pour acheter de la musique, profiter des meilleurs jeux et applications de l\'Apple Store et synchronisez le avec l\'Apple Watch!',
                'prix' => '750.00',
            ),
            'article4' => array(
                'marque' => 'Apple',
                'model' => 'Iphone 7 Plus',
                'description' => 'Déverrouillez votre nouvel iPhone 7 plus à l\'aide de votre empreinte pour acheter de la musique, profiter des meilleurs jeux et applications de l\'Apple Store et synchronisez le avec l\'Apple Watch!',
                'prix' => '900.00',
            )
        );
        foreach ($datas as $data) {
            $article = new Article();
            $article->setMarque($data['marque']);
            $article->setModele($data['model']);
            $article->setDescription($data['description']);
            $article->setPrix($data['prix']);

            $manager->persist($article);
            $manager->flush();
        }
    }
}