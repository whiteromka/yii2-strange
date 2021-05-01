<?php
namespace components;

use app\components\CryptoWatcher;
use app\models\Altcoin;
use app\models\AltcoinWatcher;

class CryptoWatcherTest extends \Codeception\Test\Unit
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

    public function test_prepare_watchers_will_fill_valid_array()
    {
        $cw = new CryptoWatcher();
        $cw->prepareWatchers();

        $count = AltcoinWatcher::find()->count();
        if ($count) {
            $this->assertEquals($count, count($cw->getWatchers()));
            $firstCryptoWatcher = $cw->getWatchers()[0];
            $this->assertArrayHasKey('wish_price', $firstCryptoWatcher);
            $this->assertArrayHasKey('expectation', $firstCryptoWatcher);
        }
    }

    public function test_prepare_notification_data_will_fill_valid_data() {
        $cw = new CryptoWatcher();
        $cw->prepareWatchers();
        $cw->prepareNotificationData();
        $notificationData = $cw->getNotificationData();
        if ($notificationData) {
            $this->assertIsArray($notificationData);
            $altcoins = Altcoin::getAltcoinList(true);
            foreach ($notificationData as $altcoin => $price) {
                $this->assertEquals(true, in_array($altcoin, $altcoins),
                    'Altcoin '.$altcoin.' not founds in altcoins'
                );
                $this->assertIsNumeric($price);
            }
        } else {
            $this->assertEmpty($notificationData);
        }
    }
}