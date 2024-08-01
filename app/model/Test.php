<?php

namespace app\model;

use Triangle\Database\Model;

class Test extends Model
{
    /**
     * Таблица, связанная с моделью.
     *
     * @var string
     */
    protected $table = 'test';

    /**
     * Первичный ключ, связанный с таблицей.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Указывает, должна ли модель иметь метку времени.
     *
     * @var bool
     */
    public $timestamps = false;
}
