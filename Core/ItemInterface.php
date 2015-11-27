<?php

namespace Thenbsp\CartBundle\Core;

interface ItemInterface
{
    /**
     * 获取项目
     */
    public function getEntity();

    /**
     * 获取数量
     */
    public function getQuantity();
}
