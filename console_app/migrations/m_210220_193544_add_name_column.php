<?php

namespace console\migrations; 

use myframe\console\base\Migration;

class m_210220_193544_add_name_column extends Migration
{
   public function up()
   {
       return $this->addColumn('book', 'name', "VARCHAR(255)");
   }

   public function down()
   {
       return $this->dropColumn('book', 'name');
   }
}
