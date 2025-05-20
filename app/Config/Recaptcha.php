<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Recaptcha extends BaseConfig
{
    public bool $enabled = false;
    public string $siteKey = '';
    public string $secretKey = '';
}
