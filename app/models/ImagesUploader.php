<?php
declare(strict_types = 1);

namespace app\models;

/**
 * Файл загружающий ОДИН файл из формы в
 * выбранную дирректорию
 */
class ImagesUploader
{
    /**
     * Экземпляры загруженных изображений
     *
     * @var array
     */
    public array $images = [];

    /**
     * Недопустимые расширения загружаемых файлов
     *
     * @var array
     */
    public array $badExtension = ['.html', '.php', '.php3', '.php4',
                                  '.php5', '.php6', '.php7', '.php8',
                                  '.phtml', '.htm'];


    /**
     * Валидирует загружаемый файл на расширение,
     * размер и ошибки при загрузке.
     *
     * @param $imageSize
     *
     * @throws \Exception
     * @return boolean
     */
    public function validate($imageSize)
    {
        foreach ($this->images as $image) {
            foreach ($this->badExtension as $extension) {
                if ($extension == $image->extension) {
                    throw new \Exception('Ошибка. Не удалось загрузить файл. 
                        Не корректное расширение файла.');
                } elseif ($image->size > (1024 * 1024 * 1024 * $imageSize)) {
                    throw new \Exception("Размер файла {$image->name} слишком велик.");
                } elseif ($image->error != 0) {
                    throw new \Exception('Ошибка при загрузке файла.');
                } else {
                    return true;
                }
            }
        }
    }

    /**
     * Загружает файл в файловую систему.
     *
     * @param $segmentPath
     *
     * @return array
     *
     * @throws \Exception
     */
    public function upload($segmentPath = '')
    {
        $fileNames = [];
        foreach ($this->images as $image) {
            $fileName = $image->baseName . pow(rand(1, 100),rand(1,10))
                . $image->extension;

            $pathToFile = WEB . '/uploads/images' . $segmentPath . $fileName;

            if ($image->saveIn($pathToFile)) {
                $fileNames[] = $fileName;
            } else {
                throw new \Exception('Не удалось переместить файл из временной дирректории в 
             ' . $pathToFile);
            }
        }
        return $fileNames;
    }
}

