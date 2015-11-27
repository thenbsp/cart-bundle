<?php

namespace Thenbsp\CartBundle\Storage;

use Thenbsp\CartBundle\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionStorage implements StorageInterface
{
    /**
     * Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    /**
     * 构造方法
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Checks if an attribute is defined
     */
    public function has($name)
    {
        return $this->session->has($name);
    }

    /**
     * Sets an attribute
     */
    public function set($name, $value)
    {
        return $this->session->set($name, $value);
    }

    /**
     * Returns an attribute
     */
    public function get($name, $default = null)
    {
        return $this->session->get($name, $default);
    }

    /**
     * Returns attributes
     */
    public function all()
    {
        return $this->session->all();
    }

    /**
     * Removes an attribute
     */
    public function remove($name)
    {
        return $this->session->remove($name);
    }

    /**
     * Clears all attributes
     */
    public function clear()
    {
        return $this->session->clear();
    }
}
