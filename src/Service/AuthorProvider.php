<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Representation\PaginatedAuthors;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
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

    public function getAuthors(?string $page = null): PaginatedAuthors
    {
        $pageQueryParameter = $page ? '?page=' . $page : '';

        $response = $this->httpClient->request(
            'GET',
            $this->params->get('api_url') . '/api/v2/authors' . $pageQueryParameter,
            [
                'auth_bearer' => $this->security->getUser()->getToken()
            ]
        );

        return $this->serializer->deserialize($response->getContent(), PaginatedAuthors::class, 'json');
    }

    public function getAuthor(int $id): Author
    {
        $response = $this->httpClient->request(
            'GET',
            $this->params->get('api_url') . '/api/v2/authors/' . $id,
            [
                'auth_bearer' => $this->security->getUser()->getToken()
            ]
        );

        return $this->serializer->deserialize($response->getContent(), Author::class, 'json');
    }

    public function createAuthor(Author $author, string $token = null): bool
    {
        $token = $token ?? $this->security->getUser()->getToken();

        $response = $this->httpClient->request(
            'POST',
            $this->params->get('api_url') . '/api/v2/authors',
            [
                'auth_bearer' => $token,
                'json' => json_decode($this->serializer->serialize($author, 'json'), true),
            ]
        );

        return $response->getStatusCode() === Response::HTTP_OK;
    }

    public function deleteAuthor(int $id): bool
    {
        $response = $this->httpClient->request(
            'DELETE',
            $this->params->get('api_url') . '/api/v2/authors/' . $id,
            [
                'auth_bearer' => $this->security->getUser()->getToken()
            ]
        );

        return $response->getStatusCode() === Response::HTTP_NO_CONTENT;
    }
}