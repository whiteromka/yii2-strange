<?php

namespace app\components\fakers;

use app\models\Estate;
use Faker\Factory;

class EstateFaker extends AFaker
{
    /** @var int */
    private $userId;

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
     * Create and return estate
     *
     * @return Estate
     */
    public function create() : Estate
    {
        $estateAsArray = $this->createRandomEstateAsArray();
        $estate = new Estate();
        $estate->user_id = $this->userId;
        $estate->type = $estateAsArray['type'];
        $estate->name = $estateAsArray['name'];
        $estate->cost = $estateAsArray['cost'];
        return $estate;
    }

    /**
     * Create and return estate as array
     *
     * @return array
     */
    public function createAsArray() : array
    {
        $estateAsArray = $this->createRandomEstateAsArray();
        $estate = [];
        $estate[] = $this->userId;
        $estate[] = $estateAsArray['type'];
        $estate[] = $estateAsArray['name'];
        $estate[] = $estateAsArray['cost'];
        return $estate;
    }

    /**
     * @return array
     */
    public function createRandomEstateAsArray() : array
    {
        $estateType = $this->faker->numberBetween(Estate::TYPE_THING, Estate::TYPE_REAL_ESTATE);
        $estates = Estate::getAll();
        $randKey = array_rand($estates[$estateType]);
        $estateName = $estates[$estateType][$randKey];
        $estateCost = $this->calculateCost($estateType, $randKey);

        return [
            'name' => $estateName,
            'type' => $estateType,
            'cost' => $estateCost
        ];
    }

    /**
     * Calculate RANDOM cost for estate
     *
     * @param int $estateType
     * @param int $rating
     * @return int
     */
    protected function calculateCost(int $estateType, int $rating) : int
    {
        $typeRate = 1 + ($estateType * $estateType) * ($estateType === Estate::TYPE_REAL_ESTATE) ? 2 : 1;
        $costRate = 1 + ($typeRate * ((int)$rating / 10)) * Estate::getTypeCostRate()[$estateType];
        $cost = $this->faker->numberBetween(1, 11);
        if ($estateType === 1) {
            $cost = $this->faker->numberBetween(21, 69);
        }  if ($estateType === 2) {
            $cost = $this->faker->numberBetween(323, 753);
        }
        $estateCost = $cost * $costRate;
        return (int)$estateCost;
    }
}