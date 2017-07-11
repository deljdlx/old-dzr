<?php

namespace DZR;


class Datasource
{

    /**
     * @var \PDO
     */
    private $driver;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }


    public function execute($query, array $parameters=array())
    {
        $statement = $this->driver->prepare($query);
        if(!$statement) {

            $errorInfo=$this->driver->errorInfo();
            $message='';
            foreach ($errorInfo as $key=>$value) {
                $message.='['.$key. "] ".$value."\n";
            }


            throw new \Exception(
                'PDO error : '.$message
            );
        }
        $result = $statement->execute($parameters);

        if ($result) {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }


    public function lastInsertId($name = null)
    {
        return $this->driver->lastInsertId($name);
    }


    public function getDriver()
    {
        return $this->driver;
    }

}