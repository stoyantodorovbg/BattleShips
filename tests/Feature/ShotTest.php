<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Interfaces\ShipServiceInterface;
use App\Services\Interfaces\GridServiceInterface;

class ShotTest extends TestCase
{
    /** @test */
    public function the_shot_request_returns_the_grid_data()
    {
        $gridService = resolve(GridServiceInterface::class);

        $gridService->createGrid([4, 4, 5]);

        $this->post(route('default-game.shot'), [
            'row' => rand(1, 10),
            'col' => rand(1, 10),
        ])->assertStatus(200)
        ->assertJsonCount( 10, 'grid');
    }

    /** @test */
    public function when_all_ships_have_sunken_the_request_contains_the_shot_count()
    {
        $gridService = resolve(GridServiceInterface::class);

        $grid = $gridService->createGrid([4, 4, 5]);

        $shipService = resolve(ShipServiceInterface::class);

        while($shipService->checkForSailingShips(session('battle_ships_grid'))) {
            $response = $this->post(route('default-game.shot'), [
                'row' => rand(1, 10),
                'col' => rand(1, 10),
            ]);

            if(! session()->has('battle_ships_grid')) {
                $response->assertSessionMissing('battle_ships_grid')
                    ->assertSessionMissing('battle_ships_shots')
                    ->assertJsonCount(2)
                    ->assertJsonStructure(['grid', 'shot_count']);

                break;
            }
        }
    }

    /** @test */
    public function the_player_can_shoot_only_when_the_grid_exists()
    {
        $this->get(route('default-game'));

        session()->forget('battle_ships_grid');

        $this->post(route('default-game.shot'), [
            'row' => rand(1, 10),
            'col' => rand(1, 10),
        ])->assertStatus(403)
        ->assertForbidden();
    }
}
