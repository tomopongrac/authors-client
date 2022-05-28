<?php

declare(strict_types=1);

namespace App\Service;

use App\Security\User;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LoginProvider implements LoginProviderInterface
{
    private HttpClientInterface $httpClient;
    private ContainerBagInterface $params;

    public function __construct(HttpClientInterface $httpClient, ContainerBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    public function attemptLogin(string $email, string $password): ?User
    {
        $response = $this->httpClient->request(
            'POST',
            $this->params->get('api_url') . '/api/v2/token',
            [
                'json' => [
                    'email' => $email,
                    'password' => $password,
                ]
            ]
        );

        if ($response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            return null;
        }

        $userDecode = json_decode($response->getContent(), true);
        $user = (new User())
            ->setEmail($userDecode['user']['email'])
            ->setFirstName($userDecode['user']['first_name'])
            ->setLastName($userDecode['user']['last_name'])
            ->setToken($userDecode['token_key']);

        return $user;
    }
}