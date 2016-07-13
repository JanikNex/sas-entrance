/**
 * Created by yanni on 13.07.2016.
 */
var logTmplt = Handlebars.compile(`
    <tr class="{{color}}">
    <td>{{logID}}</td>
    <td>{{infotext}}</td>
    <td>{{timestamp}}</td>
    <td><b>{{name}}</b><br/>{{{scanner}}}</td>
    <td><i class="material-icons {{success_color}}">{{success_icon}}</i></td>
</tr>
`);

$(document).ready(function () {
    getInfo();
    updateCaller();
});

function getInfo() {
    $.getJSON("d_adminControl.php?action=getInfo", null, function(data) {
        var countStudents = data.students.length;
        var countVisum = data.visum.length;
        var countCourrier = data.courrier.length;
        var countAll = countCourrier + countStudents + countVisum;
        $("#iInStateAll").html(countAll);
        $("#iInStateStudents").html(countStudents);
        $("#iInStateVisum").html(countVisum);
        $("#iInStateCourrier").html(countCourrier);
        $("#iLogsToday").html(data.countToday);

        if(countAll != 0) $("#btnKickAll").removeClass("disabled");
        if(countStudents != 0) $("#btnKickStudents").removeClass("disabled");
        if(countCourrier != 0) $("#btnPullCourrier").removeClass("disabled");
        if(countVisum != 0) $("#btnKickVisum").removeClass("disabled");
    });
}

function updateCaller() {
    update();
    window.setTimeout("updateCaller()", 100);
}

function update() {
    filtertext = $("#scanner").val();
    $.getJSON("d_adminControl.php?action=getLogsFiltered&filtertext="+filtertext, null, function(data) {
        $("#logs").html("");
        logstemplate = logTmplt;
        data["logs"].forEach(function (element, index, array) {
            name = element["citizenname"];
            if(element["success"] == 1) {success_color = "green-text"; success_icon = "done";}
            else {success_color = "red-text"; success_icon = "priority_high";}

            if(element["action"] == 0) {color = "green lighten-4"; icon = "navigate_before"; infotext = "->";}
            else if(element["action"] == 1) {color = "red lighten-4"; icon = "navigate_next"; infotext = "<-";}
            else {color = ""; icon = "code"; infotext = "<?>";}

            if(element["success"] == 0) color = "red lighten-2";

            html = logstemplate({icon: icon, color: color, infotext: infotext, name: name, timestamp: element["timestamp"].substring(14), scanner: element["scanner"], success_color: success_color, success_icon: success_icon, logID: element["lID"]});
            $("#logs").append(html);
        });
    })
}