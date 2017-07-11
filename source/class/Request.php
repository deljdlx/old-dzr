<?php

namespace DZR;


class Request
{
    private $values;

    public function __construct($values = null)
    {
        if ($values === null) {
            $values = $_SERVER;
        }
        $this->values = $values;
    }


    public function getURI()
    {
        if (array_key_exists('REQUEST_URI', $this->values)) {
            return $this->values['REQUEST_URI'];
        }
        else {
            return null;
        }
    }

    public function getVerb()
    {

        if(array_key_exists('REQUEST_METHOD', $this->values)) {
            return $this->values['REQUEST_METHOD'];
        }
        else {
            return null;
        }
    }


}