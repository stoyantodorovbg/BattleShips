<?php

namespace App\Services\Interfaces;

interface ShipServiceInterface
{
    public function addShips(array $grid, array $shipData, string $gridKey): void;

    public function checkForSailingShips(array $grid): bool;
}
