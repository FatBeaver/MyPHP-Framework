<?php
declare(strict_types = 1);

namespace app\controllers;

use myframe\core\base\Controller;
use myframe\libs\uploader\FileUploader;
use myframe\libs\debug\Debug;
use app\models\ImagesUploader;

/**
 * Class for testing upload files
 */
class FileTestController extends Controller
{
    public function actionIndex()
    {
        if (isset($_POST['submit'])) {

            $imgUploader = new ImagesUploader();
            $imgUploader->images = FileUploader::addFiles('user-file-2');

            if ($imgUploader->validate(15)) {
                $imgUploader->upload('/category/');
                return $this->redirect('/file-test/index');
            } else {
                echo 'NO'; die;
            }
        }

        return $this->render('index', []);
    }
}
