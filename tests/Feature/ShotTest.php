<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\Interfaces\ShipServiceInterface;

class ShotTest extends TestCase
{
    /** @test */
    public function the_shot_request_returns_data_for_the_hit_cell()
    {
        $this->get(route('default-game'));

        $grid = session('battle_ships_grid');

        for ($row = 1; $row <= count($grid); $row++) {
            for ($col = 1; $col <= count($grid[$row]); $col++) {
                if($grid[$row][$col]['is_empty']) {
                    $response = $this->post(route('default-game.shot'), [
                        'row' => $row,
                        'col' => $col,
                    ]);

                    $this->assertTrue(isset($response->original['empty_cell']));

                    break;
                }
            }
        }
    }

    /** @test */
    public function when_all_ships_have_sunken_the_request_contains_the_shot_count()
    {
        $this->get(route('default-game'));

        $shipService = resolve(ShipServiceInterface::class);

        $shotsCounter = 0;

        while($shipService->checkForSailingShips(session('battle_ships_grid'))) {
            $response = $this->post(route('default-game.shot'), [
                'row' => rand(1, 10),
                'col' => rand(1, 10),
            ]);

            if(! isset($response->original['already_hit_cell'])) {
                $shotsCounter++;
            }

            if(! session()->has('battle_ships_grid')) {
                $response->assertSessionMissing('battle_ships_grid')
                    ->assertSessionMissing('battle_ships_shots')
                    ->assertJsonCount(1)
                    ->assertJsonStructure(['shot_count']);

                $this->assertEquals($shotsCounter, $response->original['shot_count']);

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

    /** @test */
    public function the_shot_increases_the_session_shots_count()
    {
        $this->get(route('default-game'));

        $this->post(route('default-game.shot'), [
            'row' => rand(1, 10),
            'col' => rand(1, 10),
        ]);

        $this->assertEquals(1, session()->get('battle_ships_shots'));
    }

    /** @test */
    public function the_second_hit_under_same_cell_does_not_increases_the_shot_count()
    {
        $this->get(route('default-game'));

        $this->post(route('default-game.shot'), [
            'row' => 1,
            'col' => 1,
        ]);

        $this->assertEquals(1, session()->get('battle_ships_shots'));

        $this->post(route('default-game.shot'), [
            'row' => 1,
            'col' => 1,
        ]);

        $this->assertEquals(1, session()->get('battle_ships_shots'));
    }

    /** @test */
    public function the_row_and_col_values_in_the_request_are_validated_according_to_the_grid()
    {
        $this->get(route('default-game'));

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->post(route('default-game.shot'), [
            'row' => 11,
            'col' => 1,
        ])->assertJsonValidationErrors('The given data was invalid.');

        $this->post(route('default-game.shot'), [
            'row' => 1,
            'col' => 11,
        ])->assertJsonValidationErrors('The given data was invalid.');

        $this->post(route('default-game.shot'), [
            'row' => -1,
            'col' => 1,
        ])->assertJsonValidationErrors('The given data was invalid.');

        $this->post(route('default-game.shot'), [
            'row' => 1,
            'col' => 0,
        ])->assertJsonValidationErrors('The given data was invalid.');
    }

    /** @test */
    public function the_row_and_col_data_in_the_shot_request_should_be_of_type_integer()
    {
        $this->get(route('default-game'));

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->post(route('default-game.shot'), [
            'row' => 'string',
            'col' => 1,
        ])->assertJsonValidationErrors('The given data was invalid.');
    }
}
