<?php

namespace App\Services\Interfaces;

interface GridServiceInterface
{
    public function createGrid(array $shipData, int $rows, int $cols, string $gameName): array;

    public function getGrid(string $gameName): array;

    public function updateGrid(array $grid, string $gameName): bool;

    public function removeGrid(string $gameName): bool;

    public function getGridKey(string $gameName): string;
}
