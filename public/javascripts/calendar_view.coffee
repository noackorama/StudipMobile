helpers = require './helpers.coffee'
Q = require '../vendor/q/q.js'
listItemView = require './calendar_list_item.coffee'

module.exports = class CalendarView
  constructor: (selector, events, @date) ->
    @events = _.groupBy @enhanceEvents(events),
      ((event) -> @keyForDate event.begin), @

    @$el = @setupJQMCalendar $(selector)

  setupJQMCalendar: ($el) ->
    @calendar = @createCalendar $el
    $el.trigger 'change', @date
    $el.on 'beforerefresh', @bindRefresh
    $el.find("> ul.ui-listview").listview("option", "icon", "info")

  createCalendar: ($el) ->
    $el.jqmCalendar
      events: _.flatten _.values @events
      date: @date
      months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember']
      days: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa']
      startOfWeek: 1
      listItemFormatter: @listItemFormatter
    $el.data 'jqmCalendar'

  bindRefresh: (event, date) =>
    [month, year] = [date.getMonth(), date.getFullYear()]
    return  if @calendar.settings.date.getMonth() is month and @calendar.settings.date.getFullYear() is year

    @calendar.settings.date = date

    timer = setTimeout (-> $.mobile.loading 'show'), 300
    hide_it = ->
      clearTimeout timer
      $.mobile.loading 'hide'

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

  listItemFormatter: ($listItem, timeString, summary, event) =>
    $listItem.append listItemView
        event: event
        timeString: timeString
        summary: summary
    _.defer -> $listItem.parent('ul')[0].scrollIntoView()
