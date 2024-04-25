<?php

namespace App\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('Test')]
class Test
{
    use DefaultActionTrait;

    private int $randomNumber;

    #[LiveProp()]
    public int $max = 1000;

    public function __construct()
    {
        $this->randomNumber = rand(0, $this->max);
    }

    public function getRandomNumber(): int
    {
        return $this->randomNumber;
    }
}
