<?php


namespace core;


class Model
{
    public $id;

    public static function tableName()
    {
        return lcfirst(end(explode('\\', get_called_class())));
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array $condition
     * @return bool|static
     */
    public static function findOne($condition = [])
    {
        $conditions = array_map(function ($var) {
            return $var . ' = :' . $var;
        }, array_keys($condition));
        $prepareConditions = implode(' and ', $conditions);

        $whereCondition = $prepareConditions ? 'where ' . $prepareConditions : '';

        try {
            $sql = "select * from " . self::tableName() . " $whereCondition limit 1;";
            $data = FM::$app->getDb()->prepare($sql);

            $executeConditions = [];

            foreach ($condition as $key => $value) {
                $executeConditions[':' . $key] = $value;
            }

            if ($data->execute($executeConditions) &&
                ($result = $data->fetch(\PDO::FETCH_ASSOC)) !== false) {

                $modelName = get_called_class();
                $model = new $modelName;

                foreach ($result as $key => $value) {
                    $model->$key = $value;
                }

                return $model;
            }

        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>';
        }

        return false;
    }

    /**
     * @param array $condition
     * @return static[]|bool
     */
    public static function findAll($condition = [])
    {
        $conditions = array_map(function ($var) {
            return $var . ' = :' . $var;
        }, array_keys($condition));
        $prepareConditions = implode(' and ', $conditions);

        $whereCondition = $prepareConditions ? 'where ' . $prepareConditions : '';

        try {
            $sql = "select * from " . self::tableName() . " $whereCondition;";
            $data = FM::$app->getDb()->prepare($sql);

            $executeConditions = [];

            foreach ($condition as $key => $value) {
                $executeConditions[':' . $key] = $value;
            }

            if ($data->execute($executeConditions) &&
                ($results = $data->fetchAll(\PDO::FETCH_ASSOC)) !== false) {

                $models = [];
                $modelName = get_called_class();

                foreach ($results as $result) {
                    $model = new $modelName;

                    foreach ($result as $key => $value) {
                        $model->$key = $value;
                    }

                    $models[] = $model;
                }

                return $models;
            }

        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>';
        }

        return false;
    }

    public function insert()
    {
        $attributes = array_filter($this->attributes(), function ($var) {
            return !is_null($var);
        });
        $attributeNames = implode(', ', array_keys($attributes));

        $prepareAttributes = array_map(function ($var) {
            return ':' . $var;
        }, array_keys($attributes));
        $prepareAttributeNames = implode(', ', $prepareAttributes);

        try {
            $sql = "insert into " . self::tableName() . " ($attributeNames) values ($prepareAttributeNames);";

            $data = FM::$app->getDb()->prepare($sql);

            $executeAttributes = [];

            foreach ($attributes as $key => $value) {
                $executeAttributes[':' . $key] = $value;
            }

            if ($data->execute($executeAttributes)) {
                $this->id = FM::$app->getDb()->lastInsertId();

                return $this->id;
            }

        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>';
        }

        return false;
    }

    public function update()
    {
        $attributes = array_filter($this->attributes(), function ($val, $key) {
            return !is_null($val) && $key !== 'id';
        }, ARRAY_FILTER_USE_BOTH);

        $prepareAttributes = array_map(function ($var) {
            return $var . ' = :' . $var;
        }, array_keys($attributes));
        $prepareAttributeNames = implode(', ', $prepareAttributes);


        try {
            $sql = "update " . self::tableName() . " set $prepareAttributeNames where id = :id;";
            $data = FM::$app->getDb()->prepare($sql);

            $executeAttributes[':id'] = $this->id;

            foreach ($attributes as $key => $value) {
                $executeAttributes[':' . $key] = $value;
            }

            return $data->execute($executeAttributes);

        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>';
        }


        return true;
    }

    public function delete()
    {
        try {
            $sql = "delete from " . self::tableName() . " where id = :id;";
            $data = FM::$app->getDb()->prepare($sql);

            $executeAttributes[':id'] = $this->id;

            return $data->execute($executeAttributes);

        } catch (\Exception $e) {
            echo $e->getMessage() . '<br>';
        }

        return true;
    }

    public function attributes()
    {
        return get_object_vars($this);
    }
}