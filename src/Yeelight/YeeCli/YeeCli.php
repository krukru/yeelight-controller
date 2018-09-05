<?php

namespace App\Yeelight\YeeCli;

use App\Entity\BulbStatus;
use App\Yeelight\YeelightClientInterface;
use Symfony\Component\Process\Process;

class YeeCli implements YeelightClientInterface
{
    /**
     * @var CliParser
     */
    private $parser;

    public function __construct() {
        $this->parser = new CliParser();
    }

    public function getStatus($bulb): BulbStatus
    {
        $process = new Process(sprintf('yeecli --bulb %s status', $bulb));
        $process->run();
        $status = $process->getOutput();

        return $this->parser->parseStatus($status);
    }
}
