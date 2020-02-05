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
     * Создает экземпляр класса NewFileClass
     * св-ва которого являются ключами массива $_FILES
     *
     * @param string $inputName
     *
     * @return \myframe\libs\uploader\NewFileClass
     */
    public static function addFile(string $inputName)
    {
        $file = new NewFileClass($_FILES[$inputName]['name'],
            $_FILES[$inputName]['type'], $_FILES[$inputName]['tmp_name'],
            $_FILES[$inputName]['error'], $_FILES[$inputName]['size']
        );

        return $file;
    }

    /**
     * Создает экземпляры класса NewFileClass
     * св-ва которых являются ключами массива $_FILES
     *
     * @param string $inputName
     *
     * @return array
     */
    public static function addFiles(string $inputName)
    {
        $newFilesArray = self::modifyFilesArray($inputName);

        $files = [];
        foreach ($newFilesArray as $file) {
            $files[] = new NewFileClass($file['name'], $file['type'], $file['tmp_name'],
                $file['error'], $file['size']);
        }
        return $files;
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
    private static function modifyFilesArray(string $inputName)
    {
        $newFilesArr = [];

        $countFiles = count($_FILES[$inputName]['name']) - 1;
        for ($i = 0; $i <= $countFiles; $i++) {
            foreach ($_FILES[$inputName] as $type => &$values) {
                $newFilesArr[$inputName][$i][$type] = array_shift($values);
            }
        }

        return $newFilesArr[$inputName];
    }
}
