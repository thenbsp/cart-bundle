<?php

namespace Thenbsp\CartBundle\Core;

use Thenbsp\CartBundle\Core\ItemInterface;
use Thenbsp\CartBundle\Core\EntityInterface;

class Item implements ItemInterface
{
    /**
     * 项目实体
     */
    protected $entity;

    /**
     * 项目数量
     */
    protected $quantity;

    /**
     * 构造方法
     */
    public function __construct(EntityInterface $entity, $quantity)
    {
        if( !($quantity = intval($quantity)) ) {
            throw new \InvalidArgumentException('Invalid item quantity: %s', $quantity);
        }

        $this->entity   = $entity;
        $this->quantity = $quantity;
    }

    /**
     * 获取项目
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * 获取数量
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
