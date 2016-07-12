/**
 * Created by yanni on 12.07.2016.
 */

var students = [];
var visum = [];
var courrier = [];

var progressMax = 0;
var currProgress = 0;

$(document).ready(function () {
    $("#btnKickAll").addClass("disabled");
    $("#btnKickStudents").addClass("disabled");
    $("#btnKickVisum").addClass("disabled");
    $("#btnPullCourrier").addClass("disabled");

    getInfo();
});

function updateProgressbar() {
    var percentage = (currProgress / progressMax) * 100
    $("#progressbar").css("width", percentage+"%");
    if(percentage < 100) $("#progressText").html(currProgress+"/"+progressMax+" wird ausgebucht...");
    else {
        $("#progressText").html(currProgress+"/"+progressMax+": Fertig.");
        getInfo();
    }
}

function getInfo() {
    $.getJSON("d_kick.php?action=getInfo", null, function(data) {
        students = data.students;
        courrier = data.courrier;
        visum = data.visum
        var countStudents = data.students.length;
        var countVisum = data.visum.length;
        var countCourrier = data.courrier.length;
        var countAll = countCourrier + countStudents + countVisum;
        $("#iInStateAll").html(countAll);
        $("#iInStateStudents").html(countStudents);
        $("#iInStateVisum").html(countVisum);
        $("#iInStateCourrier").html(countCourrier);

        if(countAll != 0) $("#btnKickAll").removeClass("disabled");
        if(countStudents != 0) $("#btnKickStudents").removeClass("disabled");
        if(countCourrier != 0) $("#btnPullCourrier").removeClass("disabled");
        if(countVisum != 0) $("#btnKickVisum").removeClass("disabled");
    });
}

function kickStudents() {
    progressMax = students.length;
    currProgress = 0;
    updateProgressbar();
    students.forEach(function(element, index, array) {
        $.getJSON("d_kick.php?action=doKick&cID="+element.id, null, function(data) {
            currProgress += 1;
            updateProgressbar();
        });
    });
}

function kickVisum() {
    progressMax = visum.length;
    currProgress = 0;
    updateProgressbar();
    visum.forEach(function(element, index, array) {
        $.getJSON("d_kick.php?action=doKick&cID="+element.id, null, function(data) {
            currProgress += 1;
            updateProgressbar();
        });
    });
}

function pullCourrier() {
    progressMax = courrier.length;
    currProgress = 0;
    updateProgressbar();
    courrier.forEach(function(element, index, array) {
        $.getJSON("d_kick.php?action=doKick&cID="+element.id, null, function(data) {
            currProgress += 1;
            updateProgressbar();
        });
    });
}

function kickAll() {
    progressMax = courrier.length + students.length + visum.length;
    currProgress = 0;
    updateProgressbar();
    courrier.forEach(function(element, index, array) {
        $.getJSON("d_kick.php?action=doKick&cID="+element.id, null, function(data) {
            currProgress += 1;
            updateProgressbar();
        });
    });
    visum.forEach(function(element, index, array) {
        $.getJSON("d_kick.php?action=doKick&cID="+element.id, null, function(data) {
            currProgress += 1;
            updateProgressbar();
        });
    });
    students.forEach(function(element, index, array) {
        $.getJSON("d_kick.php?action=doKick&cID="+element.id, null, function(data) {
            currProgress += 1;
            updateProgressbar();
        });
    });
}