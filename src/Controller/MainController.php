<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findPublished();

        return $this->render('main/index.html.twig', [
            'articles'=>$articles
        ]);
    }
}
