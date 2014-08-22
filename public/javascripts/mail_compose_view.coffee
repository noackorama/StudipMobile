helpers = require './helpers.coffee'

class MailComposeView

  constructor: (el, options) ->
    @$el = $ el
    @$ul = @$el.find "#composer"

    @searchResults = {}

    @mail = options.mail ? new MailModel
    @addRecipient(rec) for rec in @mail.recipients

    @contacts = options.contacts ? []
    @setupContacts @$el.find '#mail-show-contacts'

    @search = $('#rec-search').on 'keyup change input', @onKeyUp

    @$el.on "click", ".recipient",   @onSelectRecipient
    @$el.on "click", ".selected li", @onRemoveRecipient

    @$el.on "submit", "form", =>
      @mail.subject = @$el.find('#rec-subject').val().trim()
      @mail.message = @$el.find('#rec-message').val().trim()

      $.mobile.loading "show", text: "Sende Nachricht", textVisible: on

      @mail.send()
        .then \
            ->
              $.mobile.loading "hide"
              do $.mobile.back

          , (error) ->
              $.mobile.loading "hide"
              helpers.openPopup _.values(error).join '<br>'

      false


  recipientTemplate: _.memoize \
    -> _.template """
      <li class=recipient data-theme=c data-id="<%- id %>">
        <img src="<%- img %>" class="ui-li-icon">
        <%- name %>
      </li>
      """

  selectedRecipientTemplate: _.memoize \
    -> _.template """
      <li id='user-<%- id %>' data-id='<%- id %>'>
        <a href="#">
          <img src="<%- img %>" class="ui-li-icon">
          <%- name %>
        </a>
      </li>
      """

  setupContacts: (contacts) ->
    contacts
      .on 'popupbeforeposition', =>
        do @clearSearch

        for check in contacts.find ':checkbox' when @mail.recipients[$(check).data 'id']
          $(check).prop('checked', true).checkboxradio('refresh').checkboxradio('disable')

      .on 'popupafterclose', ->
        $(':checked', this)
          .prop 'checked', off
          .checkboxradio 'refresh'

      .on 'click', '.select', =>
        for check in contacts.find ':checked'
          @addRecipient _.findWhere @contacts, id: $(check).data 'id'
        contacts.popup 'close'


  startSearching: ->
    $.mobile.loading "show"
    @

  doneSearching: ->
    $.mobile.loading "hide"
    @

  clearSearch: ->
    @$ul.find(".recipient").remove()
    @searchResults = {}

  clearSearchField: ->
    @$el.find("#rec-search").val("")

  onKeyUp: (e) =>
    insertionPoint = @$ul.find(".recipients")

    val = @search.val()
    lastVal = @search.data("last-value") ? ""

    @clearSearch() unless val is lastVal

    @search.data "last-value", val

    return  if val.length < 3 || val is lastVal

    do @startSearching

    @searchUser(val)
      .then \
        (data) =>
          do @doneSearching

          return  if val isnt @search.data("last-value")

          do @clearSearch # TODO: still needed?

          template = @recipientTemplate()

          for user in data
            unless @mail.recipients[user.id]?
              @searchResults[user.id] = user
              insertionPoint.after template user

          @$ul.listview "refresh"
              .trigger "updatelayout"

        , (error) ->
          alert "Error"
          debugger


  searchUser: (query) ->
    $.getJSON helpers.url_for('users/search'), query: query


  onSelectRecipient: (e) =>
    $rel = $ e.currentTarget

    rec = @searchResults[$rel.data "id"]
    @addRecipient rec  unless @mail.recipients[rec.id]?

    do @clearSearchField
    do @clearSearch


  onRemoveRecipient: (e) =>
    $rel = $ e.currentTarget
    id = $rel.data "id"

    @removeRecipient id


  addRecipient: (recipient) ->
    return if @mail.recipients[recipient.id]
    @mail.recipients[recipient.id] = recipient

    template = @selectedRecipientTemplate()

    @$el.find(".recipients .selected")
      .append template recipient
      .listview "refresh"
      .trigger "updatelayout"
    @

  removeRecipient: (id) ->
    console.log "recipient removed #{id}"
    delete @mail.recipients[id]

    @$el.find(".selected #user-#{id}").remove()
    @


module.exports = MailComposeView
