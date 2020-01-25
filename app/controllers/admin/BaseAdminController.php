<?php

namespace app\controllers\admin;

use myframe\core\base\Controller;

class BaseAdminController extends Controller
{
    public $layout = 'admin';

    public function __construct($route)
    {
        parent::__construct($route);
    }
}