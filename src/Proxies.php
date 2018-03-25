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
    private $client;
    private $request;

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
    public function get()
    {
        $this->proxy = $this->getProxyMinTime();
        $this->init = microtime(true);
        $this->getRequestMethod();
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
        $this->proxies = collect($proxies);
        foreach ($this->proxies as $proxy){
            $proxy->time = 0;
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

    public function setRequestMethod($request){
        $this->request = $request;
    }

    public function getRequestMethod()
    {
        return $this->request;
    }
}