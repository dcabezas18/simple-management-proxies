<?php

/**
 * Created by PhpStorm.
 * User: Daniel Cabezas
 * Date: 24/03/2018
 * Time: 13:02
 */
use PHPUnit\Framework\TestCase;
use dcabezas18\SimpleManagementProxies\Curl;
use dcabezas18\SimpleManagementProxies\Proxies;

class proxiesTests extends TestCase
{

    public function dataProvider()
    {
        return [
            '192.168.1.1',
            '192.168.1.2',
            '192.168.1.3',
            '192.168.1.4',
            '192.168.1.5',
            '192.168.1.6',
        ];
    }
    /**
     * @dataProvider dataProvider
     */
    public function testManagement($proxies)
    {
        $management = new Proxies($proxies);
        foreach ($proxies as $pr){
            $proxy = $management->getProxyMinTime();
            $management->setRequestMethod(new Curl('www.google.es', $proxy));
            $lastUsedProxy = $management->get();

            print_r($lastUsedProxy, true);
        }
    }
}
