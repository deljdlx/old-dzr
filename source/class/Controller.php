<?php

namespace DZR;


class Controller
{

    public function __construct()
    {

    }

    public function inject($name, $value) {
        $this->$name=$value;
        return $this;
    }
}