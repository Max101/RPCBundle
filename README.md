RPC Bundle for Symfony2
===

### MO\RPCBundle: RPC-enabled Symfony2 services from Symfony2 container

This bundle enables services defined inside the symfony container to be exposed over HTTP protocol (Controller endpoints).

This bundle enables you:

* Define RPC-enabled classes in a service available for RPC calls
* Define specific methods as services
* 

## Installation

* Use [Composer](https://getcomposer.org/) to install this bundle:

    composer require mo/rpc-bundle

* Add the bundle in your application kernel:

```php
// app/AppKernel.php

public function registerBundles()
{
    return [
        // ...
        new MO\RPCBundle\RPCBundle(),
        // ...
    ];
}
```

* Routing: you can set up custom routing or use the default one by adding the following lines in `app/config/routing.yml`:

```yaml
rpc_bundle:
    resource: "@RPCBundle/Resources/config/routing.yml"
```

If you don't want to use default routing, you can use your own routes like this:

```yaml
mo.rpc.run:
    path: /rpc/execute/{service}/{method}
    methods: [GET]
    defaults: { _controller: RPCBundle:RPC:run, service: null, method: null }
```

## Usage

1. Create a new service in the Symfony2 container and add the **rpc.service**

```yaml
    # ------------------------------------------------------------------------
    # DEMO RPC Service
    # ------------------------------------------------------------------------
    mo.rpc.service:
        class: MO\RPCBundle\Domain\Service\Demo\DemoService
        arguments:
            - '0.0.1'
            - '@?doctrine.dbal.default_connection'
        tags:
            - { name: rpc.service }
```


## Credits

This bundle is brought to you by [Max101](https://github.com/Max101) and [awesome contributors](https://github.com/Max101/RPCBundle/graphs/contributors).

