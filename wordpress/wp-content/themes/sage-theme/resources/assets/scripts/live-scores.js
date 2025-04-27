import jQuery from 'jquery';

jQuery(function($){
  // Delegate clicks on any filter tab
  $('.score-filters').on('click', 'a', function(e){
    e.preventDefault();

    const filter = $(this).data('filter');

    // Toggle active class on tabs
    $('.score-filters a').removeClass('active');
    $(this).addClass('active');

    // Show/hide each row based on its data-status-id
    $('.match-row').each(function(){
      const sid = parseInt($(this).data('status-id'), 10);
      let show = false;

      if (filter === 'all') {
        show = true;
      } else if (filter === 'scheduled' && sid === MatchModel.STATUS_NOT_STARTED) {
        show = true;
      } else if (filter === 'live' && [
        MatchModel.STATUS_FIRST_HALF,
        MatchModel.STATUS_HALF_TIME,
        MatchModel.STATUS_SECOND_HALF,
        MatchModel.STATUS_OVERTIME,
        MatchModel.STATUS_OVERTIME_DEPRECATED,
        MatchModel.STATUS_PENALTY_SHOOTOUT
      ].includes(sid)) {
        show = true;
      } else if (filter === 'finished' && [
        MatchModel.STATUS_END,
        MatchModel.STATUS_DELAY
      ].includes(sid)) {
        show = true;
      }

      $(this).toggle(show);
    });
  });
});
