<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleFixtures extends Fixture
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 50; $i++)
        {
            $article = new Article();
            $article->setCreatedAt(new \DateTimeImmutable())
                    ->setTitle($faker->sentence(3))
                    ->setSlug($this->slugger->slug(strtolower($article->getTitle())))
                    ->setIsPublished(mt_rand(0,1)===1 ? true : false)
                    ->setContenu($faker->realText(2000));
                for($j=0; $j<3; $j++)
                {
                    $photo = new Photo();
                    $photo->setName("default".$j. ".jpeg");
                    $article->addPhoto($photo);
                }
                $manager->persist($article);
                sleep(2);
        }

        $manager->flush();
    }
}
