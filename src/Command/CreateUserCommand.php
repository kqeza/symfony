<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Helper\QuestionHelper;

#[AsCommand(
    name: 'app:create-user',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private DepartmentRepository $departmentRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $firstName = $helper->ask($input, $output, $this->requiredQuestion('Введите имя: '));
        $lastName = $helper->ask($input, $output, $this->requiredQuestion('Введите фамилию: '));
        $age = $helper->ask($input, $output, $this->requiredQuestion('Введите возраст: '));
        $status = $helper->ask($input, $output, $this->requiredQuestion('Введите статус: '));
        $telegram = $helper->ask($input, $output, $this->requiredQuestion('Введите Telegram: '));
        $email = $helper->ask($input, $output, $this->requiredQuestion('Введите email: '));
        $address = $helper->ask($input, $output, $this->requiredQuestion('Введите адрес: '));

        $output->writeln("\n📋 Список доступных отделов:");
        $departments = $this->departmentRepository->findAll();
        foreach ($departments as $department) {
            $output->writeln("  [{$department->getId()}] {$department->getName()}");
        }

        $departmentId = $helper->ask($input, $output, $this->requiredQuestion("\nВведите ID департамента: "));
        $department = $this->departmentRepository->find($departmentId);

        if (!$department) {
            $output->writeln("<error>❌ Департамент с ID {$departmentId} не найден.</error>");
            return Command::FAILURE;
        }

        $user = new User();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setAge((int)$age);
        $user->setStatus($status);
        $user->setTelegram($telegram);
        $user->setEmail($email);
        $user->setAddress($address);
        $user->setDepartment($department);
        $user->setIcon('default.png');


        $this->em->persist($user);
        $this->em->flush();

        $output->writeln("\n✅ Пользователь успешно создан с ID: " . $user->getId());

        return Command::SUCCESS;
    }

    private function requiredQuestion(string $text): Question
    {
        $question = new Question($text);
        $question->setValidator(function ($value) {
            if (empty($value)) {
                throw new \RuntimeException('Поле не может быть пустым. Попробуйте снова.');
            }
            return $value;
        });
        $question->setMaxAttempts(3);
        return $question;
    }
}
