<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-administrator',
    description: 'new administrator',
    help: 'This command allows you to create a administrator'
)]
class CreateAdministratorCommand extends Command
{

    private EntityManagerInterface $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct('app:create-administrator');
        $this->entityManagerInterface = $entityManagerInterface;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Email')
            ->addArgument('password', InputArgument::OPTIONAL, 'Mot de passe')
            ->addArgument('telephone',InputArgument::OPTIONAL,'Téléphone')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        if (!$email) {
            $question = new Question('Indiquez votre adresse email ?  : ');
            $email = $helper->ask($input, $output, $question);
        }

        $password = $input->getArgument('password');
        if (!$password) {
            $question = new Question('Indiquez votre mot de passe (10 caratères) ? : ');
            $plainPassword = $helper->ask($input, $output, $question);
        }

        $telephone = $input->getArgument('telephone');
        if (!$telephone) {
            $question = new Question('Indiquez votre numéro de téléphone (10 chiffres) ? : ');
            $telephone = $helper->ask($input, $output, $question);
        }

        $admin = new User();
        $admin->setEmail($email)
                      ->setPlainPassword($plainPassword)
                      ->setPhone($telephone)
                      ->setLogin('Administrateur')
                      ->setRoles(['ROLE_ADMIN'])
                      ->setCreatedAt(new \DateTimeImmutable())
                      ->setIsVerified(true)
                      ->setIsNewsLetter(true)
                      ->setPortrait('default.jpg');

        $this->entityManagerInterface->persist($admin);
        $this->entityManagerInterface->flush();
    
        $io->success('Le compte administrateur a été créé !');
        return Command::SUCCESS;
    }
}
