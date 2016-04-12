<?php

namespace MO\RPCBundle\DependencyInjection\Compiler;

use MO\RPCBundle\Domain\Service\RPCServiceDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author  Mitja Orlic <mitja.orlic@dlabs.si>
 */
class RPCCompilerPass implements CompilerPassInterface
{
    const DEFAULT_METHOD_NAME = 'default';

    private $RPC_SERVICE_CONTAINER_ID;
    private $TAG_NAME;

    /**
     * Reads tag_name from config of this extension that will set parameters in container
     *
     * @param ContainerBuilder $container
     */
    private function init(ContainerBuilder $container)
    {
        $this->TAG_NAME                 = $container->getParameter('mo.rpc.tag_name');
        $this->RPC_SERVICE_CONTAINER_ID = $container->getParameter('mo.rpc.container_service');
    }

    public function process(ContainerBuilder $container)
    {
        $this->init($container);

        $rpcServices = $container->findTaggedServiceIds($this->TAG_NAME);

        if ($rpcServices) {

//            $serviceReferences = [];
            $definitions = [];
            foreach ($rpcServices as $serviceId => $tags) {
//                $serviceReferences[$serviceId] = new Reference($serviceId);

                $className = $container->getDefinition($serviceId)->getClass();

                $definitions[$serviceId] = $this->createDefinitions($serviceId, $className);

                $defaultMethodService = null;
                foreach ($tags as $tag) {
                    if (isset($tag['default_method'])) {

                        if (!isset($definitions[$serviceId][$tag['default_method']])) {
                            throw new \InvalidArgumentException(sprintf(
                                'The given default_method [%s] is not available in class [%s]',
                                $tag['default_method'],
                                $className
                            ));
                        }

                        $defaultMethodService = $definitions[$serviceId][$tag['default_method']];
                        break;
                    }
                }

                $definitions[$serviceId]['_default'] = !$defaultMethodService ? reset($definitions) : $defaultMethodService;
            }

            $metadataService = $container->findDefinition('mo.rpc.metadata');

            $metadataService->addArgument(serialize($definitions));

//            $RPCServiceContainer = $container->getDefinition($this->RPC_SERVICE_CONTAINER_ID);

//            $RPCServiceContainer->addArgument($serviceReferences);
        }
    }

    private function createDefinitions($serviceId, $className)
    {
        $refl = new \ReflectionClass($className);

        $definitions = [];

        foreach ($refl->getMethods(\ReflectionMethod::IS_PUBLIC) as $publicMethod) {

            $parameters = [];
            foreach ($publicMethod->getParameters() as $parameter) {
                $parameters[] = $parameter->getName();
            }

            $methodName = $publicMethod->getName();

            $definitions[$methodName] = new RPCServiceDefinition($serviceId, $className, $methodName, $parameters);
        }

        if (!$definitions) {
            throw new \InvalidArgumentException(sprintf(
                'The service [%s] tagged with [%s] has no public methods available! To enable it as an RPC service you must have at least one public method!',
                $serviceId, $this->TAG_NAME
            ));
        }

        return $definitions;
    }
}
