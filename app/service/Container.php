<?php

namespace App\Service;

class Container {
    private $services = [];

    public function set($name, $service) {
        $this->services[$name] = $service;
    }

    public function get($name) {
        return $this->services[$name];
    }

    public function has($name) {
        return isset($this->services[$name]);
    }
}
