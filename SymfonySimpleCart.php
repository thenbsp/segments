<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    /**
     * Session bag
     */
    const CART = '_cart';

    /**
     * Session
     */
    protected $session;

    /**
     * Repository
     */
    protected $repository;

    /**
     * 构造方法
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->session      = $session;
        $this->repository   = $em->getRepository('AppBundle:Product');
    }

    /**
     * 检测购物车是否包含指定项目
     */
    public function hasProduct(Product $product)
    {
        return array_key_exists($product->getId(), $this->getMapping());
    }

    /**
     * 向购物车添加指定项目
     */
    public function addProduct(Product $product, $quantity = 1)
    {
        if( $product->isUnavailable() ) {
            throw new \InvalidArgumentException('Product unavailable');
        }

        $mapping = $this->getMapping();

        // if( $this->hasProduct($product) ) {
        //     $quantity += $mapping[$product->getId()];
        // }

        $mapping[$product->getId()] = $quantity;

        $this->session->set(self::CART, $mapping);
    }

    /**
     * 从购物车中移除指点定项目
     */
    public function removeProduct(Product $product)
    {
        if( !$this->hasProduct($product) ) {
            throw new \InvalidArgumentException('Product invalid');
        }

        $mapping = $this->getMapping();
        unset($mapping[$product->getId()]);

        $this->session->set(self::CART, $mapping);
    }

    /**
     * 获取购物车中的全部项目信息
     */
    public function getProducts()
    {
        if( !$this->getCount() ) {
            return;
        }

        $products = array();

        foreach( $this->getMapping() AS $k=>$v ) {
            $item = $this->repository->find($k);
            if( $item && $item->isAvailable() ) {
                $products[] = array(
                    'product'   => $item,
                    'quantity'  => $v
                );
            }
        }

        return $products;
    }

    /**
     * 获取购物车中的项目数量
     */
    public function getCount()
    {
        return count($this->getMapping());
    }

    /**
     * 获取购物车中的金额总计
     */
    public function getTotal()
    {
        $total = 0;

        if( !$products = $this->getProducts() ) {
            return $total;
        }
        
        foreach( $products AS $k=>$v ) {
            $total += ($v['product']->getPrice() * $v['quantity']);
        }

        return round($total, 2);
    }

    /**
     * 获取格式化的金额总计
     */
    public function getTotalFormated()
    {
        return number_format($this->getTotal(), 2);
    }

    /**
     * 清除购物车中的所有项目
     */
    public function clear()
    {
        $this->session->remove(self::CART);
    }

    /**
     * 获取 产品/数量 映射关系，因为产品信息太多，全都存在 Session 不太优雅
     * 要获取购物车中的产品详细信息，请使用 $this->getProducts() 方法。
     */
    protected function getMapping($default = array())
    {
        return $this->session->get(self::CART, $default);
    }
}
