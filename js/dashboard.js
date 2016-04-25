/**
 * Created by Janik Rapp on 15.04.2016.
 */

var oldData = null;

$(document).ready(function(){
    // Initialize collapse button
    $(".button-collapse").sideNav();
    // Initialize collapsible (uncomment the line below if you use the dropdown variation)
    $('.collapsible').collapsible();

    updateCaller();
});

function update() {
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
    var numTmplt = `<span>{{count}}</span>`;
    var timeTmplt = `{{hrs}}:{{min}}:{{sec}}`;
    var stateTmplt = `<p>Der Staat Schlopolis ist momentan <span class="{{color}}-text bolden"> {{state}}</span></p>`;
    template = Handlebars.compile(numTmplt);
    timetemplate = Handlebars.compile(timeTmplt);
    statetemplate = Handlebars.compile(stateTmplt);
    logstemplate = Handlebars.compile(logsTmplt);
    finishedString = [];
    $.getJSON("getLists.php?action=dashboard", function (data) {
        if(!(JSON.stringify(oldData) == JSON.stringify(data))) {
            if(data["stateState"]){
                status = "geöffnet";
                color = "green";
                $("#btnopen").addClass("disabled");
                $("#btnopen").removeAttr("onClick");
                $("#btnclose").removeClass("disabled");
                $("#btnclose").attr("onClick", "closeState()");
            }else{
                status = "geschlossen";
                color = "red";
                $("#btnopen").removeClass("disabled");
                $("#btnopen").attr("onClick", "openState()");
                $("#btnclose").addClass("disabled");
                $("#btnclose").removeAttr("onClick");
            }
            $("#stateState").html(statetemplate({state: status, color: color}));
            $("#all").html(template({count: data["all"]}));
            $("#visitors").html(template({count: data["visitors"]}));
            $("#students").html(template({count: data["students"]}));
            $("#courriers").html(template({count: data["courriers"]}));
            $("#badcitizen").html(template({count: data["badCitizens"]}));
            $("#errors").html(template({count: data["errors"]}));
            $("#tracings").html(template({count: data["tracings"]}));
            console.log("update");
            oldData = data;
        }
        var d = new Date();
        $("#time").html(timetemplate({hrs: pad(d.getHours()), min: pad(d.getMinutes()), sec: pad(d.getSeconds())}));
    });

    $.getJSON("getLists.php?action=latestLogs", function(data) {
        $("ul#logs").html("");
        data["logs"].forEach(function (element, index, array) {
            name = element["citizenname"];
            if(element["success"] == 1) {success_color = "green-text"; success_icon = "done";}
            else {success_color = "red-text"; success_icon = "priority_high";}

            if(element["action"] == 0) {color = "green"; icon = "navigate_before"; infotext = "betreten";}
            else if(element["action"] == 1) {color = "red"; icon = "navigate_next"; infotext = "verlassen";}
            else {color = "grey"; icon = "code"; infotext = "ignoriert";}


            html = logstemplate({icon: icon, color: color, infotext: infotext, name: name, timestamp: element["timestamp"], scanner: element["scanner"], success_color: success_color, success_icon: success_icon});
            $("ul#logs").append(html);
        });
    });
}

function updateCaller(){
    update();
    window.setTimeout("updateCaller()", 500);
}

function closeState() {
    console.log("close");
    $.getJSON("dashboard.php?action=closeState", function(data) {
        if(data["success"] == true) {
            Materialize.toast('Staat geschlossen', 2000, 'red');
        } else {
            Materialize.toast('Fehler: Staat bleibt offen', 2000, 'green');
        }
        update();
    });
}

function openState() {
    console.log("open");

    $.getJSON("dashboard.php?action=openState", function(data) {
        if(data["success"] == true) {
            Materialize.toast('Staat geöffnet', 2000, 'green');
        } else {
            Materialize.toast('Fehler: Staat bleibt offen', 2000, 'red');
        }
        update();
    });
}


function pad(num) {
    var s = num+"";
    while (s.length < 2) s = "0" + s;
    return s;
}

$('.dropdown-button').dropdown({
    inDuration: 300,
    outDuration: 225,
    constrain_width: false, // Does not change width of dropdown to that of the activator
    hover: false, // Activate on hover
    gutter: 0, // Spacing from edge
    belowOrigin: true, // Displays dropdown below the button
    alignment: 'right' // Displays dropdown with edge aligned to the left of button
});