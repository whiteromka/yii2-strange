<?php

namespace app\components\fakers;

use app\models\City;
use app\models\Passport;
use Faker\Factory;

class PassportFaker extends AFaker
{
    /** @var int */
    private $userId;

    const NUMBER_MIN = 1000;
    const NUMBER_MAX = 9999;

    public function __construct()
    {
        parent::__construct();
        $this->faker = Factory::create();
    }

    /**
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * Create and return passport
     *
     * @return Passport
     */
    public function create() : Passport
    {
        $f = $this->faker;
        $passport = new Passport();
        $passport->user_id = $this->userId;
        $passport->number = $f->numberBetween(self::NUMBER_MIN, self::NUMBER_MAX);
        $passport->code = $f->numberBetween(self::NUMBER_MIN, self::NUMBER_MAX);
        $passport->country = $f->country();
        $passport->city = $f->city();
        $passport->address = $f->address();

        return $passport;
    }

    /**
     * Create and return passport as array
     *
     * @return array
     */
    public function createAsArray() : array
    {
        $f = $this->faker;
        $passport = [];
        $passport[] = $this->userId;
        $passport[] = $f->numberBetween(self::NUMBER_MIN, self::NUMBER_MAX);
        $passport[] = $f->numberBetween(self::NUMBER_MIN, self::NUMBER_MAX);
        $passport[] = $f->country();
        $passport[] = City::getRandomCity();
        $passport[] = $f->address();

        return $passport;
    }
}