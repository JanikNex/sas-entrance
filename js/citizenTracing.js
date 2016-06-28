/**
 * Created by yanni on 10.04.2016.
 */

var filterName = "#filterCurr";
var sortName = "#sortCurr";
var linkList = "getLists.php?action=tracings";
var pagesize = 75;
////////////////////////////////////
var listElemTmplt = `
    <tr class="{{color}} clickable" id="entry{{id}}">
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{tID}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{{timestamp}}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{citizenName}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{citizenClassLevel}}</td>
        <td onclick="window.location = 'citizen.php?action=citizeninfo&cID={{id}}'">{{{prefix}}} {{username}}</td>
    </tr>
        `;
var template = Handlebars.compile(listElemTmplt);
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

$(document).ready(function() {
    $("#search").hide();
});

function updateCaller() {
    if(window.openHTTPs == 0) doUpdate();
    window.setTimeout("updateCaller()", 2500);
}

function doUpdate() {
    fetchList();
    updatePages();
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
        json["tracings"].forEach(function (element, index, array) {
            try {
                if (data[i].checksum != element["check"]) {
                    console.log("mm");
                    citizen = {
                        tID: element["tID"],
                        cID: element["cID"],
                        checksum: element["check"],
                        citizenName: element["citizenName"],
                        citizenClassLevel: element["citizenClassLevel"],
                        tracingStatus: element["tracingStatus"],
                        timestamp: element["timestamp"],
                        username: element["usrname"],
                        prefix: element["prefix"],
                        details: true
                    };
                    data[i] = citizen;
                }
            }catch(err) {
                citizen = {
                    tID: element["tID"],
                    cID: element["cID"],
                    checksum: element["check"],
                    citizenName: element["citizenName"],
                    citizenClassLevel: element["citizenClassLevel"],
                    tracingStatus: element["tracingStatus"],
                    timestamp: element["timestamp"],
                    username: element["usrname"],
                    prefix: element["prefix"],
                    details: true
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
        data.forEach(function(element, index, array) {
            if(element.tracingStatus == 1) element.color = "green lighten-4";
            else if(element.tracingStatus == 0) element.color = "red lighten-4";
            else element.color = "";

            html = template(element);
            $("#citizens").append(html);
        });
        lastData = JSON.stringify(data);
    }
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