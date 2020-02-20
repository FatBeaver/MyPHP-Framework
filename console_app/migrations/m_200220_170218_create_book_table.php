<?php

namespace console\migrations; 

use myframe\console\base\Migration;

class m_200220_170218_create_book_table extends Migration
{
   public function up()
   {
       return $this->createTable('book', [
           'id' => "BIGINT(12) NOT NULL AUTO_INCREMENT",
           //Перечислите имена колонок с их типом данных
           "" => "PRIMARY KEY(id)"
       ]);
   }

   public function down()
   {
       return $this->dropTable('book');
   }
}
