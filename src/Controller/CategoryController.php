<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'app_category',methods: ['GET'])]
    public function index(): Response
    {



        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
