<?php
/**
 * Created by PhpStorm.
 * User: Daniel Cabezas
 * Date: 24/03/2018
 * Time: 13:08
 */

namespace dcabezas18\SimpleManagementProxies;

use Tightenco\Collect\Support\Collection;

class Proxies
{
    private $proxy;
    private $proxies;
    private $init;
    private $end;
    private $time;

    /**
     * Proxies constructor.
     * @param $proxies
     */
    public function __construct($proxies)
    {
        $this->setProxies($proxies);
    }

    /**
     * @return mixed
     * @internal param $url
     * @internal param array $options
     */
    public function get($url, array $options = [])
    {
        $this->proxy = $this->getProxyMinTime();
        $this->init = microtime(true);
        $curl = new Curl();
        $curl->request($url, $options, $this->proxy);
        $this->end = microtime(true);
        $this->getTimeToSave();
        $this->setProxyTime($this->time);
        return $this->proxy;
    }

    /**
     * @param array $proxies
     */
    private function setProxies(array $proxies)
    {
        $this->proxies = collect();

        foreach ($proxies as $key =>$proxy){
            $pr = new \stdClass();
            $isAssoc = array_keys($proxy) !== range(0, count($proxy)-1);
            if($isAssoc){
                $pr->ip = $proxy['ip'];
                if (!empty($proxy['port'])) $pr->port = $proxy['port'];
            }else {
                $pr->ip = $proxy[0];
                if (!empty($proxy[1])) $pr->port = $proxy[1];
            }
            $pr->time = 0;
            $this->proxies->put($key, $pr);
        }
    }

    private function getTimeToSave()
    {
        if(!empty($this->end) && !empty($this->init))
            $this->time = $this->end - $this->init;
        else $this->time = 0;
    }

    /**
     * @param $time
     */
    private function setProxyTime($time)
    {
        foreach ($this->proxies as $pr){
            if($pr->ip == $this->proxy->ip){
                $pr->time = $pr->time + $time;
            }
        }
    }

    /**
     * @return Collection
     */
    public function getProxyMinTime()
    {
        $minTime = $this->proxies->min('time');
        return $this->proxies->where('time', $minTime)->first();
    }
}