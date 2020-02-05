<?php
declare(strict_types = 1);

namespace app\models;

/**
 * Файл загружающий ОДИН файл из формы в
 * выбранную дирректорию
 */
class ImageUploader
{
    /**
     * Экземпляр загруженного изображения
     *
     * @var object
     */
    public object $image;

    /**
     * Недопустимые расширения загружаемых файлов
     *
     * @var array
     */
    public array $badExtension = ['.html', '.php', '.php3', '.php4',
                            '.php5', '.php6', '.php7', '.php8',
                            '.phtml', '.htm'];


    /**
     * Валидирует загружаемое изображение на расширение,
     * размер и ошибки при загрузке.
     *
     * @param $imageSize
     *
     * @throws \Exception
     * @return boolean
     */
    public function validate($imageSize)
    {
        foreach ($this->badExtension as $extension) {
            if ($extension == $this->image->extension) {
                throw new \Exception('Ошибка. Не удалось загрузить файл. 
                Не корректное расширение файла.');
            } elseif ($this->image->size > (1024 * 1024 * 1024 * $imageSize)) {
                throw new \Exception("Размер файла {$this->image->name} слишком велик.");
            } elseif ($this->image->error != 0) {
                throw new \Exception('Ошибка при загрузке файла.');
            } else {
                return true;
            }
        }
    }

    /**
     * Загружает файл в файловую систему.
     *
     * @param $segmentPath
     *
     * @return string
     *
     * @throws \Exception
     */
    public function upload($segmentPath = '')
    {
        $fileName = $this->image->baseName . pow(rand(1, 100),rand(1,10))
            . $this->image->extension;

        $pathToFile = WEB . '/uploads/images' . $segmentPath . $fileName;

        if ($this->image->saveIn($pathToFile)) {
            return $fileName;
        } else {
            throw new \Exception('Не удалось переместить файл из временной дирректории в 
             ' . $pathToFile);
        }

    }
}
