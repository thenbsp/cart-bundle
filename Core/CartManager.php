<?php

namespace Thenbsp\CartBundle\Core;

use Thenbsp\CartBundle\Core\Item;
use Thenbsp\CartBundle\Core\ItemInterface;
use Thenbsp\CartBundle\Core\EntityInterface;
use Thenbsp\CartBundle\Core\CartManagerInterface;
use Thenbsp\CartBundle\Storage\StorageInterface;
use Thenbsp\CartBundle\Utils\CurrencyUtils;
use Thenbsp\CartBundle\Event\Events;
use Thenbsp\CartBundle\Event\FilterItemEvent;
use Thenbsp\CartBundle\Event\FilterItemsEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CartManager implements CartManagerInterface
{
    /**
     * Cart Session Bag
     */
    const CART = '_cart';

    /**
     * Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * CartBundle\Storage\StorageInterface
     */
    protected $storage;

    /**
     * CartBundle\Utils\CurrencyUtils
     */
    protected $currencyUtils;

    /**
     * 构造方法
     */
    public function __construct(EventDispatcherInterface $dispatcher, StorageInterface $storage, CurrencyUtils $currencyUtils)
    {
        $this->storage          = $storage;
        $this->dispatcher       = $dispatcher;
        $this->currencyUtils    = $currencyUtils;
    }

    /**
     * 向购物车添加项目
     */
    public function addItem(EntityInterface $entity, $quantity = 1)
    {
        $item   = new Item($entity, $quantity);
        $event  = new FilterItemEvent($item);

        $items = $this->getItems();
        $items[$entity->getId()] = $item;

        // dispatch event Events::ADD_BEFORE with arguments $event
        $this->dispatcher->dispatch(Events::ADD_BEFORE, $event);

        if( $event->isPropagationStopped() ) {
           return; 
        }

        $this->storage->set(self::CART, $items);

        // dispatch event Events::ADD_AFTER with arguments $event
        $this->dispatcher->dispatch(Events::ADD_AFTER, $event);
    }

    /**
     * 检测购物车中是否包含指定项目
     */
    public function hasItem($itemOrId)
    {
        $id = $this->_getId($itemOrId);

        return array_key_exists($id, $this->getItems());
    }

    /**
     * 从购物车中移除指定项目
     */
    public function removeItem($itemOrId)
    {
        $id = $this->_getId($itemOrId);

        if( !$this->hasItem($id) ) {
            return;
        }

        $items = $this->getItems();
        $event = new FilterItemEvent($items[$id]);

        // dispatch event Events::REMOVE_BEFORE with arguments $event
        $this->dispatcher->dispatch(Events::REMOVE_BEFORE, $event);

        if( $event->isPropagationStopped() ) {
           return; 
        }

        $items = $this->getItems();
        unset($items[$id]);

        $this->storage->set(self::CART, $items);

        // dispatch event Events::REMOVE_AFTER with arguments $event
        $this->dispatcher->dispatch(Events::REMOVE_AFTER, $event);
    }

    /**
     * 获取购物车中的全部项目
     */
    public function getItems()
    {
        return $this->storage->get(self::CART, array());
    }

    /**
     * 获取购物车中的项目个数
     */
    public function count()
    {
        return count($this->getItems());
    }

    /**
     * 获取购物车中的项目总计
     */
    public function total()
    {
        if( $this->isEmpty() ) {
            return 0;
        }

        $subtotal = array();

        foreach( $this->getItems() AS $item ) {
            array_push($subtotal, $this->_getSubtotal($item));
        }

        return array_sum($subtotal);
    }

    /**
     * 格式化购物车中的项目总计
     */
    public function totalFormated()
    {
        return $this->currencyUtils->toFormated($this->total());
    }

    /**
     * 检测购物车中否为空
     */
    public function isEmpty()
    {
        return ($this->count() === 0);
    }

    /**
     * 清空购物车
     */
    public function clear()
    {
        $event = new FilterItemsEvent($this->getItems());

        // dispatch event Events::CLEAR_BEFORE with arguments $event
        $this->dispatcher->dispatch(Events::CLEAR_BEFORE, $event);

        if( $event->isPropagationStopped() ) {
           return; 
        }

        $this->storage->remove(self::CART);

        // dispatch event Events::CLEAR_AFTER with arguments $event
        $this->dispatcher->dispatch(Events::CLEAR_AFTER, $event);
    }

    /**
     * 获取 ID
     */
    private function _getId($itemOrId)
    {
        return ($itemOrId instanceof EntityInterface)
            ? $itemOrId->getId()
            : $itemOrId;
    }

    /**
     * 获取小计
     */
    private function _getSubtotal(ItemInterface $item)
    {
        $price = $item->getEntity()->getPrice();
        $price = $this->currencyUtils->toCurrency($price);

        return ($price * $item->getQuantity());
    }
}
