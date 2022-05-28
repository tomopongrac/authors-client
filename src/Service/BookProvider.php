<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Book;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BookProvider
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

    public function createBook(Book $book)
    {
        $response = $this->httpClient->request(
            'POST',
            $this->params->get('api_url') . '/api/v2/books',
            [
                'auth_bearer' => $this->security->getUser()->getToken(),
                'json' => json_decode($this->serializer->serialize($book, 'json'), true),
            ]
        );

        return $response->getStatusCode() === Response::HTTP_OK;
    }

    public function deleteBook(int $id)
    {
        $response = $this->httpClient->request(
            'DELETE',
            $this->params->get('api_url') . '/api/v2/books/' . $id,
            [
                'auth_bearer' => $this->security->getUser()->getToken()
            ]
        );

        return $response->getStatusCode() === Response::HTTP_NO_CONTENT;
    }
}