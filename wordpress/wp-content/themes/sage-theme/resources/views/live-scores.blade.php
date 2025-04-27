<!doctype html>
<html {!! get_language_attributes() !!}>
@include('layouts.head')
<body @php body_class() @endphp>
@include('partials.header')
@php
use Roots\Acorn\Assets\Vite;
$defaultIcon = (new Vite())->asset('resources/images/ball.svg');
@endphp
<main class="main-content">
  <ul class="score-filters" data-buckets='@json($buckets)'>
    <li><a href="#" data-filter="all"       class="active">Tất cả ({{ $counts['all'] }})</a></li>
    <li><a href="#" data-filter="live">Trực tiếp ({{ $counts['live'] }})</a></li>
    <li><a href="#" data-filter="finished">Đã kết thúc ({{ $counts['finished'] }})</a></li>
    <li><a href="#" data-filter="scheduled">Lịch thi đấu ({{ $counts['scheduled'] }})</a></li>
  </ul>

  <div class="live-scores">
    @foreach($viewGroups as $group)
      <section class="league-group">
        <h2>{{ $group['league'] }}</h2>
        <table class="matches-table">
          <tbody>
          @foreach($group['matches'] as $m)
            <tr class="match-row" data-status-id="{{ $m['status_id'] }}">
              <td class="time">{{ $m['label'] }}</td>
              <td class="match_time">{{ $m['match_time'] }}</td>
              <td class="team home">
                <img src="{{ $m['home_logo'] ?: $defaultIcon }}"
                     alt="{{ $m['home_name'] }}"/>
                {{ $m['home_name'] }}
              </td>
              <td class="score">{{ $m['full_score'] }}</td>
              <td class="team away">
                {{ $m['away_name'] }}
                <img src="{{ $m['away_logo'] ?: $defaultIcon }}"
                     alt="{{ $m['away_name'] }}"/>
              </td>
              <td class="ht-score">{{ $m['ht_score'] }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </section>
    @endforeach
  </div>
</main>

@include('partials.footer')
@php wp_footer() @endphp
@stack('scripts')
</body>
</html>
