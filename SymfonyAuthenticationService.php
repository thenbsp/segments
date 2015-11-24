<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Authentication
{
    /**
     * Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * 构造方法
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        EventDispatcherInterface $eventDispatcher,
        RequestStack $requestStack)
    {
        $this->tokenStorage     = $tokenStorage;
        $this->eventDispatcher  = $eventDispatcher;
        $this->request          = $requestStack->getCurrentRequest();
    }

    /**
     * 认证用户
     */
    public function authenticate(User $user, $providerKey)
    {
        $authenticationToken = new UsernamePasswordToken($user, $user->getPassword(), $providerKey, $user->getRoles());
        $authenticationEvent = new InteractiveLoginEvent($this->request, $authenticationToken);

        $this->tokenStorage->setToken($authenticationToken);
        $this->eventDispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $authenticationEvent);
    }

    /**
     * 取消认证
     */
    public function unauthenticate($invalidateSession = false)
    {
        $this->tokenStorage->setToken();

        if( $invalidateSession ) {
            $session = $this->request->getSession();
            $session->invalidate();
        }
    }
}
