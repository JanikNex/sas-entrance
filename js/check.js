/**
 * Created by yanni on 18.06.2016.
 */
var audioError    = new Audio("mp3/error.mp3");
var audioCheckIn  = new Audio("mp3/checkIn.mp3");
var audioCheckOut = new Audio("mp3/checkIn.mp3");
var audioClosed   = new Audio("mp3/closed.mp3");
var audioWanted   = new Audio("mp3/wanted.mp3");
var currMode      = "In";
var currID        = 0;
var logsTmplt = `
    <li class="collection-item avatar">
        <i class="material-icons circle {{color}}">{{icon}}</i>
            <span class="title">{{name}} hat den Staat {{infotext}}</span>
            <p>{{timestamp}}<br/>
                <img src="barcode-scan.svg" height="16px" /> {{{scanner}}}
            </p>

        <i class="material-icons secondary-content {{success_color}}">{{success_icon}}</i>
    </li>
    `;

function onSend() {
    prepare();
    barcode = $("#barcode").val();
    console.log("Click"+currMode);
    $.getJSON("check.php?action=barcodeInfo&barcode="+barcode, null , function(data) {
        if(data["success"]) {
            updateCitizenData(data);
            currID = data["cID"];
            if(currMode == "In") {
                if (data["locked"]) {
                    Materialize.toast('Person gesperrt!', 2000, 'red');
                    $("#scanLocked").show();
                    audioError.play();
                    $("#barcode").val("");
                    $("#barcode").focus();
                } else if (data["wanted"]) {
                    Materialize.toast('Person gesucht!', 2000, 'red');
                    $("#scanWanted").show();
                    audioWanted.play();
                    checkIn(data["cID"]);
                } else {
                    Materialize.toast('Citizendata ok.', 2000, 'green');
                    Materialize.toast('Trying checkIn', 2000, 'green');
                    checkIn(data["cID"]);
                }
            } else {
                if (data["locked"]) {
                    Materialize.toast('Person gesperrt!', 2000, 'red');
                    $("#scanLocked").show();
                    audioError.play();
                    $("#barcode").val("");
                    $("#barcode").focus();
                } else if(data["wanted"]) {
                    Materialize.toast('Person gesucht!', 2000, 'red');
                    $("#scanWanted").show();
                    audioWanted.play();
                    checkIn(data["cID"]);
                } else if(!data["enoughTime"]) {
                    $("#modalTime").openModal();
                    $("#name").html(data["fname"]+" "+data["lname"]);
                    $("#time").html(data["timeToday"])
                } else {
                    Materialize.toast('Citizendata ok.', 2000, 'green');
                    Materialize.toast('Trying checkIn', 2000, 'green');
                    checkOut(data["cID"]);
                }
            }
        } else {
            Materialize.toast('Internal Error: '+data["error"], 2000, 'red');
            audioError.play();
            $("#barcode").val("");
            $("#barcode").focus();
        }
    });
}

function reset() {
    prepare();
    $("#barcode").val("");
    $("#barcode").focus();
    currID = 0;
}

function forceCheckOut() {
    checkOut(currID);
}

function prepare() {
    $("#barcode").focus();
    $("#isLocked").hide();
    $("#scanOK").hide();
    $("#scanFail").hide();
    $("#err1").hide();
    $("#err2").hide();
    $("#err3").hide();
    $("#err4").hide();
    $("#err5").hide();
    $("#err6").hide();
    $("#err7").hide();
    $("#err8").hide();
    $("#err9").hide();
    $("#scanLocked").hide();
    $("#scanWanted").hide();
    $("#name").html("...");
    $("#classlvl").html("...");
    $("ul#logs").html('<li class="collection-item avatar"><i class="material-icons circle grey">code</i> <span class="title">Warte auf Scan....</span> <p> </p> </li>');

    $.getJSON("check.php?action=stateInfo", null, function(data) {
        if(data["stateState"]) $("#scanClosed").hide();
        else {
            $("#scanClosed").show();
            audioClosed.play()
        }
    });
}

function updateCitizenData(data) {
    if(data["locked"]) $("#isLocked").show(); else $("#isLocked").hide();
    $("#iname").html(data["fname"]+" "+data["lname"]);
    $("#classlvl").html(data["classlvl"]);

    if(data["log"]) {
        $("ul#logs").html("");
        logstemplate = Handlebars.compile(logsTmplt);
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
}

function checkIn(cID) {
    $.getJSON("check.php?action=confirmCheckIn&cID=" + cID, null, function (data) {
        if (data["success"]) {
            Materialize.toast('CheckIn ok.', 2000, 'green');
            audioCheckIn.play();
            $("#scanOK").show();
        } else {
            if (data["error"]["errorStatus"] == 1) {
                $("#scanFail").show();
                Materialize.toast('Error: ' + data["error"]["errorString"], 4000, 'red');
                $("#err"+data["error"]["errorCode"]).show();
                $("#errCode").html("["+data["error"]["errorCode"]+"]:");
            } else Materialize.toast('Internal Error: ' + data["error"], 4000, 'red');
            audioError.play();
        }
        reloadCitizenData();
        $("#barcode").val("");
        $("#barcode").focus();
    });
}

function checkOut(cID) {
    $.getJSON("check.php?action=confirmCheckOut&cID=" + cID, null, function (data) {
        if (data["success"]) {
            Materialize.toast('CheckOut ok.', 2000, 'green');
            audioCheckOut.play();
            $("#scanOK").show();
        } else {
            if (data["error"]["errorStatus"] == 1) {
                $("#scanFail").show();
                Materialize.toast('Error: ' + data["error"]["errorString"], 4000, 'red');
                $("#err"+data["error"]["errorCode"]).show();
                $("#errCode").html("["+data["error"]["errorCode"]+"]:");
            } else Materialize.toast('Internal Error: ' + data["error"], 4000, 'red');
            audioError.play();
        }
        reloadCitizenData();
        $("#barcode").val("");
        $("#barcode").focus();
    });
}

function switchMode() {
    prepare();
    if(currMode == "In") {
        $("#title").html("Ausbuchen");
        currMode = "Out"
    } else {
        $("#title").html("Einbuchen");
        currMode = "In"
    }
}

function reloadCitizenData() {
    prepare();
    barcode = $("#barcode").val();
    console.log("reload"+currMode);
    $.getJSON("check.php?action=barcodeInfo&barcode="+barcode, null , function(data) {
        if(data["success"]) {
            updateCitizenData(data);
        } else {
            Materialize.toast('Internal Error: '+data["error"], 2000, 'red');
            audioError.play();
            $("#barcode").val("");
            $("#barcode").focus();
        }
    });
}