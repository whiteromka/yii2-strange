<?php namespace faker;

use app\components\fakers\PassportFaker;
use app\models\Passport;

class PassportFakerTest extends \Codeception\Test\Unit
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

    public function test_method_create_return_valid_passport()
    {
        $passportFaker = new PassportFaker();
        /** @var Passport $passport */
        $passport = $passportFaker->setUserId(1)->create();
        $this->tester->assertEquals(true, $passport->validate());
    }

    public function test_method_create_as_array_return_valid_data_for_passport()
    {
        $passportFaker = new PassportFaker();
        /** @var Passport $passport */
        $passportAsArray = $passportFaker->setUserId(1)->createAsArray();
        $passport = new Passport();
        $passport->user_id = $passportAsArray[0];
        $passport->number = $passportAsArray[1];
        $passport->code =  $passportAsArray[2];
        $passport->country = $passportAsArray[3];
        $passport->city = $passportAsArray[4];
        $passport->address = $passportAsArray[5];
        $this->tester->assertEquals(true, $passport->validate());
    }
}