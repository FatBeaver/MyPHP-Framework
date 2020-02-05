<?php
declare(strict_types = 1);

namespace myframe\libs\pagination;

/**
 * todo: написать описание для класса Pagination
 */
class Pagination
{
    /**
     * Общее количество записей в БД.
     *
     * @var int
     */
    private int $total;

    /**
     * Лимит записей на одну странницу.
     *
     * @var int
     */
    private int $limit;

    /**
     * Индекс записи с которой необходимо начинать
     * доставать данные из БД.
     *
     * @var int
     */
    private int $offset;

    /**
     * Текущая странница
     *
     * @var int
     */
    private int $currentPage;

    /**
     * Количество страниц
     *
     * @var int
     */
    private int $countPage;

    /**
     * Префиксы строки запроса.
     *
     * @var array
     */
    private array $prefixesOfUrl = [];

    /**
     * Шаблоны панели пагинации.
     *
     * @var array
     */
    private array $layouts = [];

    public function __construct(int $total, int $limit, int $currentPage)
    {
        $this->total = $total;
        $this->limit = $limit;
        $this->currentPage = $currentPage;
        $this->offset = ($currentPage - 1) * $limit;
        $this->countPage = ceil($total / $limit);
    }

    /**
     * Отображает html код шаблона панели пагинации.
     *
     * @param $layout
     */
    public function render($layout): void
    {

    }

    /**
     * Добавляет шаблон панели пагинации.
     *
     * @param string $name
     * @param string $path
     *
     * @return Pagination
     */
    public function addLayout(string $name, string $path): Pagination
    {
        $this->layouts[$name] = $path;
        return $this;
    }

    /**
     * Метод для добавления url префиксов.
     *
     * @param string $key
     * @param string $value
     *
     * @return Pagination
     */
    public function addPrefix(string $key, string $value): Pagination
    {
        $this->prefixesOfUrl[$key] = $value;
        return $this;
    }
}
