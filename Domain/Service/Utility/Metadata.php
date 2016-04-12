<?php

/*
 * (c) Mitja Orlic <mitja.orlic@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MO\RPCBundle\Domain\Service\Utility;

use MO\RPCBundle\Domain\Exception\RPCMethodNotFoundException;
use MO\RPCBundle\Domain\Exception\RPCServiceNotFoundException;
use MO\RPCBundle\Domain\RPCServiceDefinition;

/**
 * This class holds info about each service available as RPC and provides information for calling the service
 */
class Metadata
{
    /** @var array */
    private $definitions;

    /**
     * @param array $definitions
     */
    public function __construct(array $definitions = [])
    {
        $this->definitions = $definitions;
    }

    /**
     * If found, it will return an RPCServiceDefinition instance
     *
     * @param string $serviceName The rpc tagged service to look for
     * @param string $method      The method inside the service to look for
     *
     * @return RPCServiceDefinition
     */
    public function getMetadata($serviceName, $method)
    {
        $method = $method ?: '_default';

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

        if (is_string($this->definitions[$serviceName][$method])) {
            $this->definitions[$serviceName][$method] = unserialize($this->definitions[$serviceName][$method]);
        }

        return $this->definitions[$serviceName][$method];
    }

    /**
     * SLOW METHOD! Used for generating documentation.
     * Provides info about ALL available RPC services
     *
     * @internal
     * @return array
     */
    public function getllMetadata()
    {
        foreach ($this->definitions as $service => &$definitions) {
            foreach ($definitions as $method => &$definition) {
                if (is_string($definition)) {
                    $definition = unserialize($definition);
                }
            }
        }
        return $this->definitions;
    }

}