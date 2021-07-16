<?php


namespace App\Command;

use App\Entity\User;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateRootUserCommand extends Command
{
    private const EMAIL = 'root@root.com';
    private const PASS = 'root';
    private const ROLES = ['ROLE_USER', 'ROLE_ADMIN'];

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        parent::__construct();
    }

    private function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    private function getPasswordEncoder(): UserPasswordEncoderInterface
    {
        return $this->passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setName('app:create-root-user')
            ->setDescription('Создание тестового пользователя.')
            ->setHelp('Команда создаёт тестового пользователя');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $user = (new User())
                ->setEmail(self::EMAIL)
                ->setRoles(self::ROLES);
            $user->setPassword(
                $this->getPasswordEncoder()
                    ->encodePassword(
                        $user,
                        self::PASS
                    ));

            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
            $resultMsg = 'Пользователь успешно создан.';
            $res = 1;
        } catch (DBALException $e) {
            $resultMsg = 'Ошибка создания пользователя';
            $res = 0;
        }
        $output->writeln(
            [
                $resultMsg,
            ]
        );
        return $res;
    }
}