<?php

/**
 * Created by PhpStorm.
 * User: Daniel Cabezas
 * Date: 24/03/2018
 * Time: 13:02
 */

class proxiesTests extends \PHPUnit_Framework_TestCase
{

    public function dataProvider()
    {
        return [
            [[['192.168.1.1', 8080],
            ['192.168.1.2', 8080],
            ['192.168.1.3', 8080],
            ['192.168.1.4', 8080],
            ['192.168.1.5', 8080],
            ['192.168.1.6', 8080]]]
        ];
    }
    /**
     * @dataProvider dataProvider
     */
    public function testManagement($proxies)
    {
        $management = new dcabezas18\SimpleManagementProxies\Proxies($proxies);
        foreach ($proxies as $pr){
            $proxy = $management->getProxyMinTime();
            $curl = new dcabezas18\SimpleManagementProxies\Curl();
            $management->setRequestMethod($curl->request('www.google.es', $proxy));
            $lastUsedProxy = $management->get();

        }
    }
}
