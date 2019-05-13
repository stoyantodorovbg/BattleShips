<?php

namespace App\Services\Interfaces;


interface GridServiceInterface
{
    public function createGrid($width, $height): bool;

    public function getGrid(string $gridKey): array;

    public function removeGrid(string $gridKey): bool;
}