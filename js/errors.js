/**
 * Created by yanni on 10.04.2016.
 */


var oldData = "";
var sort = "descDate";
var filter = "Alle";

function setFilter(afilter) {
    filter = afilter;
    updateSortnFilter();
    update();
}

function setSort(asort) {
    sort = asort;
    updateSortnFilter();
    update();
}

function updateSortnFilter() {
    if(sort.startsWith("asc")) {
        thissort = sort.replace("asc","");
        $("#currSort").html("<i class=\"mdi mdi-sort-ascending\"></i> "+thissort);
    }
    else {
        thissort = sort.replace("desc","");
        $("#currSort").html("<i class=\"mdi mdi-sort-descending\"></i> "+thissort);
    }
    $("#currFilter").html("<i class=\"mdi mdi-filter\"></i> "+filter);
}

function updateSearch() {
    // Retrieve the input field text and reset the count to zero
    var filter = $("#filter").val(), count = 0;

    // Loop through the comment list
    $("ul.collection li").each(function(){

        // If the list item does not contain the text phrase fade it out
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
            $(this).hide();
            // Show the list item if the phrase matches and increase the count by 1
        } else {
            $(this).show();
            count++;
        }
    });

    // Update the count
    var numberItems = count;
}

$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
    $("#filter").keyup(function () {
        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;

        // Loop through the comment list
        $("ul.collection li").each(function(){

            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();
                // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });

        // Update the count
        var numberItems = count;
    });

    // Initialize collapse button
    $(".button-collapse").sideNav();
    // Initialize collapsible (uncomment the line below if you use the dropdown variation)
    $('.collapsible').collapsible();


    String.prototype.format = function() {
        var s = arguments[0];
        for (var i = 0; i < arguments.length - 1; i++) {
            var reg = new RegExp("\\{" + i + "\\}", "gm");
            s = s.replace(reg, arguments[i + 1]);
        }

        return s;
    };
    updateSortnFilter();
    updateCaller();
});

function update() {
    var listElemTmplt = `
            <li class="collection-item avatar">
                <i class="material-icons circle {{color}}">error_outline</i>
                <span class="title">[{{errorCode}}]: {{errorString}}
                    @Citizen: [#{{cID}}]{{citizenName}}</span>
                <p>
                    {{timestamp}}
                </p>
                <span class="secondary-content">
                    <a class="waves-effect waves-circle" href="errors.php?action=correctThis&eID={{eID}}">
                        <i class="material-icons grey-text text-darken-1" style="margin: 0px 5px;">done</i>
                    </a>
                    <a class="waves-effect waves-circle waves-red modal-trigger" onclick="$('#modal{{eID}}').openModal();" style="margin: 0px 5px;">
                        <i class="material-icons grey-text text-darken-1">delete</i>
                    </a>
                </span>
                <div id="modal{{eID}}" class="modal">
                    <div class="modal-content black-text">
                        <h4>L&ouml;schen</h4>
                        <p>M&ouml;chtest Du den Fehler wirklich l&ouml;schen?<br/>Dies kann zu großen Problemen führen</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                        <a href="errors.php?action=del&eID={{eID}}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
                    </div>
                </div>
            </li>
        `;
    template = Handlebars.compile(listElemTmplt);
    finishedString = [];
    $.getJSON("getLists.php?action=errors&filter="+filter+"&sort="+sort, function (data) {
        if(!(JSON.stringify(oldData) == JSON.stringify(data))) {
            $("ul#errors").html("");
            data["errors"].forEach(function (element, index, array) {
                if(element["errorStatus"] == 0) color = "green";
                else if(element["errorStatus"] == 1) color = "red";
                else color = "grey";
                html = template({eID: element["eID"], cID: element["cID"], errorCode: element["errorCode"], errorString: element["errorString"], citizenName: element["citizenName"], color: color, timestamp: element["timestamp"]});
                $("ul#errors").append(html);
            });
            console.log("update");
            oldData = data;
            updateSortnFilter();
            updateSearch();
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