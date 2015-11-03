<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Thenbsp\Wechat\OAuth\AccessToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WechatController extends Controller
{
    /**
     * @Route("/authorize/{scope}", name = "app_authorize",
     *      defaults = {"scope": "snsapi_userinfo"},
     *      requirements = {"scope": "snsapi_userinfo|snsapi_base"}
     * )
     */
    public function authorizeAction(Request $request, $scope)
    {
        $callbackUrl = $this->generateUrl('app_authorize_callback', array(
            'continue'  => $this->_getRefererUrl(),
            'scope'     => $scope), true);

        $client         = $this->get('wechat.oauth.client');
        $authorizeUrl   = $client->getAuthorizeUrl($callbackUrl, $scope);

        return $this->redirect($authorizeUrl);
    }

    /**
     * @Route("/authorize/{scope}/callback", name = "app_authorize_callback",
     *      defaults = {"scope": "snsapi_userinfo"},
     *      requirements = {"scope": "snsapi_userinfo|snsapi_base"}
     * )
     */
    public function authorizeCallbackAction(Request $request, $scope)
    {
        if( !$request->query->has('code') ) {
            return $this->redirect('app_authorize', array('scope'=>$scope));
        }

        $code   = $request->query->get('code');
        $client = $this->get('wechat.oauth.client');

        try {
            $accessToken = $client->getAccessToken($code);
        } catch (\Exception $e) {
            exit(sprintf('获取 AccessToken 失败（%s）', $e->getMessage()));
        }

        return $this->_authorizeComplate($accessToken);
    }

    /**
     * 授权完成
     */
    private function _authorizeComplate(AccessToken $accessToken)
    {
        $referer = $this->_getRefererUrl();

        if( $accessToken['scope'] === 'snsapi_base' ) {
            return $this->redirect($referer);
        }

        try {
            $user = new \Thenbsp\Wechat\OAuth\User($accessToken);
        } catch (\Exception $e) {
            exit(sprintf('获取 用户信息 失败（%s）', $e->getMessage()));
        }

        $em     = $this->get('doctrine.orm.entity_manager');
        $entity = $em->getRepository('AppBundle:User')
            ->findByOpenid($user['openid']);

        $entity = is_null($entity) ? new User() : $entity;
        $entity->setOpenid($user['openid']);
        $entity->setNickname($user['nickname']);
        $entity->setProvince($user['province']);
        $entity->setCity($user['city']);
        $entity->setGender($user['sex']);
        $entity->setAvatar($user['headimgurl']);
        $entity->setAccessToken($accessToken);

        $em->persist($entity);
        $em->flush();

        $token = new UsernamePasswordToken($entity, null, 'wechat', $entity->getRoles());

        $tokenStorage = $this->get('security.token_storage');
        $tokenStorage->setToken($token);

        return $this->redirect($referer);
    }

    /**
     * 获取跳转 URL
     */
    private function _getRefererUrl()
    {
        $request = $this->get('request');
        $referer = $this->generateUrl('app_homepage');

        if( $request->headers->has('referer') ) {
            $referer = $request->headers->get('referer');
        }

        if( $request->query->has('continue') ) {
            $referer = $request->query->get('continue');
        }

        return $referer;
    }
}
