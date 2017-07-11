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


    private $headers = array();


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
        } else {
            return null;
        }
    }


    public function route($regexp, $callback, $verb = 'GET')
    {

        $route = new Route($this, $verb, $regexp, $callback);
        $this->routes[] = $route;
        return $route;
    }


    function sendJSONResponse($data, $additionnalHeaders = array())
    {
        $response=new Response(
            json_encode($data),
            array_merge((array) $additionnalHeaders, array('Content-type: application/json, charset="utf-8"'))
        );
        $response->send();
        return $response;
    }






    public function run(Request $request)
    {
        $this->request = $request;

        foreach ($this->routes as $route) {
            if ($route->validate($request)) {

                $route->execute();
                return $route;
            }
        }
        return false;
    }


}