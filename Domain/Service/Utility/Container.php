<?php

namespace MO\RPCBundle\Domain\Service\Utility;

/**
 * @author Mitja Orlic <mitja.orlic@dlabs.si>
 */
class Container implements \Iterator, \ArrayAccess
{
    /** @var array */
    private $services;
    /** @var string */
    private $errorMessage;
    /** @var bool */
    private $explicit;
    /** @var string */
    private $currentService;

    /**
     * @param array  $services
     * @param string $errorMessage
     * @param bool   $explicit
     */
    public function __construct(
        array $services = [],
        $errorMessage = 'The given service [%s] is not available! Available services are [%s]',
        $explicit = true
    ) {
        $this->services       = $services;
        $this->errorMessage   = $errorMessage;
        $this->explicit       = $explicit;
        $this->currentService = key($services);
    }

    /**
     * @param $service
     * @param $key
     */
    public function setContainerService($service, $key)
    {
        $this->services[$key] = $service;
    }

    /**
     * Gets a service from the container utility service
     *
     * @param string $serviceName The name of the service as defined in config
     * @param bool   $explicit    If explicit, it will throw an exception if the requested service is not found
     *
     * @return null|mixed
     */
    public function get($serviceName, $explicit = null)
    {
        if (
            (($explicit === null && $this->explicit === true) || $explicit === true)
            && !isset($this->services[$serviceName])
        ) {
            throw new \InvalidArgumentException(
                sprintf($this->errorMessage, $serviceName, implode(',', $this->getServiceNames()))
            );
        }

        return isset($this->services[$serviceName]) ? $this->services[$serviceName] : null;
    }

    /**
     * Get all service names from the container utility service
     *
     * @return array
     */
    public function getServiceNames()
    {
        return array_keys($this->services);
    }

    /**
     * Gets all services from the container utility service.
     */
    public function getServices()
    {
        $services = [];
        foreach ($this->getServiceNames() as $name) {
            $services[$name] = $this->get($name);
        }

        return $services;
    }

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->services[$this->currentService];
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->services);
        $this->currentService = key($this->services);
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->currentService;
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *        Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->services[$this->currentService]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->services);
        $this->currentService = key($this->services);
    }

    /**
     * Whether a offset exists
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->services[$offset]);
    }

    /**
     * Alias method for checking wether a container has a service with the given service name
     *
     * @param string $service The name of the service
     *
     * @return bool
     */
    public function has($service)
    {
        return $this->offsetExists($service);
    }

    /**
     * Offset to retrieve
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->setContainerService($offset, $value);
    }

    /**
     * Offset to unset
     *
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->services[$offset]);
    }
}