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
            [[['192.168.1.1', 80],
            ['192.168.1.2', 80],
            ['192.168.1.3', 80],
            ['192.168.1.4', 80],
            ['192.168.1.5', 80],
            ['192.168.1.6', 80]]]
        ];
    }
    /**
     * @dataProvider dataProvider
     */
    public function testManagement($proxies)
    {
        $management = new dcabezas18\SimpleManagementProxies\Proxies($proxies);
        foreach ($proxies as $pr){
            $lastUsedProxy = $management->get('www.google.es');
            print_r($lastUsedProxy);
        }
    }
}
