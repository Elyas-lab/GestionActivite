<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $csrfToken = $csrfTokenManager->getToken('authenticate')->getValue();
    
        return $this->render('security/login.html.twig', [
            'csrf_token' => $csrfToken,
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
    
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new \LogicException('Logout method can be blank');
    }
}
