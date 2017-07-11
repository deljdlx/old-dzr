<?php

namespace DZR;


class Route
{
    /**
     * @var Application
     */
    private $application;

    private $verb;
    private $regexp;


    /**
     * @var \Closure
     */
    private $callback;
    private $parameters = array();


    /** Application is not an interface  **/
    public function __construct(Application $application, $verb, $regexp, $callback)
    {
        $this->application = $application;
        $this->verb = $verb;
        $this->regexp = $regexp;
        $this->callback = $callback;
    }

    /** same for Request ; but who will res-use this ?! **/
    public function validate(Request $request)
    {
        $verbValid = false;
        if (is_array($this->verb)) {
            if (in_array($request->getVerb(), $this->verb)) {
                $verbValid = true;
            }
        }
        else {
            if($request->getVerb() === $this->verb ) {
                $verbValid = true;
            }
        }

        /** it works but must be refactored if i want to do something like Sy....*/
        if (preg_match_all($this->regexp, $request->getURI(), $matches, \PREG_SET_ORDER) && $verbValid) {

            if (array_key_exists(0, $matches)) {

                $parameters = $matches[0];
                array_shift($parameters);
                $this->parameters = $parameters;
            }

            return true;
        }
        else {
            return false;
        }
    }

    public function execute()
    {
        $closure = $this->callback->bindTo($this->application, $this->application);
        return call_user_func_array($closure, $this->parameters);
    }


}