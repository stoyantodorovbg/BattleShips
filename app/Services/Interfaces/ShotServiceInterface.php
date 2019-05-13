<?php

namespace App\Services\Interfaces;


interface ShotServiceInterface
{
    public function updateGrid($row, $col): bool;
}