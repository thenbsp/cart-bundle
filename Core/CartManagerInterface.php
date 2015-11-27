<?php

namespace Thenbsp\CartBundle\Core;

use Thenbsp\CartBundle\Core\EntityInterface;

interface CartManagerInterface
{
    /**
     * 向购物车添加项目
     */
    public function addItem(EntityInterface $entity, $quantity = 1);

    /**
     * 检测购物车中是否包含指定项目
     */
    public function hasItem($itemOrId);

    /**
     * 从购物车中移除指定项目
     */
    public function removeItem($itemOrId);

    /**
     * 获取购物车中的全部项目
     */
    public function getItems();

    /**
     * 获取购物车中的项目个数
     */
    public function count();

    /**
     * 获取购物车中的项目总计
     */
    public function total();

    /**
     * 格式化购物车中的项目总计
     */
    public function totalFormated();

    /**
     * 检测购物车中否为空
     */
    public function isEmpty();

    /**
     * 清空购物车
     */
    public function clear();
}
