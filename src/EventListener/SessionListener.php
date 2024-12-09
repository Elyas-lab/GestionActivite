<?php
namespace App\EventListener;

use App\Service\SidebarExtension;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SessionListener
{
    private SidebarExtension $sidebarExtension;
    private TokenStorageInterface $tokenStorage;

    public function __construct(SidebarExtension $sidebarExtension, TokenStorageInterface $tokenStorage)
    {
        $this->sidebarExtension = $sidebarExtension;
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $session = $event->getRequest()->getSession();
        $user = $this->tokenStorage->getToken()?->getUser();

        if ($user && !$session->has('sidebar_permissions')) {
            $permissions = $this->sidebarExtension->getSidebarItems();
            $session->set('sidebar_permissions', $permissions);
        }
    }
}