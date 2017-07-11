<?php
namespace DZR;

class Response
{

    const NOT_FOUND='HTTP/1.0 404 Not Found';
    const INTERNAL_SERVER_ERROR='HTTP/1.0 500 Internal Server Error';

    private $headers = array();
    private $body = '';


    public function __construct($body = '', $headers = array())
    {
        $this->body = $body;
        $this->headers = (array) $headers;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }


    public function send()
    {
        $this->sendHeaders();
        echo $this->body;
    }


    public function sendHeaders()
    {

        foreach ($this->headers as $header) {
            header($header);
        }
        return $this;
    }

}