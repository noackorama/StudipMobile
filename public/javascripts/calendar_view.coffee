helpers = require './helpers.coffee'
Q = require '../vendor/q/q.js'

module.exports = class CalendarView
  constructor: (selector, events, @date) ->
    @events = _.groupBy @enhanceEvents(events),
      ((event) -> @keyForDate event.begin), @

    @$el = @setupJQMCalendar $(selector)

  setupJQMCalendar: ($el) ->
    @calendar = @createCalendar $el
    $el.on 'beforerefresh', @bindRefresh

  createCalendar: ($el) ->
    $el.jqmCalendar
      events: _.flatten _.values @events
      date: @date
      months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
      days: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']
      startOfWeek: 1
    $el.data 'jqmCalendar'

  bindRefresh: (event, date) =>
    [month, year] = [date.getMonth(), date.getFullYear()]
    return  if @calendar.settings.date.getMonth() is month and @calendar.settings.date.getFullYear() is year

    $.mobile.loading 'show'
    @calendar.settings.date = date

    hide_it = _.bind $.mobile.loading, $.mobile, 'hide'

    $(document).ajaxStop hide_it

    Q.all(@loadEvents(date) for date in @monthsAround(date))
      .then (events) =>
        do hide_it unless $.active
        @calendar.settings.events = _.flatten _.values events
        @$el.trigger 'refresh'
        return
      , ->
        console.log 'Error:', error
        helpers.openPopup 'TODO Fehler'

  loadEvents: (date) ->
      key = @keyForDate date
      if @events[key]
        Q.fcall => @events[key]
      else
        Q $.getJSON helpers.url_for "calendar/events/#{date.getFullYear()}/#{date.getMonth() + 1}"
          .then (events) => @events[key] = @enhanceEvents events

  enhanceEvents: (events) ->
    for event in events
      event.begin = new Date event.begin
      event.end   = new Date event.end
    events

  keyForDate: (date) ->
    "#{date.getFullYear()}-#{date.getMonth()}"

  monthsAround: (date) ->
    year = date.getFullYear()
    month = date.getMonth()

    last    = new Date year, month - 1
    current = new Date year, month
    next    = new Date year, month + 1
    [last, date, next]
