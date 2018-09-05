<?php
namespace App\Tests\Yeelight;

use App\Yeelight\YeeCli\YeeCli;

class YeeCliTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\FunctionalTester
     */
    protected $tester;

    /**
     * @var YeeCli
     */
    private $client;
    
    protected function _before()
    {
        $this->client = new YeeCli();
    }

    protected function _after()
    {
    }

    public function testSomeFeature()
    {
        $result = $this->client->getStatus('led1');
        var_dump($result);die;
    }
}