<?php

namespace App\MessageHandler;

use App\Message\SendPasswordRequest;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

#[AsMessageHandler]
final readonly class SendPasswordRequestHandler
{

    public function __construct(private MailerInterface $mailer) {}

    public function __invoke(SendPasswordRequest $message): void
    {
        $email = (new TemplatedEmail())
            ->from($message->getFrom())
            ->to($message->getTo())
            ->subject($message->getSubject())
            ->htmlTemplate("email/" . $message->getTemplate() . ".html.twig")
            ->context($message->getContext());
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface) {
        }
    }
}
