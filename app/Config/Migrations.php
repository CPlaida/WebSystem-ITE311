<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Migrations extends BaseConfig
{
    public $enabled = true;

    // use timestamp format to match migration files
    public $type = 'timestamp';

    public $table = 'migrations';

    public $timestampFormat = 'Y_m_d_His_';

    public $namespace = 'App\Database\Migrations';
}
