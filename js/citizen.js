/**
 * Created by yanni on 10.04.2016.
 */

var filterName = "#filterCurr";
var sortName = "#sortCurr";
var linkList = "getLists.php?action=citizenSimple";
var linkDetail = "citizen.php?action=citizeninfosimple";
var pagesize = 75;
////////////////////////////////////
var listElemTmplt = `
    <tr class="{{color}} clickable" id="entry{{id}}">
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{id}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{{locked}}} {{firstname}} {{lastname}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{classlvl}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{{timeToday}}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{{timeProject}}}</td>
        <td>
            <a class="waves-effect waves-circle" href="citizen.php?action=edit&cID={{id}}">
                <i class="material-icons grey-text text-darken-1" style="margin: 0px 5px;">create</i>
            </a>
            <a class="waves-effect waves-circle waves-red" onclick="openModal({{modalid}})" style="margin: 0px 5px;">
                <i class="material-icons grey-text text-darken-1">delete</i>
            </a>
        </td>
    </tr>
        `;
var listElemTmpltU = `
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{id}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{{locked}}} {{firstname}} {{lastname}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{classlvl}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{{timeToday}}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{{timeProject}}}</td>
        <td>
            <a class="waves-effect waves-circle" href="citizen.php?action=edit&cID={{id}}">
                <i class="material-icons grey-text text-darken-1" style="margin: 0px 5px;">create</i>
            </a>
            <a class="waves-effect waves-circle waves-red" onclick="openModal({{modalid}})" style="margin: 0px 5px;">
                <i class="material-icons grey-text text-darken-1">delete</i>
            </a>
        </td>
        `;
var listModalTmplt = `
            <div id="modal{{modalid}}" class="modal">
                <div class="modal-content black-text">
                    <h4>L&ouml;schen</h4>
                    <p>M&ouml;chtest Du die Person "{{firstname}} {{lastname}}" wirklich l&ouml;schen?</p>
                </div>
                <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat"  onclick="window.openHTTPs = 0;">Abbrechen</a>
                    <a href="citizen.php?action=del&cID={{id}}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
                </div>
            </div>
`;
var template = Handlebars.compile(listElemTmplt);
var templateU = Handlebars.compile(listElemTmpltU);
var templateModal = Handlebars.compile(listModalTmplt);
////////////////////////////////////
var searchString = "";
var currPage = 1;
var reqPage = 1;
var maxPages;
var modalID;
var filter = "Alle";
var sort = "ascName";
var data = [];
var lastData = [];

function updateCaller() {
    if(window.openHTTPs == 0) doUpdate();
    window.setTimeout("updateCaller()", 2500);
}

function doUpdate() {
    fetchList();
    updatePages();
    fetchDetails();
}

function setFilter(afilter) {
    filter = afilter;
    updateSortnFilter();
    doUpdate();
}

function setSort(asort) {
    sort = asort;
    updateSortnFilter();
    doUpdate();
}

function setPage(apage) {
    reqPage = apage;
    doUpdate();
}

function updatePages() {
    if(currPage > maxPages) {
        requestPage = maxPages;
        if(reqPage == 0) reqPage = 1;
    }
    nextPage = parseInt(currPage)+1;
    prevPage = currPage-1;
    p = $("#pages");
    p.html("");
    p.append("<div id='pagesPre' class='col s1'></div>");
    p.append("<div id='pagesSuf' class='col push-s10 s1'></div>");
    p.append("<div id='pagesNum' class='col pull-s1 s10'></div>");

    if(currPage <= 1) $("#pagesPre").append("<li class=\"disabled\"><a><i class=\"material-icons\">chevron_left</i></a></li>");
    else $("#pagesPre").append("<li class=\"waves-effect\"><a onclick=\"setPage("+prevPage+")\"><i class=\"material-icons\">chevron_left</i></a></li>");

    for(i = 1; i <= maxPages; i++) {
        if(i != currPage) {
            $("#pagesNum").append("<li class=\"waves-effect\"><a onclick=\"setPage("+i+")\">"+i+"</a></li>");
        } else {
            $("#pagesNum").append("<li class=\"active indigo\"><a onclick=\"setPage("+i+")\">"+i+"</a></li>");
        }
    }

    if(currPage >= maxPages) $("#pagesSuf").append("<li class=\"disabled\"><a><i class=\"material-icons\">chevron_right</i></a></li>");
    else $("#pagesSuf").append("<li class=\"waves-effect\"><a onclick=\"setPage("+nextPage+")\"><i class=\"material-icons\">chevron_right</i></a></li>");
}

function fetchList() {
    $.getJSON(linkList+"&search="+searchString+"&page="+reqPage+"&filter="+filter+"&sort="+sort, function (json) {
        if(json["size"] > pagesize) size = pagesize; else size = json["size"]
        if(size != data.length) {
            data = [];
            console.log("Crop List ["+data.length+":"+size+"]");
        }
        i = 0;
        json["citizens"].forEach(function (element, index, array) {
            try {
                if (data[i].checksum != element["check"]) {
                    console.log("mm");
                    citizen = {
                        id: element["id"],
                        checksum: element["check"],
                        fname: element["fname"],
                        lname: element["lname"],
                        state: element["st"],
                        timeProject: "...",
                        timeToday: "...",
                        classlvl: "...",
                        locked: "",
                        wanted: "",
                        details: false
                    };
                    data[i] = citizen;
                }
            }catch(err) {
                citizen = {
                    id: element["id"],
                    checksum: element["check"],
                    fname: element["fname"],
                    lname: element["lname"],
                    state: element["st"],
                    timeProject: "...",
                    timeToday: "...",
                    classlvl: "...",
                    locked: "",
                    wanted: ""
                };
                data.push(citizen);
            }
            i++;
        });
        currPage = json["page"];
        maxPages = json["maxpage"];
        refreshList();
    });
}

function fetchDetails() {
    data.forEach(function (element, index, array) {
        if(element != undefined && !element.details) {
            $.getJSON(linkDetail+"&cID=" + element["id"], function (json) {
                if(element.id == json["id"]) {
                    element.locked = json["locked"];
                    element.timeToday = json["timeToday"];
                    element.timeProject = json["timeProject"];
                    element.classlvl = json["classlevel"];
                    element.wanted = json["isWanted"];
                    element.details = true;
                    data[index] = element;
                    refreshSingle(element);
                }
            });
        }
    });
}

function updateSortnFilter() {
    if(sort.startsWith("asc")) {
        thissort = sort.replace("asc","");
        $(sortName).html("<i class=\"mdi mdi-sort-ascending\"></i> "+thissort);
    }
    else {
        thissort = sort.replace("desc","");
        $(sortName).html("<i class=\"mdi mdi-sort-descending\"></i> "+thissort);
    }
    if(filter.startsWith("Stufe")) {
        thisfilter = parseInt(filter.replace("Stufe",""));
        $(filterName).html("<i class=\"mdi mdi-filter\"></i> KS "+thisfilter);
    } else $(filterName).html("<i class=\"mdi mdi-filter\"></i> "+filter);
}

function refreshList() {
    if(JSON.stringify(data) != lastData) {
        console.log("refreshList");
        $("#citizens").html("");
        $("#modals").html("");
        modalID = 0;
        data.forEach(function(element, index, array) {
            if(element.state == 0) color = "green lighten-4";
            else if(element.state == 1) color = "red lighten-4";
            else color = "";

            if(element.locked == 1 && element.wanted == 1) locked = "<span class=\"red-text\"><b>!</b> Person gesperrt | Fahndung aktiv</span><br/>";
            else if(element.locked == 1) locked = "<span class=\"red-text\"><b>!</b> Person gesperrt</span><br/>";
            else if(element.wanted == 1) locked = "<span class=\"red-text\"><b>!</b> Fahndung aktiv</span><br/>";
            else locked = "";

            if(element.classlvl <= 10) classlevel = "Klassenstufe " + element.classlvl;
            else if(element.classlvl <= 13) classlevel = "Oberstufe " + element.classlvl;
            else if(element.classlvl == 14) classlevel = "Lehrer";
            else if(element.classlvl == 15) classlevel = "Visum";
            else if(element.classlvl == 16) classlevel = "Kurier";
            else classlevel = "...";

            html = template({modalid: modalID, id: element.id, firstname: element.fname, lastname: element.lname, locked: locked, classlvl: classlevel, timeToday: element.timeToday, timeProject: element.timeProject, color: color});
            modal = templateModal({modalid: modalID, id: element.id, firstname: element.fname, lastname: element.lname});
            $("#citizens").append(html);
            $("#modals").append(modal);
            modalID++;
        });
        $('.modal-trigger').leanModal();
        lastData = JSON.stringify(data);
    }
}

function refreshSingle(element) {
    console.log("refreshSingle");
    if(element.state == 0) color = "green lighten-4";
    else if(element.state == 1) color = "red lighten-4";
    else color = "";

    if(element.locked == 1 && element.wanted == 1) locked = "<span class=\"red-text\"><b>!</b> Person gesperrt | Fahndung aktiv</span><br/>";
    else if(element.locked == 1) locked = "<span class=\"red-text\"><b>!</b> Person gesperrt</span><br/>";
    else if(element.wanted == 1) locked = "<span class=\"red-text\"><b>!</b> Fahndung aktiv</span><br/>";
    else locked = "";

    if(element.classlvl <= 10) classlevel = "Klassenstufe " + element.classlvl;
    else if(element.classlvl <= 13) classlevel = "Oberstufe " + element.classlvl;
    else if(element.classlvl == 14) classlevel = "Lehrer";
    else if(element.classlvl == 15) classlevel = "Visum";
    else if(element.classlvl == 16) classlevel = "Kurier";
    else classlevel = "...";

    html = templateU({modalid: modalID, id: element.id, firstname: element.fname, lastname: element.lname, locked: locked, classlvl: classlevel, timeToday: element.timeToday, timeProject: element.timeProject, color: color});
    entry = $("#entry"+element.id);
    entry.removeClass();
    entry.addClass(color);
    entry.addClass(" clickable");
    entry.html(html);
    $('.modal-trigger').leanModal();
}

function refreshCaller() {
    refreshList();
    window.setTimeout("refreshCaller()", 1000);
}

function openModal(id) {
    window.openHTTPs = 1000;
    $('#modal'+id).openModal();
}

$(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
    $("#filter").keyup(function () {
        searchString = $(this).val();
        data = [];
        reqPage = 1;
        doUpdate();
    });

    // Initialize collapse button
    $(".button-collapse").sideNav();
    // Initialize collapsible (uncomment the line below if you use the dropdown variation)
    $('.collapsible').collapsible();
    $('.dropdown-button').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrain_width: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 0, // Spacing from edge
        belowOrigin: true, // Displays dropdown below the button
        alignment: 'right' // Displays dropdown with edge aligned to the left of button
    });


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
    refreshList();
});