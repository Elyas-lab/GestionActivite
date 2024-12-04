<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use App\Service\UserAuthenticationService;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    private $userAuthenticationService;
    private $router;
    private $csrfTokenManager;


    public function __construct(
        UserAuthenticationService $userAuthenticationService, 
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
        
    ) {
        $this->userAuthenticationService = $userAuthenticationService;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        
    }

    public function supports(Request $request): bool
    {
        // Log request method and route to check if they match the expected values
         // Log method
        // dd($request->attributes->get('_route')); // Log route
    
        if ( $request->isMethod('POST') && $request->attributes->get('_route') === 'app_login'){ 
            
            // dd($request->getMethod());
            return true;}

        return false;
    }
    

    public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');
        $password = $request->request->get('password', '');
        // CSRF Token retrieval
        $csrfToken = $request->request->get('_csrf_token');
    
        // Create custom credentials with authentication validation
        $customCredentials = new CustomCredentials(
            function($credentials) use ($username, $password) {
                    // Attempt authentication through the service
                    $authenticationResult = $this->userAuthenticationService->authenticate($username, $password);
                    
                    // If authentication fails, throw an exception
                    if (!$authenticationResult) {
                        throw new BadCredentialsException('Authentication failed');
                        return false;
                    }
                    
                    return true;
            },
            [
                'username' => $username,
                'password' => $password
            ]
        );
        // dd($customCredentials);
    
        // Store the last username in the session
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $username);
    
        // Create the UserBadge with the correct user retrieval method
        $user = $this->userAuthenticationService->getUser($username);

        // Ensure the user is loaded
        if (!$user) {
            throw new AuthenticationException('User not found.');
        }

        // Now create the UserBadge with the user object
        $userBadge = new UserBadge($username, function() use ($user) {
            return $user;
        });
        // dd($userBadge);
    
        // Valider le token CSRF
        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('authenticate', $csrfToken))) {
            throw new InvalidCsrfTokenException('Invalid CSRF token.');
            dd($userBadge,$csrfToken,$customCredentials);
        }
        $csrfTokenBadge = new CsrfTokenBadge('authenticate', $csrfToken);
        // dd($csrfTokenBadge);
    
        // Return the Passport with custom credentials
        return new Passport($userBadge, $customCredentials, [$csrfTokenBadge]);
    }


    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ($request->hasSession()) {
            $request->getSession()->set(SecurityRequestAttributes::AUTHENTICATION_ERROR, $exception);
        }

        $url = $this->getLoginUrl($request);

        return new RedirectResponse($url);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('app_acceuil'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate('app_login');
    }
}

