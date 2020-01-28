<?php
declare(strict_types = 1);

namespace app\controllers;

use myframe\core\base\Controller;
use myframe\libs\uploader\FileUploader;
use myframe\libs\debug\Debug;

/**
 * Class for testing upload files
 */
class FileTestController extends Controller
{
    public function actionIndex()
    {
        if (isset($_POST['submit'])) {

            Debug::print(FileUploader::addFile());die;
        }

        $this->render('index', []);
    }
}
