/**
 * Created by yanni on 11.07.2016.
 */

var currCitizenID = -1;
var currCitizenBarcode = 0;
var logTmplt = Handlebars.compile(`
    <li class="collection-item avatar">
        <i class="material-icons circle {{color}}">{{icon}}</i>
            <span class="title">{{name}} hat den Staat {{infotext}}</span>
            <p>{{timestamp}}<br/>
                <img src="barcode-scan.svg" height="16px" /> {{{scanner}}}
            </p>

        <i class="material-icons secondary-content {{success_color}}">{{success_icon}}</i>
    </li>
`);

$(document).ready(function () {
    $("#barcode").on("keydown", function(e) {
        if(e.which == 13) {
            e.preventDefault();
            checkData();
            currCitizenBarcode = $("#barcode").val();
            $("#barcode").val("");
        }
    });
    $("#btnCurrInfo").addClass("disabled");
    $("#btnCurrCheckIn").addClass("disabled");
    $("#btnCurrCheckOut").addClass("disabled");
    $("#btnCurrErrCorrect").addClass("disabled");
    $("#btnCurrErrIgnore").addClass("disabled");
});

function checkData() {
    var barcode = $("#barcode").val();

    $.getJSON("d_singleinfo.php?action=barcodeInfo&barcode="+barcode, null, function(data) {
        if(data.success == true) {
            Materialize.toast("Person gefunden.", 500, "green");
            $("#iCID").html(data.citizen.id);
            $("#iName").html(data.citizen.firstname+" "+data.citizen.lastname);
            $("#iClasslvl").html(data.citizen.classlevel);
            $("#iTimeToday").html(data.citizen.timeToday);

            $("#btnCurrInfo").removeClass("disabled");
            $("#btnCurrCheckIn").removeClass("disabled");
            $("#btnCurrCheckOut").removeClass("disabled");
            if(data.citizen.locked) {
                $("#btnCurrErrCorrect").removeClass("disabled");
                $("#btnCurrErrIgnore").removeClass("disabled");
            } else {
                $("#btnCurrErrCorrect").addClass("disabled");
                $("#btnCurrErrIgnore").addClass("disabled");
            }

            if(data.citizen.inState == 0) $("#iState").html("<span class='green-text bolden'>Im Staat</span>")
            else if(data.citizen.inState == 1) $("#iState").html("<span class='red-text bolden'>nicht im Staat</span>")
            else $("#iState").html("<span class='bolden'>unbekannt</span>")

            if(data.citizen.locked == 1) $("#iLocked").html("<span class='red-text bolden'>Aktiv</span>");
            else $("#iLocked").html("<span class='green-text'>inaktiv</span>");

            if(data.citizen.isWanted == 1) $("#iWanted").html("<span class='red-text bolden'>Ja</span>");
            else $("#iWanted").html("<span class='green-text'>nein</span>");

            currCitizenID = data.citizen.id;

            if(data["log"]) {
                $("ul#logs").html("");
                logstemplate = logTmplt;
                data["log"].forEach(function (element, index, array) {
                    name = element["citizenname"];
                    if(element["success"] == 1) {success_color = "green-text"; success_icon = "done";}
                    else {success_color = "red-text"; success_icon = "priority_high";}

                    if(element["action"] == 0) {color = "green"; icon = "navigate_before"; infotext = "betreten";}
                    else if(element["action"] == 1) {color = "red"; icon = "navigate_next"; infotext = "verlassen";}
                    else {color = "grey"; icon = "code"; infotext = "ignoriert";}


                    html = logstemplate({icon: icon, color: color, infotext: infotext, name: name, timestamp: element["timestamp"], scanner: element["scanner"], success_color: success_color, success_icon: success_icon});
                    $("ul#logs").append(html);
                });
            } else $("ul#logs").html('<li class="collection-item avatar"><i class="material-icons circle grey">code</i> <span class="title">Keine Einträge verfügbar.</span> <p> </p> </li>');
        } else {
            $("#btnCurrInfo").addClass("disabled");
            $("#btnCurrCheckIn").addClass("disabled");
            $("#btnCurrCheckOut").addClass("disabled");
            $("#btnCurrErrCorrect").addClass("disabled");
            $("#btnCurrErrIgnore").addClass("disabled");
            Materialize.toast("Person nicht gefunden.", 500, "red");
        }
    });
}

function currInfo() {
    window.location = "citizen.php?action=citizeninfo&cID="+currCitizenID;
}

function currCheckIn() {
    $.getJSON("check.php?action=confirmCheckIn&cID=" + currCitizenID, null, function (data) {
        if (data["success"]) {
            Materialize.toast('CheckIn ok.', 2000, 'green');
        } else {
            if (data["error"]["errorStatus"] == 1) {
                Materialize.toast('Error: ' + data["error"]["errorString"], 4000, 'red');
            } else Materialize.toast('Internal Error: ' + data["error"], 4000, 'red');
        }
        checkData();
    });
}

function currCheckOut() {
    $.getJSON("check.php?action=confirmCheckOut&cID=" + currCitizenID, null, function (data) {
        if (data["success"]) {
            Materialize.toast('CheckOut ok.', 2000, 'green');
        } else {
            if (data["error"]["errorStatus"] == 1) {
                Materialize.toast('Error: ' + data["error"]["errorString"], 4000, 'red');
            } else Materialize.toast('Internal Error: ' + data["error"], 4000, 'red');
        }
        checkData();
    });
}

function currErrCorrect() {
    data = {
        barcode: currCitizenBarcode
    }
    $.post("errors.php?action=autoCorrectJ", data, function(data) {
        json = JSON.parse(data);
        if(json.success) Materialize.toast("Korrigiert.", 2000, "green");
        else Materialize.toast("Mhh oukaay.", 4000, "red");
        checkData();
    });
}

function currErrIgnore() {
    data = {
        barcode: currCitizenBarcode
    }
    $.post("errors.php?action=autoIgnoreJ", data, function(data) {
        json = JSON.parse(data);
        if(json.success) Materialize.toast("Ignoriert. ^^", 2000, "green");
        else Materialize.toast("Mhh oukaay.", 4000, "red");
        checkData();
    });
}