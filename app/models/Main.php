<?php

namespace app\models;

use myframe\core\base\Model;

class Main extends Model
{   
    public function save() 
    {
        $book = Main::dispense('posts');
        // Заполняем объект свойствами
        $book->name = 'Призрак победы';
        $book->description = '199';
        Main::store($book);
    }
}