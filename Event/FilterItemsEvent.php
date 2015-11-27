<?php

namespace Thenbsp\CartBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterItemsEvent extends Event
{
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems()
    {
        return $this->items;
    }
}
