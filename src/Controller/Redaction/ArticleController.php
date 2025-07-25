<?php

namespace App\Controller\Redaction;

use App\Entity\Article;
use App\Entity\Photo;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Service\PhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route(path:'/article', name: 'app_article_')]
final class ArticleController extends AbstractController
{
    protected const  USERS = "articles";
    protected const  WEBMASTER = 'webmaster@my-domain.org';

    #[Route('/show/{slug}', name: 'index', methods:['GET'])]
    public function index($slug , ArticleRepository $articleRepository): Response
    {
        try {
            $article = $articleRepository->findOneBy(['slug' => $slug]);
        }catch(EntityNotFoundException $e)
        {
            return $this->redirectToRoute('app_error',['exception'=>$e]);
        }
        return $this->render('article/index.html.twig',['article'=>$article]);
    }

    /**
     * @throws Exception
     */
    #[Route('/add', name: 'add', methods:['POST','GET'])]
    public function addArticle(
        Request $request,EntityManagerInterface $manager,PhotoService $photoService,SluggerInterface $slugger
    ): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class,$article);
        $form->handleRequest($request);
        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $photos = $form->get('photos')->getData();
            $count = 1;
            foreach ($photos as $photo){
                if($photo->getClientOriginalExtension()==='jpeg' || $photo->getClientOriginalExtension()==='jpg')
                {
                    try{
                        $article->setSlug($slugger->slug(strtolower($form->get('title')->getData())));
                        $fichier = $photoService->add($photo,$article->getSlug().'-'.$count,self::USERS,1024,768);
                        $image = new Photo();
                        $image->setName($fichier);
                        $article->addPhoto($image);
                        $count++;
                    }catch (Exception $e)
                    {
                        return $this->redirectToRoute('app_error',['exception'=>$e]);
                    }
                }

            }
            try {
                $manager->persist($article);
                $manager->flush();
                $this->addFlash('alert-success', 'Article créé !');
                return $this->redirectToRoute('app_article_index',['slug'=>$article->getSlug()]);
            }catch (EntityNotFoundException $e)
            {
                return $this->redirectToRoute('app_error',['exception'=>$e]);
            }
        }
        return $this->render('article/add_article.html.twig', [
            'form_article_new'=>$form->createView()
        ]);
    }
}
