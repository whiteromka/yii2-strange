<?php

namespace app\components;

use app\models\User;
use Faker\Generator;
use Faker\Factory;

class UserFaker
{
    /** @var Generator */
    private $faker;

    private $unixTimeBirthdayFrom = 315532800;
    private $unixTimeBirthdayTo = 1605899933;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Create and return user
     *
     * @return User
     */
    public function create() : User
    {
        $f = $this->faker;
        $user = new User();
        $isMale = $f->randomDigit > 5;
        if ($isMale) {
            $user->name = $f->firstNameMale;
            $user->gender = 1;
        } else {
            $user->name = $f->firstNameFemale;
            $user->gender = 0;
        }
        $user->surname = $f->lastName;
        $unixTime = $f->numberBetween($this->unixTimeBirthdayFrom, $this->unixTimeBirthdayTo);
        $date = gmdate("Y-m-d H:i:s", $unixTime);
        $user->birthday = $date;
        $user->birthday_date_time = $date;
        $user->unix_birthday = $unixTime;

        return $user;
    }

    /**
     * Create and return user as array
     *
     * @return array
     */
    public function createAsArray() : array
    {
        $f = $this->faker;
        $user = [];
        $isMale = $f->randomDigit > 5;
        $user[] = $isMale ? $f->firstNameMale : $f->firstNameFemale;
        $user[] = $f->lastName;
        $user[] = $isMale ? 1 : 0;
        $unixTime = $f->numberBetween($this->unixTimeFrom, $this->unixTimeTo);
        $date = gmdate("Y-m-d H:i:s", $unixTime);
        $user[] = $date;
        $user[] = $date;
        $user[] = $unixTime;
    }
}