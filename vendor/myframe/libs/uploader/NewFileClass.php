<?php
declare(strict_types = 1);

namespace myframe\libs\uploader;

/**
 * Класс экземпляры которого будут содержать данные
 * о загружаемых файлах.
 */
class NewFileClass
{
    /**
     * Расширение файла
     *
     * @var string
     */
    public string $extension;

    /**
     * Имя файла без расширения
     *
     * @var string
     */
    public string $baseName;

    /**
     * Тип файла
     *
     * @var string
     */
    public string $type;

    /**
     * Ошибки возникшие при загрузке файла
     *
     * @var string
     */
    public int $error;

    /**
     * Размер файла в байтах
     *
     * @var string
     */
    public int $size;

    /**
     * Путь временного хранения файла
     *
     * @var string
     */
    public string $tmpName;

    /**
     * Конструктор.
     */
    public function __construct(string $fileName, string $fileType,
        string $fileTmpName, int $fileError, int $fileSize)
    {
        $this->spliceFileName($fileName);
        $this->type = $fileType;
        $this->error = $fileError;
        $this->tmpName = $fileTmpName;
        $this->size = $fileSize;
    }

    /**
     * Разбивает имя файла на базовую часть и
     * расширение.
     *
     * @param $fileName
     */
    private function spliceFileName($fileName): void
    {
        $pattern = '(?P<baseName>.+)(?P<extension>\.[a-z_0-9]{1,6})';
        if (preg_match("#$pattern#i", $fileName, $matches)) {
            $this->extension = $matches['extension'];
            $this->baseName = $matches['baseName'];
        } else {
            throw new \Exception('Нельзя обработать данный файл.');
        }
    }

    /**
     * Метод сохраняющий файл в указанную
     * дирректорию
     *
     * @return bool
     */
    public function saveIn(string $pathToFile): bool
    {
        if (move_uploaded_file($this->tmpName, $pathToFile)) {
            return true;
        } else {
            return false;
        }
    }
}
