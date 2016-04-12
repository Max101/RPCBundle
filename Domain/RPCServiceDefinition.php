<?php

/*
 * (c) Mitja Orlic <mitja.orlic@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MO\RPCBundle\Domain;

/**
 * This class holds information about a single service available to be called as RPC
 */
class RPCServiceDefinition
{
    /** @var string */
    private $serviceName;
    /** @var string */
    private $className;
    /** @var array */
    private $parameters;
    /** @var string */
    private $method;

    /**
     * RPCServiceDefinition constructor.
     *
     * @param string $serviceName
     * @param string $className
     * @param string $method
     * @param array  $parameters
     */
    public function __construct($serviceName, $className, $method, array $parameters)
    {
        $this->serviceName = $serviceName;
        $this->className   = $className;
        $this->parameters  = $parameters;
        $this->method      = $method;
    }

    /**
     * @return string
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }
}