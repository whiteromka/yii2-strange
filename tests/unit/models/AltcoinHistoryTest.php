<?php

namespace models;

use app\models\Altcoin;
use app\models\AltcoinHistory;
use Codeception\Test\Unit;
use yii\base\Exception;

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

    public function test_function_get_data_charts_return_valid_array()
    {
        $ah = new AltcoinHistory();
        $result = $ah->getDataCharts('btc');

        foreach ($result as $altcoin => $altcoinData) {
            $this->assertEquals(true, (in_array($altcoin, Altcoin::getAltcoinList())));
            $this->assertNotEmpty($altcoinData);

            $firstItem = $altcoinData[0];

            $this->assertArrayHasKey('value', $firstItem);
            $this->assertIsNumeric($firstItem['value']);

            $this->assertArrayHasKey('date', $firstItem);
            $this->assertNotEmpty($firstItem['date']);
        }
    }

    public function test_function_get_data_charts_throw_exception()
    {
        $this->tester->expectThrowable(Exception::class, function() {
            (new AltcoinHistory())->getDataCharts('btc; sql injection ... ;');
        });
    }
}