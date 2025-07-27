<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use App\Repository\ArticleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture
{

    public function __construct(private readonly ArticleRepository $articleRepository){}

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $articles = $this->articleRepository->findAll();

        $tags=[];
        for($i = 0; $i < 10; $i++)
        {
            $tag = new Tag();
            $tag->setName($faker->word())
                ->setCreatedAt(new \DateTimeImmutable());
            $tags[]=$tag;
            $manager->persist($tag);
        }
        foreach ($articles as $article){
            for($i=0; $i < random_int(2,3); $i++){
                $article->addTag($tags[random_int(0,count($tags)-1)]);
                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
