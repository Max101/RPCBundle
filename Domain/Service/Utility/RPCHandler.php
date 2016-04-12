<?php

namespace MO\RPCBundle\Domain\Service\Utility;

use MO\RPCBundle\Domain\Exception\RPCServiceNotFoundException;

/**
 * @author Mitja Orlic <mitja.orlic@dlabs.si>
 */
class RPCHandler
{
    /** @var Metadata */
    private $metadata;


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
     *
     *
     * @param string $serviceName
     * @param string $methodName
     * @param mixed  $arguments
     *
     * @return mixed
     */
    public function handle($serviceName, $methodName = null, $arguments = null)
    {
        $metadata = $this->isValidRequest($serviceName, $methodName);

        $service = new \StdClass();

        return call_user_func_array([$service, $methodName], $arguments);
    }



}