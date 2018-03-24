<?php

class Profiler {

    protected $startTime;
    protected $stopTime;
    public function __construct(){}

    public function start(){
        $this->startTime = microtime(true);
    }

    public function stop(){
        $this->stopTime = microtime(true);
    }

    public function show(){
        return ($this->stopTime - $this->startTime);
    }
}