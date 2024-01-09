<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Users;

class MailerService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendResetPasswordEmail(Users $user, string $resetToken): void
    {
        $email = (new Email())
            ->from('jordancros@hotmail.fr')
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')
            ->html("Pour réinitialiser votre mot de passe, veuillez cliquer sur ce lien: <a href='https://garage-vincent-parrot-studi-d66e05141e08.herokuapp.com//reset-password?token=$resetToken'>Réinitialiser le mot de passe</a>. Attention, ce lien restera actif 1 heure.");

        $this->mailer->send($email);
    }
}
