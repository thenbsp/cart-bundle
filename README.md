# Shopping Cart for Symfony2

## 安装

```
composer require thenbsp/cart-bundle
```

## 配置

1、注册 Bundle：

```php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new Thenbsp\CartBundle\ThenbspCartBundle()
        // ...
    );
}
```

2、实现商品接口：

实现商品接口 ``Thenbsp\CartBundle\Core\EntityInterface``，该接口包含以下方法：

方法名称|说明
:---|:---
getId()|获取商品唯一标识，比如 ID、token 等
getPrice()|获取商品单价，即最终价格（float 类型）

```php
// src/AppBundle/Entity/Product.php

use Doctrine\ORM\Mapping AS ORM;
use Thenbsp\CartBudnle\Core\EntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * 返回商品唯一标识
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 返回商品单价
     */
    public function getPrice()
    {
        return $this->price;
    }

    // ...
}
```

## 使用

```php
$cart = $this->get('thenbsp_cart');
```

方法|说明|返回
:---|:---|:---
$cart->addItem($entity, $quantity);|添加商品到购物车|null
$cart->hasItem($entityOrId);|检测购物车中是否包含某个商品|boolean
$cart->removeItem($entityOrId);|从购物车中移除某商品|null
$cart->getItems();|获取购物车的全部商品|array
$cart->count();|获取购物车中的商品个数|integer
$cart->total();|获取购物车中的商品总计|float
$cart->totalFormated();|格式化购物车中的商品总计|string
$cart->isEmpty();|检测购物车是否为空|boolean
$cart->clear();|清空购物车|null

## 事件

事件名称|说明
:---|:---
Thenbsp\CartBundle\Event\Events::ADD_BEFORE|添加到购物车之前调用（可阻止）
Thenbsp\CartBundle\Event\Events::ADD_AFTER|添加到购物车之后调用
Thenbsp\CartBundle\Event\Events::REMOVE_BEFORE|移除指定商品之前调用（可阻止）
Thenbsp\CartBundle\Event\Events::REMOVE_AFTER|移除指定商品之后调用
Thenbsp\CartBundle\Event\Events::CLEAR_BEFORE|清空购物车之前调用（可阻止）
Thenbsp\CartBundle\Event\Events::CLEAR_AFTER|清空购物车之后调用

监听添加到购物车事件：

```php
// src/EventListener/CartListener.php

use Thenbsp\CartBundle\Event\Events;
use Thenbsp\CartBundle\Event\ItemEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CartListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            Events::ADD_BEFORE => 'onCartAddBefore'
        );
    }
    public function onCartAddBefore(ItemEvent $event)
    {
        // 被添加到购物车的商品对象
        $entity = $event->getEntity();
        // 商品的数量
        $quantity = $event->getQuantity();
        // 如果商品状态为 “已禁用”，则不添加到购物车
        if( $entity->getStatus() === 'disabled' ) {
            $event->stopPropagation();
        }
    }
}
```

订阅监听器：

```yaml
// src/AppBundle/Resources/config/services.yml

cart.listener:
        class: AppBundle\EventListener\CartListener
        tags:
            - { name: kernel.event_subscriber }
```
