<?php

namespace App\Services\Interfaces;

interface GameServiceInterface
{
    public function finishGame(string $gameName): int;
}
