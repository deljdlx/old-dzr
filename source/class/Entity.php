<?php

namespace DZR;


abstract class Entity implements \JsonSerializable
{

    /**
     * @var Datasource
     */
    protected $dataSource;

    protected $values = null;

    protected $loaded = false;

    public function __construct(Datasource $datasource)
    {
        $this->dataSource = $datasource;
    }



    abstract public static function getTableName();

    abstract public static function getIdFieldName();

    /**
     * @return $this
     */
    public function store()
    {

        if (!$this->getId()) {
            $this->insert();
        } else {
            $this->update();
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $query = "
            DELETE FROM " . $this->getTableName() . "
            WHERE " . $this->getIdFieldName() . "=:id
        ";

        $this->dataSource->execute($query, array(':id' => $this->getId()));
        return $this;
    }


    /**
     * @return $this
     */
    public function update()
    {
        $fieldNames = array_keys($this->values);
        $updates = array();
        $values = array();
        foreach ($fieldNames as $fieldName) {
            if ($fieldName !== $this->getIdFieldName()) {

                $updates[] = $fieldName . '=:' . $fieldName;
                $values[':' . $fieldName] = $this->getValue($fieldName);
            }
        }
        $values[':' . $this->getIdFieldName()] = $this->getId();

        $query = "
            UPDATE " . $this->getTableName() . "
            SET
                " . implode(',', $updates) . "
            WHERE " . $this->getIdFieldName() . "=:id
        ";

        $this->dataSource->execute(
            $query,
            $values
        );
        return $this;
    }

    /**
     * @return $this
     */
    public function insert()
    {

        $this->setValue($this->getIdFieldName(), $this->generateId());

        $fieldNames = array_keys($this->values);
        $fields = implode(',', $fieldNames);
        $values = array();

        $currentValues = $this->values;

        $valuesPlaceHolders = implode(',', array_map(function ($fieldName) use (&$values, &$currentValues) {
            $key = ':' . $fieldName;
            $values[$key] = $currentValues[$fieldName];
            return $key;
        }, $fieldNames));

        $query = "
            INSERT INTO " . $this->getTableName() . " (
                " . $fields . "
            ) VALUES (
                " . $valuesPlaceHolders . "
            )
        ";

        $this->dataSource->execute(
            $query,
            $values
        );

        return $this;
    }


    /**
     * @return mixed|null
     */
    public function getId()
    {
        if (array_key_exists($this->getIdFieldName(), $this->values)) {
            return $this->values[$this->getIdFieldName()];
        } else {
            return null;
        }
    }


    /**
     * @param $id
     * @return $this
     */
    public function loadById($id)
    {
        $rows = $this->dataSource->execute(
            "SELECT * FROM " . $this->getTableName() . " WHERE " . $this->getIdFieldName() . "=:id",
            array(
                ':id' => $id
            )
        );

        if (!empty($rows)) {
            $this->loaded = true;
            $this->values = reset($rows);
            return $this;
        }
        else {
            return false;
        }

    }

    public function isLoaded($value = null)
    {
        if($value===null) {
            return $this->loaded;
        }
        else {
            $this->loaded=$value;
            return $this;
        }
    }


    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function setValue($name, $value)
    {
        $this->values[$name] = $value;
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setValues(array $values)
    {
        if(array_key_exists($this->getIdFieldName(), $values)) {
            $this->isLoaded(true);
        }
        $this->values = $values;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getValue($name)
    {
        if (array_key_exists($name, $this->values)) {
            return $this->values[$name];
        } else {
            return null;
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->values;
    }

    /**
     * @return Datasource
     */
    public function getDatasource()
    {
        return $this->dataSource;
    }

    /**
     * @param $query
     * @param $parameters
     * @return array|null
     */
    public function execute($query, $parameters)
    {
        return $this->dataSource->execute($query, $parameters);
    }

    private function generateId() {
        return md5(gethostname()).uniqid('', true);
    }




}