<?php

namespace App\Yeelight\YeeCli;

use App\Entity\BulbStatus;

class CliParser
{
    public function parseStatus($status)
    {
        $result = new BulbStatus();

        $lines = explode(PHP_EOL, $status);
        $result->ct = (int) substr($lines[11],5);
        $result->bright =  (int) substr($lines[9],9);

        return $result;
    }
}