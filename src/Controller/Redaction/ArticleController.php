<?php

namespace App\Controller\Redaction;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Service\IntraController;
use App\Service\PhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ArticleController extends AbstractController
{#[Route('/article/', name: 'app_article_index', methods:['POST','GET'])]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [

        ]);
    }

    #[Route('/article/add', name: 'app_article_add', methods:['POST','GET'])]
    public function addArticle(Request $request, ValidatorInterface $validator,
                               EntityManagerInterface $manager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class,$article);
        $form->handleRequest($request);
        if($request->isMethod('POST')){
            $errors = $validator->validate($request);
            if(count($errors)>0){
                return $this->render('article/add_article.html.twig', [
                    'form_article_new'=>$form->createView(),'errors'=>$errors
                ]);
            }
            if($form->isSubmitted() && $form->isValid()){
                $manager->persist($article);
                $manager->flush();
                $this->addFlash('alert-success','Article créé !');
                return $this->redirectToRoute('app_article_index');
            }
        }
        return $this->render('article/add_article.html.twig', [
            'form_article_new'=>$form->createView()
        ]);
    }
}
