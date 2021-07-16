<?php


namespace App\Command;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InsertDumpDBCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function configure()
    {
        $this
            ->setName('app:insert-dump')
            ->setDescription('Заполнение базы данных тестовыми данными.')
            ->setHelp('Команда заполняет базу данных тестовыми данными.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this
                ->getEntityManager()
                ->getConnection()
                ->prepare(
                    'INSERT INTO `region` (`id`, `name`) VALUES
                     (1, \'Республика Мордовия\'),
                     (2, \'Нижегородская область\');
                     
                     INSERT INTO `city` (`id`, `region_id`, `name`) VALUES
                     (1, 1, \'Саранск\'),
                     (2, 1, \'Рузаевка\'),
                     (3, 2, \'Арзамас \'),
                     (4, 2, \'Нижний Новгород\');
                     
                     INSERT INTO `street` (`id`, `city_id`, `name`) VALUES
                     (1, 1, \'Девятаева\'),
                     (2, 1, \'пр. 70 лет Октября\'),
                     (3, 3, \'пр. 70 лет Октября\'),
                     (4, 4, \'Карла-Маркса \');
                     
                     INSERT INTO `home` (`id`, `street_id`, `number`, `lat`, `lon`) VALUES
                     (1, 1, 7, NULL, NULL),
                     (2, 2, 80, NULL, NULL);
                     
                     INSERT INTO `user_address` (`id`, `user_id`, `home_id`, `porch`, `floor`, `intercom`, `apartment`) VALUES
                     (1, 1, 1, 1, 1, 1, NULL),
                     (2, 1, 2, 1, 2, NULL, 4);'
                )
                ->execute();
            $resultMsg = 'Дамп успешно загружен.';
            $res = 1;
        } catch (DBALException $e) {
            $resultMsg = 'Ошибка загрузки дампа.';
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