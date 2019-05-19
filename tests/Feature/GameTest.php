<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Interfaces\GameServiceInterface;
use App\Services\Interfaces\GridServiceInterface;

class GameTest extends TestCase
{
    /** @test */
    public function the_can_be_accessed_and_has_10_rows_and_10_cols()
    {
        $this->get(route('default-game'))
            ->assertStatus(200)
            ->assertSee('Battle Ships');
    }

    /** @test */
    public function when_the_default_game_is_finished_the_session_data_is_removed()
    {
        $gridService = resolve(GridServiceInterface::class);

        $gridService->createGrid([4, 4, 5]);

        $gameService = resolve(GameServiceInterface::class);

        $response = $this->post(route('default-game.shot'), [
            'row' => rand(1, 10),
            'col' => rand(1, 10),
        ]);

        $gameService->finishGame();

        $response->assertSessionMissing('battle_ships_grid');
        $response->assertSessionMissing('battle_ships_shots');
    }

    /** @test */
    public function every_time_when_the_game_starts_the_shot_count_is_zero()
    {
        $this->get('default-game');

        $this->assertEquals(0, session()->get('battle_ships_shots'));

        $this->post(route('default-game.shot'), [
            'row' => rand(1, 10),
            'col' => rand(1, 10),
        ]);

        $this->get('default-game');

        $this->assertEquals(0, session()->get('battle_ships_shots'));
    }
}
