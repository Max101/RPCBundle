<?php

/*
 * (c) Mitja Orlic <mitja.orlic@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MO\RPCBundle\Domain\Service\Utility;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Mitja Orlic <mitja.orlic@dlabs.si>
 */
class RPCHandler
{
    /** @var Metadata */
    private $metadata;
    /** @var ContainerInterface */
    private $container;

    /**
     * RPCHandler constructor.
     *
     * @param Metadata           $metadata
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container, Metadata $metadata)
    {
        $this->metadata  = $metadata;
        $this->container = $container;
    }


    /**
     * Will handle an RPC request, validating that the given service exists and method is callable
     *
     * @param string $serviceName
     * @param string $methodName
     * @param mixed  $arguments
     *
     * @return mixed
     */
    public function handle($serviceName, $methodName = null, $arguments = [])
    {
        $metadata = $this->metadata->getMetadata($serviceName, $methodName);

        $service = $this->container->get($metadata->getServiceName());

        $methodName = $metadata->getMethod();

        try {
            $result = call_user_func_array([$service, $methodName], $arguments);
        } catch (\Exception $e) {
            dump($e);
            die;
        }


        return $result;
    }


}