/**
 * Created by yanni on 10.04.2016.
 */

var oldData = "";
var sort = "ascName";
var filter = "Alle";
var requestPage = 1;
var searchString = "";
var modalID = 0;

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
        $("#sortCurr").html("<i class=\"mdi mdi-sort-ascending\"></i> "+thissort);
    }
    else {
        thissort = sort.replace("desc","");
        $("#sortCurr").html("<i class=\"mdi mdi-sort-descending\"></i> "+thissort);
    }
    if(filter.startsWith("Stufe")) {
        thisfilter = parseInt(filter.replace("Stufe",""));
        $("#filterCurr").html("<i class=\"mdi mdi-filter\"></i> KS "+thisfilter);
    } else $("#filterCurr").html("<i class=\"mdi mdi-filter\"></i> "+filter);
}

function updatePages(currPage, maxPage) {
    if(currPage > maxPage) {
        requestPage = maxPage;
        if(requestPage == 0) requestPage = 1;
    }
    nextPage = parseInt(currPage)+1;
    prevPage = currPage-1;
    $("#pages").html("");
    if(currPage <= 1) $("#pages").append("<li class=\"disabled\"><a><i class=\"material-icons\">chevron_left</i></a></li>");
    else $("#pages").append("<li class=\"waves-effect\"><a onclick=\"setPage("+prevPage+")\"><i class=\"material-icons\">chevron_left</i></a></li>");

    for(i = 1; i <= maxPage; i++) {
        if(i != currPage) {
            $("#pages").append("<li class=\"waves-effect\"><a onclick=\"setPage("+i+")\">"+i+"</a></li>");
        } else {
            $("#pages").append("<li class=\"active indigo\"><a onclick=\"setPage("+i+")\">"+i+"</a></li>");
        }
    }

    if(currPage >= maxPage) $("#pages").append("<li class=\"disabled\"><a><i class=\"material-icons\">chevron_right</i></a></li>");
    else $("#pages").append("<li class=\"waves-effect\"><a onclick=\"setPage("+nextPage+")\"><i class=\"material-icons\">chevron_right</i></a></li>");
}

function setPage(apage) {
    requestPage = apage;
    update();
}

$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
    $("#filter").keyup(function () {
        searchString = $(this).val();
        update();
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
    (function() {
        var oldOpen = XMLHttpRequest.prototype.open;
        window.openHTTPs = 0;
        XMLHttpRequest.prototype.open = function(method, url, async, user, pass) {
            window.openHTTPs++;
            this.addEventListener("readystatechange", function() {
                if(this.readyState == 4) {
                    window.openHTTPs--;
                }
            }, false);
            oldOpen.call(this, method, url, async, user, pass);
        }
    })();
    updateSortnFilter();
    updateCaller();
});

function update() {
    var listElemTmplt = `
            <li class="collection-item avatar">
                <i class="material-icons circle {{color}}">person</i>
                <span class="title">{{firstname}} {{lastname}}</span>
                <p> {{{locked}}}
                    {{classlvl}}<br/>
                    Zeit heute: {{{timeToday}}} | Zeit gesamt: {{{timeProject}}}
                </p>
                <span class="secondary-content">
                    <a class="waves-effect waves-circle" href="citizen.php?action=edit&cID={{id}}">
                        <i class="material-icons grey-text text-darken-1" style="margin: 0px 5px;">create</i>
                    </a>
                    <a class="waves-effect waves-circle" href="citizen.php?action=citizeninfo&cID={{id}}" style="margin: 0px 5px;">
                        <i class="material-icons grey-text text-darken-1">reorder</i>
                    </a>
                    <a class="waves-effect waves-circle waves-red" onclick="openModal({{modalid}});" style="margin: 0px 5px;">
                        <i class="material-icons grey-text text-darken-1">delete</i>
                    </a>
                </span>
                <div id="modal{{modalid}}" class="modal">
                    <div class="modal-content black-text">
                        <h4>L&ouml;schen</h4>
                        <p>M&ouml;chtest Du die Person "{{firstname}} {{lastname}}" wirklich l&ouml;schen?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat" onclick="window.openHTTPs = 0;">Abbrechen</a>
                        <a href="citizen.php?action=del&cID={{id}}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
                    </div>
                </div>
            </li>
        `;
    template = Handlebars.compile(listElemTmplt);
    finishedString = [];
    if(requestPage == 0)requestPage = 1;
    $.getJSON("getLists.php?action=citizenInState&search="+searchString+"&page="+requestPage+"&filter="+filter+"&sort="+sort, function (data) {
        if(!(JSON.stringify(oldData) == JSON.stringify(data))) {
            $("ul#citizens").html("");
            data["citizens"].forEach(function (element, index, array) {
                if(element["inState"] == 0) color = "green";
                else if(element["inState"] == 1) color = "red";
                else color = "grey";

                if(element["locked"] == 1 && element["isWanted"] == 1) locked = "<span class=\"red-text\"><b>!</b> Person gesperrt | Fahndung aktiv</span><br/>";
                else if(element["locked"] == 1) locked = "<span class=\"red-text\"><b>!</b> Person gesperrt</span><br/>";
                else if(element["isWanted"] == 1) locked = "<span class=\"red-text\"><b>!</b> Fahndung aktiv</span><br/>";
                else locked = "";

                if(element["classlevel"] <= 13) classlevel = "Klassenstufe " + element["classlevel"];
                else if(element["classlevel"] == 14) classlevel = "Lehrer";
                else if(element["classlevel"] == 15) classlevel = "Visum";
                else classlevel = "Kurier";

                html = template({modalid: modalID, id: element["id"], firstname: element["firstname"], lastname: element["lastname"], locked: locked, classlvl: classlevel, timeToday: element["timeToday"], timeProject: element["timeProject"], color: color});
                $("ul#citizens").append(html);
                modalID++;
            });
            updatePages(data["page"], data["maxpage"]);
            console.log("update");
            oldData = data;
            updateSortnFilter();
        }
    });
    $('.modal-trigger').leanModal();
}

function updateCaller(){
    if(window.openHTTPs == 0) update();
    window.setTimeout("updateCaller()", 1000);
}

function openModal(id) {
    window.openHTTPs = 1000;
    $('#modal'+id).openModal();
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