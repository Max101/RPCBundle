<?php

namespace MO\RPCBundle\Domain\Service\Utility;

use MO\RPCBundle\Domain\Exception\RPCMethodNotFoundException;
use MO\RPCBundle\Domain\Exception\RPCServiceNotFoundException;

/**
 * @author Mitja Orlic <mitja.orlic@dlabs.si>
 */
class Metadata
{
    private $definitions;

    public function __construct($definitions)
    {
        $this->definitions = $definitions;
    }

    public function isValidRequest($serviceName, $method, $method)
    {
        $serviceMetadata = $this->getMetadata($serviceName, $method);

        var_dump($serviceMetadata);die;

        return $serviceMetadata;
    }

    private function getMetadata($serviceName, $method)
    {
        $method = $method ?: '_default';

        if (is_string($this->definitions)) {
            $this->definitions = unserialize($this->definitions);
        }

        if (!isset($this->definitions[$serviceName])) {
            throw new RPCServiceNotFoundException(sprintf('The given RPC service [%s] was not found!', $serviceName));
        }

        if (!isset($this->definitions[$serviceName][$method])) {
            throw new RPCMethodNotFoundException(sprintf(
                'Method [%s] does not exist or is not available for RPC service [%s]!',
                $method,
                $serviceName
            ));
        }

        return $this->definitions[$serviceName][$method];
    }
}