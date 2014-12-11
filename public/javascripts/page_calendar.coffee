CalendarView = require './calendar_view.coffee'
bootstrap = require './bootstraps.coffee'

$(document).on "pagecontainerbeforeshow", _.once \
  ->
    events = bootstrap 'events', []
    date = new Date bootstrap 'date', Date.now()

    calendar = new CalendarView '#calendar', events, date
