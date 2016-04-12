/**
 * Created by yanni on 10.04.2016.
 */

var oldData = "";
var sort = "ascName";
var filter = "Alle";
var requestPage = 1;
var searchString = "";

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
    $("#filterCurr").html("<i class=\"mdi mdi-filter\"></i> "+filter);
}

function updatePages(currPage, maxPage) {
    if(currPage > maxPage) {
        requestPage = maxPage;
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
    updateSortnFilter();
    updateCaller();
});

function update() {
    var listElemTmplt = `
            <li class="collection-item avatar">
            <i class="material-icons circle {{color}}">person</i>
            <span class="title">{{usrname}}</span>
            <p>{{{prefix}}} {{usrname}} | {{email}}
            </p>
            <span class="secondary-content">
            <a class="waves-effect waves-circle" href="users.php?action=edit&uID={{id}}">
            <i class="material-icons grey-text text-darken-1">create</i>
            </a>
            <a class="waves-effect waves-circle waves-red modal-trigger" onclick="$('#modal{{id}}').openModal();">
            <i class="material-icons grey-text text-darken-1">delete</i>
            </a>
            </span>
            <div id="modal{{id}}" class="modal">
            <div class="modal-content black-text">
            <h4>L&ouml;schen</h4>
            <p>M&ouml;chtest Du den Benutzer "{{usrname}}" wirklich l&ouml;schen?</p>
            </div>
            <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
            <a href="users.php?action=del&vID={{id}}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
            </div>
            </div>
            </li>
        `;
    template = Handlebars.compile(listElemTmplt);
    finishedString = [];
    $.getJSON("getLists.php?action=users&search="+searchString+"&page="+requestPage+"&filter="+filter+"&sort="+sort, function (data) {
        if(!(JSON.stringify(oldData) == JSON.stringify(data))) {
            $("ul#users").html("");
            data["users"].forEach(function (element, index, array) {
                if(element["lvl"] == 0) color = "grey";
                else if(element["lvl"] == 1) color = "green";
                else if(element["lvl"] == 2) color = "blue";
                else if(element["lvl"] == 3) color = "orange";
                else if(element["lvl"] == 4) color = "red";
                html = template({id: element["id"], usrname: element["usrname"], email: element["email"], prefix: element["prefix"], color: color});
                $("ul#users").append(html);
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