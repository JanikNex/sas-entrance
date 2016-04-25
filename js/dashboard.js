/**
 * Created by Janik Rapp on 15.04.2016.
 */



$(document).ready(function(){
    // Initialize collapse button
    $(".button-collapse").sideNav();
    // Initialize collapsible (uncomment the line below if you use the dropdown variation)
    $('.collapsible').collapsible();

    updateCaller();
});

function update() {
    var numTmplt = `<span>{{count}}</span>`;
    var stateTmplt = `<p>Der Staat Schlopolis ist momentan <span class="{{color}}-text bolden"> {{state}}</span></p>`;
    template = Handlebars.compile(numTmplt);
    statetemplate = Handlebars.compile(stateTmplt);
    finishedString = [];
    $.getJSON("getLists.php?action=dashboard", function (data) {
        if(!(JSON.stringify(oldData) == JSON.stringify(data))) {
            if(data["stateState"]){
                status = "geöffnet";
                color = "green"
            }else{
                status = "geschlossen";
                color = "red"
            }
            $("#stateState").html(statetemplate({state: status, color: color}));
            $("#all").html(template({count: data["all"]}));
            $("#visitors").html(template({count: data["visitors"]}));
            $("#students").html(template({count: data["students"]}));
            $("#courriers").html(template({count: data["courriers"]}));
            $("#badCitizens").html(template({count: data["badCitizens"]}));
            $("#errors").html(template({count: data["errors"]}));
            $("#tracings").html(template({count: data["tracings"]}));
            console.log("update");
            oldData = data;
        }
    });
    $('.modal-trigger').leanModal();
}

function updateCaller(){
    update();
    window.setTimeout("updateCaller()", 500);
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