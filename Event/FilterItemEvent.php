<?php

namespace Thenbsp\CartBundle\Event;

use Thenbsp\CartBundle\Core\ItemInterface;
use Symfony\Component\EventDispatcher\Event;

class FilterItemEvent extends Event
{
    protected $item;

    public function __construct(ItemInterface $item)
    {
        $this->item = $item;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getEntity()
    {
        return $this->item->getEntity();
    }

    public function getQuantity()
    {
        return $this->item->getQuantity();
    }
}
