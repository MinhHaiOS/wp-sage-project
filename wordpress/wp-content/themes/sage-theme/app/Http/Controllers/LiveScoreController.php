<?php

namespace App\Http\Controllers;

use App\Services\MatchService;
use Illuminate\Routing\Controller as BaseController;

class LiveScoreController extends BaseController
{
    protected MatchService $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    public function index()
    {
        $data = $this->matchService->prepareLiveScores();

        return view('live-scores', $data);
    }
}
