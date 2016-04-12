<?php

/*
 * (c) Mitja Orlic <mitja.orlic@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MO\RPCBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Mitja Orlic <mitja.orlic@gmail.com>
 */
class RPCController extends Controller
{
    public function runAction(Request $request)
    {
        $RPCHandler = $this->get('mo.rpc.handler');

        $serviceName = $request->get('service', 'mo.rpc.service');
        $method      = $request->get('method', null);
        $arguments   = $request->get('arguments', []);

        $result = $RPCHandler->handle($serviceName, $method, $arguments);

        return new JsonResponse($result);
    }

    public function documentationAction(Request $request)
    {
        $metadata = $this->get('mo.rpc.metadata');

        // Will render a documentation listing all services available and methods
        $parameters = [
            'services' => $metadata->getllMetadata()
        ];

        return $this->render('RPCBundle::documentation.html.twig', $parameters);
    }
}