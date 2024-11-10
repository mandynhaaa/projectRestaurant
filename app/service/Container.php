<?php

namespace App\Service;

use App\Controller\Controller;

class Container {
    private $services = [];

    public function set(string $name, Controller $service) {
        $this->services[$name] = $service;
    }

    public function get(string $name) {
        return $this->services[$name];
    }

    public function has(string $name) {
        return isset($this->services[$name]);
    }
}