<?php

namespace app\models\t;

class Hunter
{
    public IWeapon $weapon;
    public $strength = 3;
    public function attack()
    {
        $damage = $this->strength + ($this->weapon ? $this->weapon->damage(): 0);   // int
        echo 'The hunter attacks the enemy with ' . $damage . ' damage';
    }
}