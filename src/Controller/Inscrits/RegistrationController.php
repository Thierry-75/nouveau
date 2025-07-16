<?php

namespace App\Controller\Inscrits;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\IntraController;
use App\Service\JwtService;
use App\Service\PhotoService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{

    protected const USERS = "users";

    #[Route('/register', name: 'app_register',methods: ['GET','POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,
    ValidatorInterface $validatorInterface,JwtService $jwtService,IntraController $intraController, MessageBusInterface $messageBusInterface,PhotoService $photoService
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class,$user);
        $form->handleRequest($request);
        if($request->isMethod('POST')){
            $errors = $validatorInterface->validate($request);
            if(count($errors)>0){
                return $this->render('registration/register.html.twig',['registrationForm'=>$form->createView(),'errors'=>$errors]);
            }
        }
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword($userPasswordHasher->hashPassword($user,$form->get('plainPassword')->getData()))
                        ->setRoles(['ROLE_USER']);
                        $email = $form->get('email')->getData();
                        $image = $form->get('portrait')->getData();
                        try{
                            if($image->getClientOriginalExtension() === 'jpeg'  || $image->getClientOriginalExtension() === 'jpg'){
                            $portrait = $photoService->add($image,$email, self::USERS,256,256);
                            $user->setPortrait($portrait);
                            $entityManager->persist($user);
                            $entityManager->flush();
                            $subject="Activation de votre compte";
                            $destination ='check_user';
                            $nomTemplate ='register';
                            $intraController->emailValidate($user,$jwtService,$messageBusInterface,$destination,$subject,$nomTemplate);
                            $this->addFlash('alert-warning','SVP, confirmez votre adresse email');
                            return $this->redirectToRoute('app_main');
                            }
                        }catch(EntityNotFoundException $e){
                            return $this->redirectToRoute('app_error',['exception'=>$e]);
                        }
        }
        return $this->render('registration/register.html.twig',['registrationForm'=>$form->createView()]);
    }

    #[Route('/check/{token}',name:'check_user')]
    public function verifyUser($token, JwtService $jwtService, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        // if token valid, expired & !modified
        if($jwtService->isValid($token) && !$jwtService->isExpired($token) && $jwtService->check($token, $this->getParameter('app.jwtsecret'))){
            $payload = $jwtService->getPayload($token);
            //user token
            $user = $userRepository->find($payload['user_id']);
                $user->setIsVerified(true);
                $user->setIsNewsLetter(true);
                try{
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $this->addFlash('alert-success','Compte activé');
                    return $this->redirectToRoute('app_login');
                }catch(EntityNotFoundException $e){
                    return $this->redirectToRoute('app_error',['exception'=>$e]);
                }
        }
        $this->addFlash('alert-danger','Token expiré !');
        return $this->redirectToRoute('app_login');

    }

}
