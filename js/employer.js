/**
 * Created by Janik Rapp on 27.06.2016.
 */

var linkList = "getLists.php?action=employer";
var pagesize = 75;
////////////////////////////////////
var listElemTmplt = `
    <tr class="{{color}} clickable" id="entry{{id}}">
        <td onclick="window.location = 'employer.php?action=info&emID={{id}}'">{{id}}</td>
        <td onclick="window.location = 'employer.php?action=info&emID={{id}}'">{{name}}</td>
        <td onclick="window.location = 'employer.php?action=info&emID={{id}}'">{{kind}}</td>
        <td onclick="window.location = 'employer.php?action=info&emID={{id}}'">{{room}}</td>
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

function updateCaller() {
    if(window.openHTTPs == 0) doUpdate();
    window.setTimeout("updateCaller()", 2500);
}

function doUpdate() {
    fetchList();
    updatePages();
}

function setPage(apage) {
    reqPage = apage;
    data = [];
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
    $.getJSON(linkList+"&search="+searchString+"&page="+reqPage, function (json) {
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
                        kind: element["kind"],
                        name: element["name"],
                        room: element["room"],
                        details: true
                    };
                    data[i] = citizen;
                }
            }catch(err) {
                citizen = {
                    id: element["id"],
                    checksum: element["check"],
                    kind: element["kind"],
                    name: element["name"],
                    room: element["room"],
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

function refreshList() {
    if(JSON.stringify(data) != lastData) {
        console.log("refreshList");
        $("#employer").html("");
        $("#modals").html("");
        modalID = 0;
        data.forEach(function(element, index, array) {

            html = template({modalid: modalID, id: element.id, name: element.name, kind: element.kind, room: element.room});
            $("#employer").append(html);
            modalID++;
        });
        $('.modal-trigger').leanModal();
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
    updateCaller();
    refreshList();
});
