<?php

namespace App\Command;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create an administrator',
)]
class CreateAdminCommand extends Command
{
    private EntityManagerInterface $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct('app:create-admin');
    }

    protected function configure(): void
    {
        $this
            ->addArgument('firstname', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('lastname', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('email', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('password', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $firstname = $input->getArgument('firstname');
        if(!$firstname){
            $question = new Question('Quel est le prénom de l\'administrateur : ');
            $firstname = $helper->ask($input, $output, $question);
        }
        
        $lastname = $input->getArgument('lastname');
        if(!$lastname){
            $question = new Question('Quel est le nom de '. $firstname .' : ');
            $lastname = $helper->ask($input, $output, $question);
        }

        $email = $input->getArgument('email');
        if(!$email){
            $question = new Question('Quel est l\'email de '. $firstname .' : ');
            $email = $helper->ask($input, $output, $question);
        }

        $plainPassword = $input->getArgument('password');
        if(!$plainPassword){
            $question = new Question('Choisissez un mot de passe pour '. $firstname .' : ');
            $plainPassword = $helper->ask($input, $output, $question);
        }


        $user = (new Users())
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setPlainPassword($plainPassword)
            ->setIsAdmin(true);

        $this->manager->persist($user);
        $this->manager->flush();

        $io->success('L\'administrateur a été créé ave succès !');

        return Command::SUCCESS;
    }
}
