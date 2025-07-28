<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
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

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {

        $tableau_categories = ['Philosophie','Science','Politique','Archéologie','Commerce'];
        foreach ($tableau_categories as $categorie )
        {
            $category = new Category();
            $category->setName($categorie)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setSlug($this->slugger->slug(strtolower($category->getName())));
            $manager->persist($category);
            $categories[]=$category;
        }
        $manager->flush();

        $faker = Factory::create('fr_FR');
        $random_photos = ['default1.jpeg','default2.jpeg','default3.jpeg','default4.jpeg',
            'default5.jpeg','default6.jpeg','default7.jpeg','default8.jpeg','default9.jpeg','default10.jpeg'];
        for($i = 0; $i < 150; $i++)
        {
            $article = new Article();
            $article->setCreatedAt(new \DateTimeImmutable())
                    ->setTitle($faker->sentence(3))
                    ->setSlug($this->slugger->slug(strtolower($article->getTitle())))
                    ->setIsPublished(random_int(0,1)===1 ? true : false)
                    ->setCategory($categories[random_int(0,count($categories)-1)])
                    ->setContenu($faker->realText(2000));
                for($j=0; $j<3; $j++)
                {
                    $photo = new Photo();
                    $photo->setName('default'.random_int(1,10).'.jpeg');
                    $article->addPhoto($photo);
                }
                $manager->persist($article);
                sleep(1);
        }

        $manager->flush();
    }
}
