<?php
    require_once 'libs/dwoo/lib/Dwoo/Autoloader.php'; //Dwoo Laden
    require_once 'classes/PDO_MYSQL.php';
    require_once 'classes/User.php';
    require_once 'classes/Util.php';
    Dwoo\Autoloader::register();
    $dwoo = new Dwoo\Core();
    $user = \Entrance\Util::checkSession();
    $pgdata = \Entrance\Util::getEditorPageDataStub("Einbuchen", $user);
    $pgdata["args"] = $pgdata["header"];
    $pgdata["args"]["switchmode"] = 1;
    echo $dwoo->get("tpl/newbase.tpl", $pgdata);
?>
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <div class="card-panel row">
                    <form>
                        <div class="input-field col s11">
                            <i class="prefix mdi mdi-barcode-scan"></i>
                            <label for="barcode">Hier scannen</label>
                            <input id="barcode" type="text" name="barcode" length="13" autofocus/>
                        </div>
                        <a class="btn-flat waves-effect waves-light col s1" style="margin-top:15px;" onclick="onSend()">
                            <i class="material-icons right">send</i>
                        </a>
                    </form>
                    <div class="col s12">
                        <p id="scanOK" class="green-text">
                            <img src="checkOk.png" height="16px"> Scan Erfolgreich.
                        </p>
                        <p id="scanFail" class="red-text">
                            <img src="checkFail.png" height="16px"> Scan Fehlgeschlagen. Achtung, Person ist jetzt geperrt.<br/>
                            <span id="errCode"></span>
                            <span id="err1">Error@CheckIn | AlreadyCheckedIn</span>
                            <span id="err2">Error@CheckOut | AlreadyCheckedOut</span>
                            <span id="err3">Error@CheckOut | NoCheckOutYesterday</span>
                            <span id="err4">Error@CheckIn | CitizenLocked</span>
                            <span id="err5">Error@CheckOut | CitizenLocked</span>
                            <span id="err6">Error@CheckIn | CitizenWanted</span>
                            <span id="err7">Error@CheckOut | CitizenWanted</span>
                            <span id="err8">Error@CheckIn | NoCitizenFound</span>
                            <span id="err9">Error@CheckOut | NoCitizenFound</span>
                        </p>
                        <p id="scanClosed" class="red-text">
                            Schlopolis ist momentan <b>geschlossen</b>! Keine Buchungsvorgänge möglich.
                        </p>
                        <p id="scanWanted" class="red-text">
                            Diese Person wird polizeilich <b>gesucht</b>! Übergeben Sie diese bitte umgehend der Polizei!
                        </p>
                        <div id="modalTime" class="modal">
                            <div class="modal-content black-text">
                                <h4>Person hat nicht genug Zeit.</h4>
                                <p>Die Person <span class="bolden" id="name"></span> hat heute erst <span id="time" class="bolden"></span> im Staat verbracht. <br/>
                                wirklich auschecken?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat red-text" onclick="reset()">Nicht Auschecken</a>
                                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat green-text" onclick="forceCheckOut()">Trotzdem Auschecken</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 offset-m1 m5">
                <div class="card-panel">
                    <h5>Person</h5>
                    <p class="red-text" id="isLocked"><b>!</b> Person gesperrt</p><br/>
                    <p><b>Name:</b>
                        <span id="iname"></span></p>
                    <p><b>Klassenstufe:</b>
                        <span id="classlvl"></span>
                    </p>
                </div>
            </div>
            <div class="col s12 offset-m7 m5">
                <div class="card-panel">
                    <ul class="collection" id="logs">
                        <li class="collection-item avatar">
                            <i class="material-icons circle grey">code</i>
                            <span class="title">Warte auf Start</span>
                            <p>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/check.js"></script>
<script>
    $(document).ready(function() {
        $(".dropdown-button").dropdown();
        $('.modal-trigger').leanModal();

        // Initialize collapse button
        $(".button-collapse").sideNav();
        // Initialize collapsible (uncomment the line below if you use the dropdown variation)
        $('.collapsible').collapsible();
        $('input[type=text]').on('keydown', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                onSend();
            }
        });
        prepare()
    });
</script>
</body>
</html>