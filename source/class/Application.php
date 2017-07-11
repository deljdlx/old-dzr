<?php

namespace DZR;


class Application
{

    /**
     * @var Route[]
     */
    private $routes = array();

    private $containers = array();

    /**
     * @var Request
     */
    private $request;


    private $headers=array();


    public function __construct()
    {

    }

    public function register($name, $something)
    {
        $this->containers[$name] = $something;
        return $this;
    }

    public function get($name)
    {
        if (array_key_exists($name, $this->containers)) {
            return $this->containers[$name];
        }
        else {
            return null;
        }
    }


    public function route($regexp, $callback, $verb='GET')
    {

        $route = new Route($this, $verb, $regexp, $callback);
        $this->routes[] = $route;
        return $route;
    }




    function sendJSONResponse($data, $additionnalHeaders=array()) {
        $this->headers[]='Content-type: application/json, charset="utf-8"';
        foreach ($additionnalHeaders as $header) {
            $this->headers[]=$header;
        }

        $this->sendHeaders();
        echo json_encode($data);
    }

    public function notFound() {
        $this->headers[]="HTTP/1.0 404 Not Found";
        return $this;
    }


    public function sendHeaders() {
        foreach ($this->headers as $header) {
            header($header);
        }
        return $this;
    }


    public function run(Request $request)
    {
        $this->request=$request;

        foreach ($this->routes as $route) {
            if ($route->validate($request)) {

                $route->execute();
                return $route;
            }
        }
        return false;
    }


}