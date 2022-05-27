<?php

namespace App\Security;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppLoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    private ContainerBagInterface $params;

    public function __construct(UrlGeneratorInterface $urlGenerator, HttpClientInterface $httpClient, ContainerBagInterface $params)
    {
        $this->urlGenerator = $urlGenerator;
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');
        $password = $request->request->get('password', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new SelfValidatingPassport(
            new UserBadge($email, function () use ($email, $password) {
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

                $userDecode = json_decode($response->getContent(), true);
                $user = (new User())
                    ->setEmail($userDecode['user']['email'])
                    ->setFirstName($userDecode['user']['first_name'])
                    ->setLastName($userDecode['user']['last_name']);

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_profile'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
