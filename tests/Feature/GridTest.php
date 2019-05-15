<?php

namespace Tests\Feature;

use App\Services\Interfaces\ShipServiceInterface;
use Tests\TestCase;
use App\Services\Interfaces\GridServiceInterface;

class GridTest extends TestCase
{
    /** @test */
    public function the_default_grid_has_10_rows_and_10_cols()
    {
        $gridService = resolve(GridServiceInterface::class);

        $grid = $gridService->createGrid([4, 4, 5]);

        $this->assertCount(10, $grid['battle_ships_grid']);
        $this->assertCount(10, $grid['battle_ships_grid'][1]);
    }

    /** @test */
    public function the_grid_has_sailings_ships()
    {
        $gridService = resolve(GridServiceInterface::class);

        $gridService->createGrid([4, 4, 5]);

        $shipService = resolve(ShipServiceInterface::class);

        $this->assertTrue($shipService->checkForSailingShips(session('battle_ships_grid')));
    }
}
