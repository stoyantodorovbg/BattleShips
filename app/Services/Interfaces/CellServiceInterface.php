<?php

namespace App\Services\Interfaces;

interface CellServiceInterface
{
    public function isCellEmpty(array $cellCoords, array $grid, string $gameName): bool;

    public function hasCellHit(array $cellCoords, string $gameName): bool;
}