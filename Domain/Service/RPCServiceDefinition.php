<?php

namespace MO\RPCBundle\Domain\Service;

/**
 * @author  Mitja Orlic <mitja.orlic@dlabs.si>
 * @package MO\RPCBundle\Domain\Service
 */
class RPCServiceDefinition
{
    private $serviceName;
    private $className;
    private $parameters;
    /**
     * @var string
     */
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


}