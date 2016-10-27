<?php

namespace WechatBundle\Security\Guard\Authenticator;

use Thenbsp\Wechat\OAuth\Client;
use WechatBundle\Event\Events;
use WechatBundle\Event\WechatAuthorizeEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class WechatAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * Symfony\Component\Security\Http\Util\TargetPathTrait
     */
    use TargetPathTrait;

    /**
     * Symfony\Component\Security\Http\HttpUtils
     */
    protected $httpUtils;

    /**
     * Thenbsp\Wechat\OAuth\Client
     */
    protected $client;

    /**
     * 自定义参数
     */
    protected $options = [
        'authorize_path'    => '/wechat/authorize',
        'default_path'      => '/'
    ];

    /**
     * 构造方法
     */
    public function __construct(
        EventDispatcherInterface $dispatcher,
        HttpUtils $httpUtils,
        Client $client)
    {
        $this->dispatcher   = $dispatcher;
        $this->httpUtils    = $httpUtils;
        $this->client       = $client;
    }

    /**
     * 从 Request 对象中取得凭证
     */
    public function getCredentials(Request $request)
    {
        if (!$this->httpUtils->checkRequestPath($request, $this->options['authorize_path'])) {
            return;
        }

        if (!$request->query->has('code')) {
            return;
        }

        return $request->query->get('code');
    }

    /**
     * 根据凭证取得用户对象
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $accessToken = $this->client->getAccessToken($credentials);

            $event = new WechatAuthorizeEvent($accessToken);
            $this->dispatcher->dispatch(Events::WECHAT_AUTHORIZE, $event);

            return $event->getUser();
        } catch (\Exception $e) {
            throw new AuthenticationException($e->getMessage());
        }
    }

    /**
     * 检测用户对象是否有效
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * 认证失败操作
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $session = $request->getSession();
        $session->set(Security::AUTHENTICATION_ERROR, $exception);

        return $this->httpUtils->createRedirectResponse($request, $this->options['authorize_path']);
    }

    /**
     * 认证成功操作
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if (!$targetPath) {
            $targetPath = $this->httpUtils->generateUri($request, $this->options['default_path']);
        }

        return $this->httpUtils->createRedirectResponse($request, $targetPath);
    }

    /**
     * 是否支持自动登录
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * 防火墙入口点
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return $this->httpUtils->createRedirectResponse($request, $this->options['authorize_path']);
    }
}
