<?php

namespace WechatBundle\Security;

use Thenbsp\Wechat\OAuth\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class WechatAuthenticator extends AbstractGuardAuthenticator
{
    use TargetPathTrait;

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCredentials(Request $request)
    {
        return $request->query->get('code');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $accessToken = $this->client->getAccessToken($credentials);
        } catch (\Exception $e) {
            throw new AuthenticationException();
        }

        $user = $userProvider->loadUserByUsername($accessToken['openid']);
        
        var_dump($user);
        exit;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        exit($exception->getCode().': '.$exception->getMessage());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $url = $this->getTargetPath($request->getSession(), $providerKey);

        return new RedirectResponse($url);
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $request->getUriForPath('/wechat/authorize');

        return new RedirectResponse($url);
    }
}
