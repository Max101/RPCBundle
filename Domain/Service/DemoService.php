<?php

namespace MO\RPCBundle\Domain\Service;

/**
 * @author Mitja Orlic <mitja.orlic@dlabs.si>
 */
class DemoService
{
    private function hello($lol)
    {
        return '0.0.1';
    }
    protected function buhu($lolz, array $hey)
    {
        return '0.0.1';
    }
    public function getVersion()
    {
        return '0.0.1';
    }
    public function getVersion1(array $input = [])
    {
        return '0.0.1';
    }

    public function getVer(array $input = [])
    {
        return '0.0.1';
    }
}