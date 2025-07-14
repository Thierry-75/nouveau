<?php

namespace App\Controller\Inscrits;

use App\Form\ChangePasswordFormType;
use App\Form\RequestPasswordFormType;
use App\Message\SendPasswordConfirm;
use App\Message\SendPasswordRequest;
use App\Repository\UserRepository;
use App\Service\IntraController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{

protected const WEBMASTER = 'webmaster@my-domain.org';

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_main');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path:'/forgotten-password',name:'forgotten_password', methods:['GET','POST'])]
    public function forgottenPassword(Request $request,
    ValidatorInterface $validatorInterface,
    UserRepository $userRepository,
    TokenGeneratorInterface $tokenGeneratorInterface,
    EntityManagerInterface $entityManagerInterface,
    MessageBusInterface $messageBusInterface,
    ): Response
    {
        $form = $this->createForm(RequestPasswordFormType::class);
        $form->handleRequest($request);
        if($request->isMethod('POST')){
            $errors = $validatorInterface->validate($request);
            if(count($errors)>0){
                return $this->render('security/reset_password_request.html.twig', ['requestForm' => $form->createView(), 'errors' => $errors]);
            }
            if($form->isSubmitted() && $form->isValid()){
                try{
                    $user = $userRepository->findByEmail($form->get('courriel')->getData());
                    $inscrit = (object) $user[0];
                    $token = $tokenGeneratorInterface->generateToken();
                    $inscrit->setResetToken($token);
                    $entityManagerInterface->flush();
                    $url = $this->generateUrl('reset_password',['token'=>$token],UrlGeneratorInterface::ABSOLUTE_URL);
                    $messageBusInterface->dispatch(new SendPasswordRequest(SecurityController::WEBMASTER,$inscrit->getEmail(),'Demande de nouveau mot passe','password_reset',['url'=>$url,'user'=>$inscrit]));
                    $this->addFlash('alert-warning',"Lien d'activation nouveau mot de passe envoyé");
                    return $this->redirectToRoute('app_main');
                }catch(EntityNotFoundException $e){
                    return $this->redirectToRoute('app_error',['exception'=>$e]);
                }
            }
        }
         return $this->render('security/reset_password_request.html.twig', ['requestForm' => $form->createView()]);
    }

    #[Route('/lost-password/{token}', name:'reset_password')]
    public function resetPassword(string $token, Request $request, UserRepository $userRepository, ValidatorInterface $validatorInterface,
    EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface, MessageBusInterface $messageBusInterface): Response
    {
        try{
            $user = $userRepository->findOneByResetToken($token);
            if($user){
                    $form = $this->createForm((ChangePasswordFormType::class));
                    $form->handleRequest($request);
                    if($request->isMethod('POST')){
                        $errors = $validatorInterface->validate($request);
                        if(count($errors)>0){
                            return $this->render('/security/reset.html.twig', ['resetForm'=>$form->createView(),'errors'=>$errors]);
                        }
                        if($form->isSubmitted() && $form->isValid()){
                            $user->SetResetToken('')
                                        ->setPassword(
                                            $userPasswordHasherInterface->hashPassword($user,$form->get('plainPassword')->getData())
                                        )
                                        ->setUpdatedAt(new \DateTimeImmutable());
                                        try{
                                            $entityManagerInterface->persist($user);
                                            $entityManagerInterface->flush();
                                            $url = $this->generateUrl('app_main',[],UrlGeneratorInterface::ABSOLUTE_URL);
                                            $messageBusInterface->dispatch(new SendPasswordConfirm(SecurityController::WEBMASTER,$user->getEmail(),'Nouveau mot de passe','new_password',['user'=>$user,'url'=>$url]));
                                            $this->addFlash('alert-success','Votre mot de passe a été modifié !');
                                            return $this->redirectToRoute('app_login');
                                        }
                                        catch(EntityNotFoundException $e){
                                            return $this->redirectToRoute('app_error',['exception'=>$e]);
                                        }
                        }
                    }
            }
        }catch(EntityNotFoundException $e)
        {
            return $this->redirectToRoute('app_error',['exception'=>$e]);
        }
        return $this->render('/security/reset.html.twig', ['resetForm'=>$form->createView()]);
    }
}
