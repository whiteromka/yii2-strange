<?php

namespace app\components;

use app\models\User;
use Faker\Generator;
use Faker\Factory;

class UserFaker
{
    /** @var Generator */
    private $faker;

    private $unixTimeFrom = 315532800;
    private $unixTimeTo = 1605899933;

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
            $user->gender = User::GENDER_MALE;
        } else {
            $user->name = $f->firstNameFemale;
            $user->gender = User::GENDER_FEMALE;
        }
        $user->status = ($f->randomDigit >= 5) ? User::STATUS_ACTIVE: User::STATUS_NOT_ACTIVE;
        $user->surname = $f->lastName;
        $unixTime = $f->numberBetween($this->unixTimeFrom, $this->unixTimeTo);
        $date = date("Y-m-d", $unixTime);
        $user->birthday = $date;

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
        $user[] = $isMale ? User::GENDER_MALE : User::GENDER_FEMALE;
        $user[] = ($f->randomDigit >= 5) ? User::STATUS_ACTIVE: User::STATUS_NOT_ACTIVE;
        $unixTime = $f->numberBetween($this->unixTimeFrom, $this->unixTimeTo);
        $date = date("Y-m-d", $unixTime);
        $user[] = $date;

        return $user;
    }
}