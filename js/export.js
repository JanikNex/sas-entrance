/**
 * Created by yanni on 01.05.2016.
 */
var progressWorking = "<div class='orange-text'>Working...</div>"
var progressFinsihed = "<div class='green-text'>Finished</div>"

$(document).ready(function() {
    $("#waiting").hide();
    $("#finishedClasslist").hide();
    $("#finishedPassports").hide();
    $("#progressList").hide();

    window.onhaschanged = update;
});

function update(hash) {
    console.log(hash);
    if(hash == "exportClasslist") exportClass();
    else if(hash == "exportPassports") exportPassport();
    else if(hash == "exportOnePassport") exportOnePassport();
    else if(hash == "exportPassportGroup") exportPassportGroup();
    else if(hash == "exportPassportOfficial") exportPassportOfficial();
    else showNormal();
}

function showNormal() {
    $("#waiting").fadeOut(500);
    $("#finishedClasslist").fadeOut(500, function() {
        $("#normal").fadeIn(500);
    });
}

function exportClass() {
    $("#normal").fadeOut(500, function() {
        $("#waiting").fadeIn(500);
        $.getJSON("export.php?action=exportClasslist", null, function(data) {
            $("#waiting").fadeOut(500, function() {
                $("#finishedClasslist").fadeIn(500);
            });
            $("#csvdatei").attr("href", data["link"]);
        });
    });
}

function exportPassportOfficial() {
    $("#normal").fadeOut(500, function() {
        $("#waiting").fadeIn(500);
        $.getJSON("export.php?action=printPassportWorkers", null, function(data) {
            $("#waiting").fadeOut(500, function() {
                $("#finishedClasslist").fadeIn(500);
            });
        });
    });
}

var currWidth = 0;

function exportPassport() {
    $("#normal").fadeOut(500, function() {
        $("#waiting").fadeIn(500);
        $("#progressList").show();
        $("#class05progress").html(progressWorking);
        $("#class06progress").html(progressWorking);
        $("#class07progress").html(progressWorking);
        $("#class08progress").html(progressWorking);
        $("#class09progress").html(progressWorking);
        $("#class10progress").html(progressWorking);
        $("#class11progress").html(progressWorking);
        $("#class12progress").html(progressWorking);
        $("#class13progress").html(progressWorking);
        $("#class14progress").html(progressWorking);
        $("#class15progress").html(progressWorking);
        $("#class16progress").html(progressWorking);
        $.getJSON("export.php?action=exportPassportGroup&group=5", null, function(data) {
            $("#class05progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class05pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=6", null, function(data) {
            $("#class06progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class06pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=7", null, function(data) {
            $("#class07progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class07pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=8", null, function(data) {
            $("#class08progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class08pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=9", null, function(data) {
            $("#class09progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class09pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=10", null, function(data) {
            $("#class10progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class10pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=11", null, function(data) {
            $("#class11progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class11pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=12", null, function(data) {
            $("#class12progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class12pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=13", null, function(data) {
            $("#class13progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class13pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=14", null, function(data) {
            $("#class14progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class14pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=15", null, function(data) {
            $("#class15progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class15pdflink").attr("href", data["link"]);
        });
        $.getJSON("export.php?action=exportPassportGroup&group=16", null, function(data) {
            $("#class16progress").html(progressFinsihed);
            currWidth += (100/12);
            $("#progressbar").css("width", currWidth+"%");
            $("#class16pdflink").attr("href", data["link"]);
        });
        waitFor100();
    });
}

function waitFor100() {
    if(currWidth >= 95) {
        $("#waiting").fadeOut(500, function() {
            $("#finishedPassports").fadeIn(500);
            $("#pdflink").attr("href", data["link"]);
        });
    } else {
        window.setTimeout(waitFor100, 100);
    }
}