<?php

namespace console\controllers;

use myframe\console\base\Migration;

class MigrationController extends Migration
{
    public function actionCreate($tableName)
    {
        echo "$tableName" . PHP_EOL;
        return 0;
    }
}