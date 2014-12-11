jQuery(function($) {
    $("#leftpanel").panel().enhanceWithin();
});

jQuery(document).on('pagecontainerhide', 'div', function (event, ui) {
    var page = jQuery(event.target);

    if (page.attr('data-cache') === 'never'){
        page.remove();
    }
});

// global counter of the
var DROPBOX_COUNTER = 0;
// global indicator for upload or login errors
var DROPBBOX_FAIL    = false;


/*
 * You use this function to upload a specified
 * file to a specified folder in the users dropbox
 * via a Jquery Ajax Call.
 * No existing folders are created.
 * Dependencies:
 *    - users dropbox should be connectet via
 *      dopbox php api project
 *    - jQuery should be included
 *    - needs an div width id ="uploadList"
 *
 * @param filename the path to file
 * @param folder folder in the users dropbox to put the file
 * @return creates li elements in the div width the status message
 */
function uploadFileDropbox(upload_url, fileid)
{
    DROPBOX_COUNTER++;
    var link = upload_url + "/" + fileid;
    $.ajax(
        {
            type:  "GET",
            url:   link,
            data:  { },
            success: function( data )
            {
                DROPBOX_COUNTER--;

                if( data.substring(0,7) == "success" )
                {
                    data = "Erfolgreich: " + data.substring(8,data.length);
                }
                if( data.substring(0,6) == "exists" )
                {
                    data = "Existiert bereits: " + data.substring(7,data.length);
                }
                else if ( data.substring(0,4) == "fail" )
                {
                    data = "Fehler: " + data.substring(5,data.length);
                    DROPBBOX_FAIL = true;
                }
                var newLI           = document.createElement("li");
                newLI.className         = "ui-li ui-li-static ui-body-b ui-corner-top ui-corner-bottom";
                newLI.innerHTML =  data;
                document.getElementById("uploadList").appendChild(newLI);
                if (( DROPBBOX_FAIL === false ) && ( DROPBOX_COUNTER === 0 ))
                {
                    newLI                   = document.createElement("li");
                    newLI.innerHTML         = "Alle Dateien aktualisiert";
                    newLI.className         = "ui-li ui-li-static ui-body-b ui-corner-top ui-corner-bottom";
                    document.getElementById("uploadList").appendChild(newLI);
                }
            },
            error: function()
            {
                var newLI           = document.createElement("li");
                newLI.innerHTML =  "Fehler aufgetreten ";
                newLI.className         = "ui-li ui-li-static ui-body-b ui-corner-top ui-corner-bottom";
                document.getElementById("uploadList").appendChild(newLI);
            }

        });
}
