<?php namespace faker;

use app\components\fakers\UserFaker;
use app\models\User;

class UserFakerTest extends \Codeception\Test\Unit
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


    public function testMethodCreateReturnValidUser()
    {
        $userFaker = new UserFaker();
        /** @var User $user */
        $user = $userFaker->create();
        $this->tester->assertEquals($user->validate(), true);
    }

    public function testMethodCreateAsArrayReturnValidDataForUser()
    {
        $userFaker = new UserFaker();
        /** @var User $user */
        $userAsArray = $userFaker->createAsArray();

        $user = new User();
        $user->name = $userAsArray[0];
        $user->surname = $userAsArray[1];
        $user->gender = $userAsArray[2];
        $user->status = $userAsArray[3];
        $user->birthday = $userAsArray[4];

        $this->tester->assertEquals($user->validate(), true);
    }
}