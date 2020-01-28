<?php
declare(strict_types = 1);

namespace myframe\libs\uploader;

use myframe\libs\uploader\NewFileClass;

/**
 * Класс работающий с загрузкой файлов.
 */
class FileUploader
{
    /**
     * Массив $_FILES
     *
     * @var array
     */
    public static array $files;


    public static function addFile($inputName)
    {
        $file = new NewFileClass($_FILES[$inputName]['name'],
            $_FILES[$inputName]['type'], $_FILES[$inputName]['tmp_name'],
            $_FILES[$inputName]['error'], $_FILES[$inputName]['size']
        );

        return $file;
    }

    public static function addFiles($pathToDir)
    {

    }

    /**
     * Реструктурирует массив $_FILES в следующий вид:
     *
     * $_FILES = [
     *
     *      'input-name-1' => [
     *          '0' => [
     *              'name' => 'NameOfFile_0',
     *              'type' => 'TypeOfFile_0',
     *              'tmp_name' => 'TmpNameOfFile_0',
     *              'error' => 'CountErrorOfFile_0',
     *              'size' => 'SizeOfFile_0',
     *          ],
     *          // ............................
     *      ],
     *
     *      'input-name-2' => [
     *          '0' => [
     *              'name' => 'NameOfFile_0',
     *              'type' => 'TypeOfFile_0',
     *              'tmp_name' => 'TmpNameOfFile_0',
     *              'error' => 'CountErrorOfFile_0',
     *              'size' => 'SizeOfFile_0',
     *          ],
     *          // ............................
     *      ],
     * ];
     *
     * @return array
     */
    private static function modifyFilesArray()
    {
        $newFilesArr = [];
        foreach ($_FILES as $inputName => $arraysOfType) {
            $countFiles = count($arraysOfType['name']) - 1;
            for ($i = 0; $i <= $countFiles; $i++) {
                foreach ($arraysOfType as $type => &$values) {
                    $newFilesArr[$inputName][$i][$type] = array_shift($values);
                }
            }
        }
        self::$files = $newFilesArr;
    }
}
