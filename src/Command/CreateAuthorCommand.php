<?php

namespace App\Command;

use App\Entity\Author;
use App\Service\AuthorProviderInterface;
use App\Service\LoginProviderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class CreateAuthorCommand extends Command
{
    protected static $defaultName = 'app:create-author';
    protected static $defaultDescription = 'Create a new author';
    private ContainerBagInterface $containerBag;
    private LoginProviderInterface $loginProvider;
    private AuthorProviderInterface $authorProvider;

    public function __construct(ContainerBagInterface $containerBag, LoginProviderInterface $loginProvider, AuthorProviderInterface $authorProvider)
    {
        parent::__construct();
        $this->containerBag = $containerBag;
        $this->loginProvider = $loginProvider;
        $this->authorProvider = $authorProvider;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');

        $question = new Question(
            sprintf('API username? [%s] ', $this->containerBag->get('api_username')),
            $this->containerBag->get('api_username')
        );
        $apiUsername = $helper->ask($input, $output, $question);

        $question = new Question(
            'API password? [***********] ',
            $this->containerBag->get('api_password')
        );
        $apiPassword = $helper->ask($input, $output, $question);

        $user = $this->loginProvider->attemptLogin($apiUsername, $apiPassword);

        $defaultValues = $this->getDefaultValues();

        $question = new Question(
            sprintf('First name? [%s] ', $defaultValues['firstName']),
            $defaultValues['firstName']
        );
        $firstName = $helper->ask($input, $output, $question);

        $question = new Question(
            sprintf('Last name? [%s] ', $defaultValues['lastName']),
            $defaultValues['lastName']
        );
        $lastName = $helper->ask($input, $output, $question);

        $question = new Question(
            sprintf('Birthday? [%s] ', $defaultValues['birthday']),
            $defaultValues['birthday']
        );
        $birthday = $helper->ask($input, $output, $question);

        $question = new Question(
            sprintf('Gender? [%s] ', $defaultValues['gender']),
            $defaultValues['gender']
        );
        $gender = $helper->ask($input, $output, $question);

        $question = new Question(
            sprintf('Place of birth? [%s] ', $defaultValues['placeOfBirth']),
            $defaultValues['placeOfBirth']
        );
        $placeOfBirth = $helper->ask($input, $output, $question);

        $author = (new Author())
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setBirthday(new \DateTime($birthday))
            ->setGender($gender)
            ->setPlaceOfBirth($placeOfBirth);

        $this->authorProvider->createAuthor($author, $user->getToken());

        $io->success('Author is created!');

        return Command::SUCCESS;
    }

    /**
     * @return array<string, \DateTime|string>
     */
    protected function getDefaultValues(): array
    {
        return [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'birthday' => (new \DateTime())->format('Y-m-d'),
            'gender' => 'male',
            'placeOfBirth' => 'Zagreb'
        ];
    }
}
