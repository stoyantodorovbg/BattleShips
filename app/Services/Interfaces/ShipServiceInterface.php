<?php

namespace App\Services\Interfaces;


interface ShipServiceInterface
{
    public function addRandomShips(): array;

    public function checkForSailingShips(): bool;
}