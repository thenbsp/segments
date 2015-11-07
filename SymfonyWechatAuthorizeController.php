<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class WechatController extends Controller
{
    /**
     * @Route("/authorize", name = "app_authorize")
     */
    public function authorizeAction(Request $request)
    {
        $callback = $this->generateUrl('app_authorize_callback', array(
            'continue' => $this->_getRefererUrl()), true);

        $client         = $this->get('wechat.oauth.client');
        $authorizeUrl   = $client->getAuthorizeUrl($callback, 'snsapi_userinfo');

        return $this->redirect($authorizeUrl);
    }

    /**
     * @Route("/authorize/callback", name = "app_authorize_callback")
     */
    public function authorizeCallbackAction(Request $request)
    {
        if( !$code = $request->query->get('code') ) {
            throw $this->createNotFoundException();
        }

        $client = $this->get('wechat.oauth.client');

        try {
            $token  = $client->getAccessToken($code);
            $user   = $client->getUser();
        } catch (\Exception $e) {
            exit(sprintf('获取用户信息失败（%s）', $e->getMessage()));
        }

        $repository = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User');

        if( !$entity = $repository->getByOpenid($user['openid']) ) {
            $entity = new \AppBundle\Entity\User;
        }

        $entity->setOpenid($user['openid']);
        $entity->setNickname($user['nickname']);
        $entity->setProvince($user['province']);
        $entity->setCity($user['city']);
        $entity->setGender($user['sex']);
        $entity->setAvatar($user['headimgurl']);
        $entity->setAccessToken($accessToken);

        $repository->doPersist($entity);

        $token = new UsernamePasswordToken($entity, null, 'wechat', $entity->getRoles());
        $tokenStorage = $this->get('security.token_storage');
        $tokenStorage->setToken($token);

        $referer = $this->_getRefererUrl();

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
