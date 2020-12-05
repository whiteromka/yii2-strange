<?php

namespace app\components\fakers;

use app\models\Passport;
use Faker\Factory;

class PassportFaker extends AFaker
{
    /** @var int */
    private $userId;

    public function __construct()
    {
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
        $passport->number = $f->numberBetween(1000, 9999);
        $passport->code = $f->numberBetween(1000, 9999);
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
        $passport[] = $f->numberBetween(1000, 9999);
        $passport[] = $f->numberBetween(1000, 9999);
        $passport[] = $f->country();
        $passport[] = $f->city();
        $passport[] = $f->address();

        return $passport;
    }
}