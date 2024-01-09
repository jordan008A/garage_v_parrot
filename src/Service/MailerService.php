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
            ->from('garageparrot43@outlook.fr')
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')
            ->html("
                <html>
                    <head>
                        <style>
                            .email-container {
                                background-color: #f4f4f4;
                                padding: 20px;
                                font-family: Arial, sans-serif;
                            }
                            .email-content {
                                background-color: white;
                                padding: 20px;
                                text-align: center;
                                border-radius: 10px;
                            }
                            .email-button {
                                display: inline-block;
                                padding: 10px 20px;
                                margin-top: 20px;
                                background-color: #007bff;
                                color: white;
                                text-decoration: none;
                                border-radius: 5px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='email-container'>
                            <div class='email-content'>
                                <h1>Réinitialisation de votre mot de passe</h1>
                                <p>Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien ci-dessous. Attention, ce lien restera actif 1 heure.</p>
                                <a href='https://garage-vincent-parrot-studi-d66e05141e08.herokuapp.com/reset-password?token=$resetToken' class='email-button'>Réinitialiser le mot de passe</a>
                            </div>
                        </div>
                    </body>
                </html>"
            );
    
        $this->mailer->send($email);
    }
    
}
