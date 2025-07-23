<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityNotFoundException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main',methods: ('GET'))]
    public function index(ArticleRepository $articleRepository): Response
    {
        try {
            $articles = $articleRepository->findPublished();
        }
        catch (EntityNotFoundException $e)
        {
            return $this->redirectToRoute('app_error',['exception'=>$e]);
        }
        return $this->render('main/index.html.twig', [
            'articles'=>$articles
        ]);
    }

    #[Route('/all', name:'app_main_all',methods:['GET'])]
    public function allVerified(ArticleRepository $articleRepository,PaginatorInterface $paginator,Request $request): Response
    {
        try {
            $articles = $articleRepository->findAllVerified($request->query->getInt('page',1));

        }
        catch(EntityNotFoundException $e)
        {
            return $this->redirectToRoute('app_error',['exception'=>$e]);
        }
        return $this->render('main/all_articles.html.twig',['articles'=>$articles]);
    }
}
