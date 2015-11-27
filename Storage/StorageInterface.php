<?php

namespace Thenbsp\CartBundle\Storage;

interface StorageInterface
{
    /**
     * Checks if an attribute is defined
     */
    public function has($name);

    /**
     * Sets an attribute
     */
    public function set($name, $value);

    /**
     * Returns an attribute
     */
    public function get($name, $default = null);

    /**
     * Returns attributes
     */
    public function all();

    /**
     * Removes an attribute
     */
    public function remove($name);

    /**
     * Clears all attributes
     */
    public function clear();
}
