<?php

/*
 * (c) Mitja Orlic <mitja.orlic@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MO\RPCBundle\Domain\Service\Demo;

use Doctrine\DBAL\Connection;

/**
 * DEMO Service to demonstrate how RPC service can work
 */
class DemoService
{
    /** @var string */
    private $version;
    /** @var Connection */
    private $connection;

    /**
     * DemoService constructor.
     *
     * @param string     $version
     * @param Connection $connection
     */
    public function __construct($version, Connection $connection = null)
    {
        $this->version    = $version;
        $this->connection = $connection;
    }


    public function execute()
    {
        if(!$this->connection){
            throw new \Exception('Missing doctrine connection');
        }

        return $this->connection->query('SHOW TABLES;')->fetchAll();
    }

    /**
     * @param string $argument
     *
     * @return string
     */
    public function getVersion($argument = 'Version')
    {
        return sprintf('Arguments passed: %s, Version "%s"', json_encode($argument), $this->version);
    }

}