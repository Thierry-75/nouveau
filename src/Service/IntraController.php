<?php

namespace App\Service;

use App\Entity\User;
use App\Service\JwtService;
use App\Message\SendActivationMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class IntraController extends AbstractController
{
    protected const WEBMASTER = 'webmaster@my-domain.org';
    
    /**
     * email validation function
     *
     * @param User $user
     * @param JwtService $jwt
     * @param MessageBusInterface $messageBus
     * @param IntraController $intraController
     * @return void
     */
    function emailValidate( User $user, JwtService $jwt, MessageBusInterface $messageBus, $destination, $subject,$nomTemplate ): void
    {
        $header = ['typ' => 'JWT', 'alg' => 'HS256'];
        $payload = ['user_id' => $user->getId()];
        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));
        $url = $this->generateUrl($destination, ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
        $messageBus->dispatch(new SendActivationMessage( IntraController::WEBMASTER, $user->getEmail(), $subject, $nomTemplate, ['user' => $user, 'url' => $url]));
    }

}
