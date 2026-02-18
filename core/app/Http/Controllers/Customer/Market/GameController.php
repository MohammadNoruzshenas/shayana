<?php

namespace App\Http\Controllers\Customer\Market;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display the specified game.
     */
    public function show(Game $game)
    {
        // Load game with relationships
        $game->load(['course', 'mainSeason', 'subSeason']);
        
        return view('customer.market.game.show', compact('game'));
    }
}
