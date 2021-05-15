<?php

namespace models;

use app\models\AltcoinHistory;
use app\models\AltcoinHistoryData;
use Codeception\Test\Unit;

class AltcoinHistoryTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function test_get_data_charts_return_valid_array()
    {
        $history = new AltcoinHistoryData();
        $coin = 'BTC';
        $data = $history->getDataCharts('BTC');

        $this->assertArrayHasKey($coin, $data);
        $this->assertArrayHasKey(0, $data[$coin]);
        $this->assertArrayHasKey('date', $data[$coin][0]);
        $this->assertArrayHasKey('value', $data[$coin][0]);
    }

    public function test_get_last_prices_will_return_array()
    {
        $history = new AltcoinHistoryData();
        $data = $history->getLastPrices();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('btc', $data);
    }

}