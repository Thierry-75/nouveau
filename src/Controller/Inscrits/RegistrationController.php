<?php

namespace App\Controller\Inscrits;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UpdateProfilUserFormType;
use App\Message\SendActivationMessage;
use App\Message\SendPasswordConfirm;
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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{

    protected const USERS = "users";
    protected const WEBMASTER = 'webmaster@my-domain.org';

    /**
     * @throws \Exception
     */
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

    #[Route('/profil/{id}', name: 'app_profil_show', methods: ['GET'])]
    public function showProfil(User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('registration/index.html.twig',['user'=>$user]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/profil/update/{id}', name: 'app_profil_update', methods: ['GET','POST'])]
    public function updateProfil(Request $request, User $user,EntityManagerInterface $entityManager,ValidatorInterface $validator,
     PhotoService $photoService, MessageBusInterface $messageBus ):Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(UpdateProfilUserFormType::class);
        $form->handleRequest($request);
        if($request->isMethod('POST')){
            $errors = $validator->validate($request);
            if(count($errors)>0){
                return $this->render('registration/update_profil.html.twig',[
                    'updateProfilForm' => $form->createView(),
                    'user' => $user,
                    'errors' => $errors
                ]);
            }
        }
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword($user->getPassword())
                 ->setEmail($user->getEmail())
                ->setRoles($user->getRoles())
                ->setIsVerified($user->IsVerified())
                ->setIsNewsLetter($user->IsNewsLetter())
                ->setLogin($form->get('login')->getData())
                ->setPhone($form->get('phone')->getData());
            try{
                if($form->get('portrait')->getData() !== null){
                    $image = $form->get('portrait')->getData();
                    if($image->getClientOriginalExtension() === 'jpeg' || $image->getClientOriginalExtension() === 'jpg'){
                        $portrait = $photoService->add($image, $user->getEmail(), self::USERS, 512, 512);
                        $user->setPortrait($portrait);
                        $entityManager->persist($user);
                        $entityManager->flush();
                        $url = $this->generateUrl('app_login',[], UrlGeneratorInterface::ABSOLUTE_URL);
                        $messageBus->dispatch(new SendPasswordConfirm(self::WEBMASTER,$user->getEmail(),'Mise à jour profil','modification',['user'=>$user,'url'=>$url]));
                        $this->addFlash('alert-success','Profil mis à jour');
                        return $this->redirectToRoute('app_login');
                    }
                }
            }catch (EntityNotFoundException $e){
                return $this->redirectToRoute('app_error',['exception'=>$e]);
            }
        }
        return $this->render('registration/update_profil.html.twig', [
            'updateProfilForm' => $form->createView(),
            'user' => $user
        ]);
    }

}
