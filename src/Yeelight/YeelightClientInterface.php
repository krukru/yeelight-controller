<?php

namespace App\Yeelight;

use App\Entity\BulbStatus;

interface YeelightClientInterface
{
    public function getStatus($bulb): BulbStatus;
}