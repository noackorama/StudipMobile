module.exports =  (name, default_value) ->
    (global.STUDIP && global.STUDIP.Mobile && global.STUDIP.Mobile.bootstraps && global.STUDIP.Mobile.bootstraps[name]) || default_value
