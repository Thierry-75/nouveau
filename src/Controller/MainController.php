<?php

namespace App\Controller;


use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    /**
     * affiche les derniers articles récents
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    #[Route('/', name: 'app_main',methods: ('GET'))]
    public function index(ArticleRepository $articleRepository): Response
    {
        try {
            $articles = $articleRepository->findLastArticles();
            return $this->render('main/index.html.twig', [
                'articles_caroussel'=>$articles,'articles_card'=>$articles
            ]);
        }
        catch (EntityNotFoundException $e)
        {
            return $this->redirectToRoute('app_error',['exception'=>$e]);
        }

    }

    /**
     * affiche tous les articles editables
     * @param ArticleRepository $articleRepository
     * @param Request $request
     * @return Response
     */
    #[Route('/all', name:'app_main_all',methods:['GET'])]
    public function allVerified(ArticleRepository $articleRepository,Request $request): Response
    {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class,$searchData);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $searchData->page = $request->query->getInt('page',1);
            $articles = $articleRepository->findBySearch($searchData);
            return $this->render('main/all_articles.html.twig',['form'=>$form->createView(),'articles'=>$articles]);
        }
        return $this->render('main/all_articles.html.twig',['form'=>$form->createView(),
            'articles'=>$articleRepository->findPublished($request->query->getInt('page',1))
            ]);
    }
}
