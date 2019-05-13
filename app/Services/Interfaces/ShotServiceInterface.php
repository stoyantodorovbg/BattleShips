<?php

namespace App\Services\Interfaces;

interface ShotServiceInterface
{
    public function shootCell($row, $col, string $gridKey): bool;
}
