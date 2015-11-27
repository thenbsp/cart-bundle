<?php

namespace Thenbsp\CartBundle\Core;

interface EntityInterface
{
    /**
     * 商品编号
     */
    public function getId();

    /**
     * 商品单价
     */
    public function getPrice();
}