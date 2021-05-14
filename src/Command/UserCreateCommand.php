<?php

namespace App\Command;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'create:user';
    protected static $defaultDescription = 'Add a short description for your command';

    private $entityManager;
    private $encode;

    public function __construct(
                EntityManagerInterface $entityManager,
                UserPasswordEncoderInterface $encode
                
    )
    {
        $this->entityManager = $entityManager;
        $this->encode = $encode;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        $user = new User;

        $email = $io->ask('What is email');
        // $username = $io->ask('What is your username? ');
        $password = $io->askHidden('What is your password?');
        $role = $io->choice('which is your role? ', [ 'ROLE_ADMIN', 'ROLE_USER' ]);

        $em = $this->entityManager;

        $user->setEmail($email);
        // $user->setPassword($password);
        
        $plainPassword = $password;

        $encode = $this->encode->encodePassword($user, $plainPassword);

        $user->setPassword($encode);

        if($role == 'ROLE_ADMIN'){
            $user->setRoles( $user->getRoleAdmin() );
        }else {
            $user->setRoles( $user->getRoles() );
        }

        $em->persist($user);
        $em->flush();

        $io->success('Create user success.');

        return Command::SUCCESS;
    }
}
