<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use App\Service\UserAuthenticationService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    private UserAuthenticationService $userAuthenticationService;
    private RouterInterface $router;
    private CsrfTokenManagerInterface $csrfTokenManager;
    private LoggerInterface $logger;

    public function __construct(
        UserAuthenticationService $userAuthenticationService,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager,
        LoggerInterface $logger
    ) {
        $this->userAuthenticationService = $userAuthenticationService;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->logger = $logger;
    }

    public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && $request->attributes->get('_route') === 'app_login';
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');
        $password = $request->request->get('password', '');
        $csrfToken = $request->request->get('_csrf_token');

        $this->logger->info('Authentication attempt', [
            'username' => $username,
            'route' => $request->attributes->get('_route')
        ]);
        $this->logger->info('Session Contents', [
            'session' => $request->getSession()->all(),
        ]);
        

        $customCredentials = new CustomCredentials(
            function() use ($username, $password) {
                try {
                    $authenticationResult = $this->userAuthenticationService->authenticate($username, $password);

                    $this->logger->info('Authentication result', [
                        'username' => $username,
                        'result' => $authenticationResult
                    ]);

                    if (!$authenticationResult) {
                        throw new BadCredentialsException('Authentication failed');
                    }

                    return true;
                } catch (\Exception $e) {
                    $this->logger->error('Authentication error', [
                        'username' => $username,
                        'error' => $e->getMessage()
                    ]);
                    throw $e;
                }
            },
            [
                'username' => $username,
                'password' => $password
            ]
        );

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $username);

        try {
            $user = $this->userAuthenticationService->getUser($username);
        } catch (AccessDeniedException $e) {
            $this->logger->warning('User not found', ['username' => $username]);
            throw new AuthenticationException('User not found.');
        }

        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('authenticate', $csrfToken))) {
            $this->logger->warning('Invalid CSRF token', ['username' => $username]);
            throw new InvalidCsrfTokenException('Invalid CSRF token.');
        }

        return new Passport(
            new UserBadge($username, fn() => $user),
            $customCredentials,
            [new CsrfTokenBadge('authenticate', $csrfToken)]
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
             // Add flash message
        $flashMessage = $this->getErrorMessage($exception);
        // $request->getSession()->getFlashBag()->add('danger', [$flashMessage]);
        $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);
    
        return new RedirectResponse($this->getLoginUrl($request));
    }
    
    private function getErrorMessage(AuthenticationException $exception): string
    {
        switch (true) {
            case $exception instanceof BadCredentialsException:
                return 'Nom d/’utilisateur ou mot de passe incorrect.';
            case $exception instanceof InvalidCsrfTokenException:
                return 'Le jeton CSRF est invalide. Veuillez réessayer.';
            case $exception instanceof AccessDeniedException:
                return 'Vous n/’êtes pas autorisé à vous connecter.';
            default:
                return 'Une erreur inconnue est survenue. Veuillez réessayer.';
        }
    }
    

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // $request->getSession()->getBag('flashes')->set('success', ['Connexion réussie !']);
        return new RedirectResponse($this->router->generate('app_acceuil'));
    }
    

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('app_login');
    }
}
