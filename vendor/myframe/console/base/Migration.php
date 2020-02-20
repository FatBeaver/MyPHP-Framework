<?php

namespace myframe\console\base;

class Migration
{   
    /**
     * Создание таблицы в БД
     */
    public function createTable(string $tableName, array $columns)
    {   
        $sql = "CREATE TABLE $tableName (";
        foreach($columns as $column => $parametrs) {
            $sql .= " $column $parametrs, "; 
        }
        $sql = trim($sql, ', ');
        $sql .= ")";
        return $sql;
    }

    /**
     * Добавление колонки в конец указанной
     * таблицы
     */
    public function addColumn(string $tableName, string $columnName, callable $dataType)
    {

    }

    /**
     * Удаление таблицы из БД
     */
    public function dropTable(string $tableName)
    {
        return "DROP TABLE $tableName";   
    }

    /**
     * Удаление выбранной колонки из указанной таблицы 
     * в БД
     */
    public function dropColumn(string $tableName, string $columnName)
    {

    }
}