<?php

namespace App\Services\Interfaces;

interface GridServiceInterface
{
    public function createGrid(int $rows, int $cols): array;

    public function getGrid(string $gridKey): array;

    public function updateGrid(array $grid, string $gridKey): bool;

    public function removeGrid(string $gridKey): bool;
}
