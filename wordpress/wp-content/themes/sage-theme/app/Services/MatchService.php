<?php

namespace App\Services;

use App\Repositories\MatchRepository;
use App\Models\MatchModel;

class MatchService
{
    protected MatchRepository $repo;

    public function __construct(MatchRepository $repo)
    {
        $this->repo        = $repo;

    }

    public function prepareLiveScores(): array
    {
        $all      = $this->repo->getAll();
        $counts   = $this->counts($all);
        $buckets  = $this->buckets();
        $viewGroups = $this->buildViewGroups($all);

        return compact('counts','buckets','viewGroups');
    }

    protected function counts($all): array
    {
        $live = [
            MatchModel::STATUS_FIRST_HALF,
            MatchModel::STATUS_HALF_TIME,
            MatchModel::STATUS_SECOND_HALF,
            MatchModel::STATUS_OVERTIME,
            MatchModel::STATUS_OVERTIME_DEPRECATED,
            MatchModel::STATUS_PENALTY_SHOOTOUT,
        ];

        return [
            'all'       => $all->count(),
            'live'      => $all->whereIn('status_id',$live)->count(),
            'finished'  => $all->whereIn('status_id',[
                MatchModel::STATUS_END,
                MatchModel::STATUS_DELAY,
            ])->count(),
            'scheduled' => $all->where('status_id',MatchModel::STATUS_NOT_STARTED)->count(),
        ];
    }

    protected function buckets(): array
    {
        return [
            'live'      => [
                MatchModel::STATUS_FIRST_HALF,
                MatchModel::STATUS_HALF_TIME,
                MatchModel::STATUS_SECOND_HALF,
                MatchModel::STATUS_OVERTIME,
                MatchModel::STATUS_OVERTIME_DEPRECATED,
                MatchModel::STATUS_PENALTY_SHOOTOUT,
            ],
            'finished'  => [
                MatchModel::STATUS_END,
                MatchModel::STATUS_DELAY,
            ],
            'scheduled' => [
                MatchModel::STATUS_NOT_STARTED,
            ],
        ];
    }

    protected function buildViewGroups($all): array
    {
        $groups = $all->groupBy(fn($m) => $m->competition->name)
                      ->sortBy(fn($matches) => $matches->first()->competition->display_order);

        return $groups->map(fn($matches, $leagueName) => [
            'league'  => $leagueName,
            'matches' => $matches->map(fn($m) => $this->formatMatchRow($m))
                                 ->values()
                                 ->all(),
        ])->values()->all();
    }

    protected function formatMatchRow(MatchModel $m): array
    {
        $matchTime = match ($m->status_id) {
            MatchModel::STATUS_HALF_TIME => 'Nghỉ giữa hiệp 1',
            default => $m->match_time,
        };

        // 2) logos
        $homeLogo = $m->homeTeam->logo_url;
        $awayLogo = $m->awayTeam->logo_url;

        // 3) scores
        [$hFull,$hHt] = explode(',', $m->home_scores);
        [$aFull,$aHt] = explode(',', $m->away_scores);

        return [
            'status_id'  => $m->status_id,
            'label'      => date('H:i', $m->match_start_time),
            'match_time'  => $matchTime,
            'home_name'  => $m->homeTeam->name,
            'away_name'  => $m->awayTeam->name,
            'home_logo'  => $homeLogo,
            'away_logo'  => $awayLogo,
            'full_score' => "{$hFull}–{$aFull}",
            'ht_score'   => "HT {$hHt}–{$aHt}",
        ];
    }
}
