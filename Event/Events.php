<?php

namespace Thenbsp\CartBundle\Event;

final class Events
{
    /**
     * 添加到购物车之前调用
     */
    const ADD_BEFORE = 'cart.add_before';

    /**
     * 添加加购物车之后凋用
     */
    const ADD_AFTER = 'cart.add_after';

    /**
     * 从购物车移除之前调用
     */
    const REMOVE_BEFORE = 'cart.remove_before';

    /**
     * 从购物车移除之后调用
     */
    const REMOVE_AFTER = 'cart.remove_after';

    /**
     * 清空购物车之前调用
     */
    const CLEAR_BEFORE = 'cart.clear_before';

    /**
     * 清空购物车之后调用
     */
    const CLEAR_AFTER = 'cart.clear_after';
}
