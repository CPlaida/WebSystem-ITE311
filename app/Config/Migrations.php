<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Migrations extends BaseConfig
{
    public $enabled = true;

    public $type = 'timestamp';

    public $table = 'migrations';

    public $timestampFormat = 'YmdHis';

    public $namespace = 'App\Database\Migrations';
}
