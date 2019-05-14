<?php

namespace App\Services;

use App\Services\Interfaces\GridServiceInterface;
use App\Services\Interfaces\ShipServiceInterface;

class ShipService implements ShipServiceInterface
{
    /**
     * Add ships to the grid
     *
     * @param array $grid
     * @param array $shipData
     * @param string $gameName
     */
    public function addShips(array $grid, array $shipData, string $gameName = 'battle_ships'): void
    {
        foreach($shipData as $ship) {
            $grid = $this->addShip($grid, $ship);
        }

        $gridService = resolve(GridServiceInterface::class);

        $gridService->updateGrid($grid, $gameName);
    }

    /**
     * Check if there is at least one part of a ship that is not hit
     *
     * @param array $grid
     * @return bool
     */
    public function checkForSailingShips(array $grid): bool
    {
        foreach ($grid as $row) {
            foreach ($row as $col) {
                if(! $col['is_empty'] && ! $col['is_hit']) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Add a ship to the grid
     *
     * @param array $grid
     * @param int $shipLength
     * @return array
     */
    public function addShip(array $grid, int $shipLength): array
    {
        $horizontalAlignment = rand(0, 1);

        $randomCoords = $this->getRandomCoords($grid, $horizontalAlignment, $shipLength);

        while (! $this->checkForEmptyCells($grid, $randomCoords, $horizontalAlignment, $shipLength)) {
            $horizontalAlignment = rand(0, 1);

            $randomCoords = $this->getRandomCoords($grid, $horizontalAlignment, $shipLength);
        }

        return $this->fillShipCells($grid, $shipLength, $horizontalAlignment, $randomCoords);
    }

    /**
     * Get the a random start position for the ship
     *
     * @param array $grid
     * @param int $horizontalAlignment
     * @param $shipLength
     * @return array
     */
    protected function getRandomCoords(array $grid, int $horizontalAlignment, int $shipLength): array
    {
        if($horizontalAlignment) {
            $rowPosition = count($grid) - $shipLength;
            $colPosition = count($grid[1]);
        } else {
            $rowPosition = count($grid[1]);
            $colPosition = count($grid) - $shipLength;
        }

        $rowCoord = rand(1, $rowPosition);
        $colCoord = rand(1, $colPosition);


        return [$rowCoord, $colCoord];
    }

    /**
     * Check if all cells for the ship are empty
     *
     * @param array $grid
     * @param array $coords
     * @param int $horizontalAlignment
     * @param int $shipLength
     * @return bool
     */
    protected function checkForEmptyCells(array $grid, array $coords, int $horizontalAlignment, int $shipLength): bool
    {
        if($horizontalAlignment) {
            $shipEnd = $coords[0] + $shipLength;

            for($cell = $coords[0]; $cell < $shipEnd; $cell++) {
                if(! $grid[$cell][$coords[1]]['is_empty']) {
                    return false;
                }
            }
        } else {
            $shipEnd = $coords[1] + $shipLength;

            for($cell = $coords[1]; $cell < $shipEnd; $cell++) {
                if(! $grid[$coords[1]][$cell]['is_empty']) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Fill the cells of the ship
     *
     * @param array $grid
     * @param int $shipLength
     * @param int $horizontalAlignment
     * @param array $randomCoords
     * @return array
     */
    protected function fillShipCells(array $grid, int $shipLength, int $horizontalAlignment, array $randomCoords): array
    {
        if ($horizontalAlignment) {
            $shipEnd = $randomCoords[0] + $shipLength;

            for ($cell = $randomCoords[0]; $cell < $shipEnd; $cell++) {
                $grid = $this->fillCell($grid, $randomCoords[0], $cell);
            }

        } else {
            $shipEnd = $randomCoords[1] + $shipLength;

            for ($cell = $randomCoords[1]; $cell < $shipEnd; $cell++) {
                $grid = $this->fillCell($grid, $cell, $randomCoords[1]);
            }
        }

        return $grid;
    }

    /**
     * Mark a cell as filled
     *
     * @param array $grid
     * @param int $rowCoord
     * @param int $colCoord
     * @return array
     */
    protected function fillCell(array $grid, int $rowCoord, int $colCoord): array
    {
        $grid[$rowCoord][$colCoord]['is_empty'] = false;

        return $grid;
    }
}
