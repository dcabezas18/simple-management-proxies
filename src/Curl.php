<?php
/**
 * Created by PhpStorm.
 * User: Daniel Cabezas
 * Date: 25/03/2018
 * Time: 10:50
 */

namespace dcabezas18\SimpleManagementProxies;


class Curl
{

    /**
     * @param $url
     * @param $proxy
     * @return mixed
     */
    public function request($url, $options, $proxy)
    {
        $opt['proxy_user'] = getenv('PROXY_USER');
        $opt['proxy_password'] = getenv('PROXY_PASSWORD');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy->ip . ':' . $proxy->port);
        if(!empty($opt['proxy_user']) && !empty($opt['proxy_password']))
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $opt['proxy_user'] . ':' . $opt['proxy_password']);

        $this->getOptions($ch, $options);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    /**
     * @param $ch
     * @param $options
     */
    private function getOptions($ch, $options)
    {
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        foreach ($options as $key => $value){
            curl_setopt($ch, $key, $value);
        }
    }
}