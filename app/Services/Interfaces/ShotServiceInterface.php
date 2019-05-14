<?php

namespace App\Services\Interfaces;

interface ShotServiceInterface
{
    public function shootCell($row, $col, string $gameName): bool;

    public function countShots(string $gameName): int;

    public function getShotsCount(string $gameName): int;

    public function getShotsKey(string $gameName): string;
}
