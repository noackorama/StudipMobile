module.exports =  function (name, default_value) {
    return (global.STUDIP && global.STUDIP.Mobile && global.STUDIP.Mobile.bootstraps && global.STUDIP.Mobile.bootstraps[name]) || default_value;
};
