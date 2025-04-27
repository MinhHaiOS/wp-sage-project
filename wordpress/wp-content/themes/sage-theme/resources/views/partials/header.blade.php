@php
use App\Models\MatchModel;
@endphp
@vite(['resources/assets/styles/live-scores.scss'])
<script>
  window.MatchModel = {
    STATUS_NOT_STARTED: {{ MatchModel::STATUS_NOT_STARTED }},
    STATUS_FIRST_HALF: {{ MatchModel::STATUS_FIRST_HALF }},
    STATUS_HALF_TIME: {{ MatchModel::STATUS_HALF_TIME }},
    STATUS_SECOND_HALF: {{ MatchModel::STATUS_SECOND_HALF }},
    STATUS_OVERTIME: {{ MatchModel::STATUS_OVERTIME }},
    STATUS_OVERTIME_DEPRECATED: {{ MatchModel::STATUS_OVERTIME_DEPRECATED }},
    STATUS_PENALTY_SHOOTOUT: {{ MatchModel::STATUS_PENALTY_SHOOTOUT }},
    STATUS_END: {{ MatchModel::STATUS_END }},
    STATUS_DELAY: {{ MatchModel::STATUS_DELAY }},
  };
</script>
