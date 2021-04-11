<?php

namespace App\Models;

class User extends Base
{
    protected $tableName = APP_TABLE_PREFIX . 'user';

    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
