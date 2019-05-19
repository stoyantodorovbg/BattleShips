<?php

namespace App\Http\Controllers;

use App\Http\Requests\DefaultGameShotRequest;
use App\Services\Interfaces\CellServiceInterface;
use App\Services\Interfaces\GameServiceInterface;
use App\Services\Interfaces\GridServiceInterface;
use App\Services\Interfaces\ShipServiceInterface;
use App\Services\Interfaces\ShotServiceInterface;

class GameController extends Controller
{
    /**
     * Render the Battle Ships game view
     *
     * @param GridServiceInterface $gridService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function battleShips(GameServiceInterface $gameService)
    {
        $grid = $gameService->startGame([5, 4, 4]);

        $grid = collect($grid);

        return view('games.battle-ships', compact('grid'));
    }

    /**
     * Shot to a grid cell
     *
     * @param DefaultGameShotRequest $request
     * @param ShotServiceInterface $shotService
     * @param ShipServiceInterface $shipService
     * @param GameServiceInterface $gameService
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function shot(DefaultGameShotRequest $request,
                         ShotServiceInterface $shotService,
                         ShipServiceInterface $shipService,
                         GameServiceInterface $gameService,
                         CellServiceInterface $cellService)
    {
        $coords = $request->validated();

        if($cellService->hasCellHit($coords)) {
            return response([
                'already_hit_cell' => true,
            ]);
        }

        $response = $this->processShotData($coords, $shotService, $shipService, $gameService, $cellService);

        return response($response);
    }

    /**
     * Prepare a data for the shot response
     *
     * @param array coords
     * @param ShotServiceInterface $shotService
     * @param ShipServiceInterface $shipService
     * @param GameServiceInterface $gameService
     * @param CellServiceInterface $cellService
     * @return array
     */
    protected function processShotData(array $coords, ShotServiceInterface $shotService, ShipServiceInterface $shipService, GameServiceInterface $gameService, CellServiceInterface $cellService): array
    {
        $response = [];

        $grid = $shotService->shootCell($coords);

        if ($cellService->isCellEmpty($coords, $grid)) {
            $response['empty_cell'] = true;
        }

        if (! $shipService->checkForSailingShips($grid)) {
            $shotCount = $gameService->finishGame();

            $response['shot_count'] = $shotCount;
        }

        return $response;
    }
}
