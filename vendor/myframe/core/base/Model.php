<?php

namespace myframe\core\base;

use myframe\core\Db;
use Valitron\Validator;

class Model extends Db
{
    /**
     * @var array
     *
     * Массив с ошибками валидации.
     */
    protected array $errors = [];

    /**
     * Свойства подлежащие валидации.
     *
     * @var array
     */
    protected array $valuesForValidate = [];


    /**
     * Конструктор создающий экземпляр класса Db.
     */
    public function __construct()
    {
        Db::connect();
    }

    /**
     * Создает html код ошибок валидации для
     * флэш сообщения.
     *
     * @return string
     */
    protected function htmlBuildErrors()
    {
        $htmlErrors = '<ul class="validate-errors">';
        foreach ($this->errors as $type => $errors) {
            foreach ($errors as $error) {
                $htmlErrors .= "<li>$error</li>";
            }
        }
        $htmlErrors .= "</ul>";
        return $htmlErrors;
    }

    /**
     * Загружает данные в св-ва объекта и
     * в массив $valuesForValidate для их
     * последующей валидации.
     *
     * @param array $data
     */
    public function uploadData(array $data): bool
    {
        if (!isset($this->attributes)) {
            throw new \Exception('Определите свойство attributes в модели с которой работаете.');
        }
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$value])) {
                $this->valuesForValidate[$value] = $data[$value];
                $this->$value = $data[$value];
            }
        }
        return true;
    }

    /**
     * Валилирует загруженные данные согласно правилам определенным в
     * дочернем классе.
     *
     * @return bool
     */
    public function validate(array $userRules): bool
    {
        Validator::lang('ru');
        $validator = new Validator($this->valuesForValidate);
        $validator->rules($userRules);
        if ($validator->validate()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            $_SESSION['errors'] = $this->htmlBuildErrors();
            return false;
        }
    }

    /**
     * Метод для загрузки свойств модели из БД в
     * нужную модель.
     */
    public static function loadAttrInNewModel(
        array $attributes, 
        object $dataObj, 
        object $newObject
    ): object
    {
        foreach($attributes as $attr) {
            if (isset($dataObj->$attr)) {
                $newObject->$attr = $dataObj->$attr;
            }
        }
        return $newObject;
    }
}
