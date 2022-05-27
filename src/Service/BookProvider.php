<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BookProvider
{
    private HttpClientInterface $httpClient;
    private ContainerBagInterface $params;
    private Security $security;

    public function __construct(HttpClientInterface $httpClient, ContainerBagInterface $params, Security $security)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
        $this->security = $security;
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