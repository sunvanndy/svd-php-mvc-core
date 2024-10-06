<?php


namespace app\core\db;


use app\core\Application;
use app\core\Model;
use app\models\User;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
                    VALUES(".implode(',', $params).")");
        
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function findOne($where)
    {
        // static to actual class on which FindOne will be call, eg: User will be used UserTable
        $tableName = static::tableName();
        $attributes = array_keys($where);

        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes)); // IMPLODE -> combine them with 'AND '
        // SQL = SELECT * FROM $tableName WHERE email = :email AND firstname = :firstname
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();

        return $statement->fetchObject(static::class); // Fetch Object return object by default, but we set static::class => meaning User Class
    }

    public function prepare($sql)
    {
        // insert should happen with PDO Prepare
        return Application::$app->db->pdo->prepare($sql);
    }
}