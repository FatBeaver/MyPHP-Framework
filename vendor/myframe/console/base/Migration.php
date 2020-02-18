<?php

namespace myframe\console\base;

class Migration
{   
    /**
     * Создание таблицы в БД
     */
    public function createTable(string $tableName, array $columns)
    {
        
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

    }

    /**
     * Удаление выбранной колонки из указанной таблицы 
     * в БД
     */
    public function dropColumn(string $tableName, string $columnName)
    {

    }

    /**
     * Колонка которая будет являться первичным ключом
     */
    public function primaryKey(string $column)
    {

    }
    
    /**
     * Колонка не может иметь значение NULL
     */
    public function notNull()
    {

    }

    /**
     * Автоинкремент значения колонки
     */
    public function autoIncrement()
    {

    }

    /**
     * Значения в данной колонке должны быть 
     * уникальными
     */
    public function unique()
    {

    }


    // ==================== ЧИСЛОВЫЕ ТИПЫ ДАННЫХ ===============

    /**
     * Тип колонки INT
     */
    public function int($count, $unsigned)
    {

    }

    /**
     * Тип колонки TINYINT
     */
    public function tinyInt(int $count, bool $unsigned)
    {

    }

    /**
     * Тип колонки SMALLINT
     */
    public function smallInt(int $count, bool $unsigned)
    {

    }

    /**
     * Тип колонки MEDIUMINT
     */
    public function mediumInt(int $count, bool $unsigned)
    {

    }

    /**
     * Тип колонки BIGINT
     */
    public function bigInt(int $count, bool $unsigned)
    {

    }

    /**
     * Тип колонки BOOL
     */
    public function bool()
    {

    }

    /**
     * Тип колонки FLOAT
     */
    public function float()
    {

    }




    // =================== СИМВОЛЬНЫЕ ТИПЫ ДАННЫХ ================

    /**
     * Тип колонки VARCHAR
     * Представляет строку переменной длинны.
     */
    public function varchar(int $count)
    {

    }

    /**
     * Тип колонки TEXT
     * Представляет текст длинной до 65 КБ.
     */
    public function text()
    {

    }

    /**
     * Тип колонки TINYTEXT
     * Представялет текст длинной до 255 байт.
     */
    public function tinyText()
    {

    }

    /**
     * Тип колонки MEDIUMTEXT
     * Представляет текст длинной до 16 МБ.
     */
    public function mediumText()
    {

    }

    /**
     * Тип колонки LARGETEXT
     * Представляет текст длинной до 4 ГБ.
     */
    public function largeText()
    {

    }
    



    // =================== ДАТА И ВРЕМЯ ====================

    /**
     * Хранит даты с 1 января 1000 года до 31 декабря 9999 года.
     * Формат по умолчанию: "yyyy-mm-dd"
     * Занимает 3 байта
     */
    public function date(string $format)
    {

    }

    /**
     * Хранит время от -838.59.59 до 838.59.59. 
     * Формат по умолчанию: "hh:mm:ss"
     * Занимает 3 байта
     */
    public function time(string $format)
    {

    }

    /**
     * Объеденяет в себе дату и время. 
     * Формат по умолчанию: "yyyy-mm-dd hh:mm:ss"
     * Занимает 8 байт
     */
    public function dateTime(string $format)
    {

    }

    /**
     * Хранит дату и время в диапазоне от "1970-01-01 00:00:01" до "2038-01-19 03:14:07" 
     * Занимает 4 байта.
     */
    public function timestamp()
    {

    }   

    /**
     * Хранит год в виде 4х цифр. 
     * Диапазон допустимых значений от 1901 до 2155
     * Занимает 1 байт.
     */
    public function year()
    {

    }




    // ==================== СОСТАВНЫЕ ТИПЫ ДАННЫХ =============== 

    /**
     * Хранит одно значение из списка допустимых значений 
     * Занимает 1-2 байта
     */
    public function enum()
    {

    }

    /**
     * Может хранить несколько (до 64х) значений из некоторого 
     * списка допустимых значений
     */
    public function set()
    {

    }




    // ==================== БИНАРНЫЕ ТИПЫ ДАННЫХ ================

    /**
     * Тип данных BLOB. 
     * Хранит бинарные файлы в виде строки длинной до
     * 65 КБайт. 
     */
    public function blob()
    {

    }

    /**
     * Тип данных TINYBLOB. 
     * Хранит бинарные файлы в виде строки длинной до
     * 255 байт. 
     */
    public function tinyBlob()
    {

    }

    /**
     * Тип данных TINYBLOB. 
     * Хранит бинарные файлы в виде строки длинной до
     * 16 MБайт. 
     */
    public function mediumBlob()
    {

    }

    /**
     * Тип данных LARGEBLOB. 
     * Хранит бинарные файлы в виде строки длинной до
     * 4 ГБайт. 
     */
    public function largeBlob()
    {

    }
}