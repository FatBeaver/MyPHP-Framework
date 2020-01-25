<?php

namespace app\controllers\admin;

use app\controllers\admin\BaseAdminController;

class UserController extends BaseAdminController
{   
    public function actionIndex()
    {
        $this->render('index', []);
    }
}