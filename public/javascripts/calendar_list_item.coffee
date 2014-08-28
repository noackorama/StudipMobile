helpers = require './helpers.coffee'

template = _.template """
    <% time = timeString === "00:00-23:59" ? timeString : "ganztägig" %>

    <a href=#popup-<%- event.id %> data-icon=info data-rel=popup>
      <span class=time><%= time %></span> <%- summary %>
    </a>

    <div data-role="popup" id="popup-<%- event.id %>"
         class="calendar-popup ui-content"
         style="min-width:240px;">

      <div class="time ui-bar ui-bar-d">
        <%= time %>:
      </div>

      <dl class=properties>
        <dt>
          Zusammenfassung:
        </dt>
        <dd>
          <%- event.summary %>
        </dd>

        <% if (event.description) { %>
        <dt>
          Beschreibung:
        </dt>
        <dd>
          <%- event.description %>
        </dd>
        <% } %>

        <% if (event.location) { %>
        <dt>
          Ort:
        </dt>
        <dd>
          <%- event.location %>
        </dd>
        <% } %>
      </dl>

      <% if (event.sem_id) { %>
        <a data-role=button data-mini=true href="<%- helpers.url_for("courses/show/" + event.sem_id) %>">
          Zur Veranstaltung
        </a>
      <% } %>

      <a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Schließen</a>

    </div
     """

listItemView = (data) ->
  template _.extend data, helpers: helpers


module.exports = listItemView
