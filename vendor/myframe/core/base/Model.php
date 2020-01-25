<?php

namespace myframe\core\base;

use myframe\core\Db;
use Valitron\Validator;
use myframe\libs\Debug;

class Model extends Db
{
    /**
     * True если пользователь НЕ авторизован.
     * Если пользователь авторизован то False.
     *
     * @var bool
     */
    protected bool $isGuest = True;

    /**
     * Флаг для создания auth_key
     *
     * @var bool
     */
    public bool $rememberMe = false;

    /**
     * @var array
     *
     * Массив с ошибками валидации.
     */
    protected array $errors = [];

    /**
     * Конструктор создающий экземпляр класса Db.
     */
    public function __construct()
    {
        Db::connect();
    }

    /**
     * Загружает данные в св-ва объекта.
     *
     * @param array $data
     */
    public function uploadData(array $data): void
    {
        if (!isset($this->attributes)) {
            throw new \Exception('Определите свойство attributes в модели с которой работаете.');
        }
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$value])) {
                $this->$value = $data[$value];
            }
        }
    }

    public function validate()
    {

    }
}
