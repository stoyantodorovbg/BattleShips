<?php

namespace App\Services\Interfaces;

interface ShipServiceInterface
{
    public function addShips(array $grid, array $shipData, string $gameName): void;

    public function checkForSailingShips(array $grid): bool;

    public function addShip(array $grid, int $shipLength): array;
}
