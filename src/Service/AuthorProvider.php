<?php

namespace App\Service;

use App\Representation\PaginatedAuthors;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AuthorProvider
{
    private HttpClientInterface $httpClient;
    private ContainerBagInterface $params;
    private Security $security;
    private SerializerInterface $serializer;

    public function __construct(HttpClientInterface $httpClient, ContainerBagInterface $params, Security $security, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
        $this->security = $security;
        $this->serializer = $serializer;
    }

    public function getAuthors()
    {
        $response = $this->httpClient->request(
            'GET',
            $this->params->get('api_url') . '/api/v2/authors',
            [
                'auth_bearer' => $this->security->getUser()->getToken()
            ]
        );

        return $this->serializer->deserialize($response->getContent(), PaginatedAuthors::class, 'json');
    }
}