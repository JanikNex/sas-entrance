{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m4 offset-m8">
                <div class="card-panel s12 no-padding">
                    <!-- Uhrzeit -->
                    <p class="center" style="font-family: monospace; font-weight: bold; font-size: 35px;" id="time">

                    </p>
                </div>
            </div>
            <div class="col s12 m8">
                <div class="row">
                    <div class="card-panel col s12 m8">
                        <!-- Staatkontrolle -->
                        <p class="header indigo-text">Staatskontrolle</p>
                        <p id="stateState"></p>
                        <p>
                            {if $header.perm.admin_state_open == 1}
                                <a id="btnopen" class="btn waves-light green" onclick="openState()"><i class="mdi mdi-play"></i> Öffnen</a>
                            {/if}
                            {if $header.perm.admin_state_close == 1}
                                <a id="btnclose" class="btn waves-light red" onclick="closeState()"><i class="mdi mdi-pause"></i> Schließen</a>
                            {/if}
                        </p>
                    </div>
                    <div class="card-panel yellow lighten-2 col s12 m3 offset-m1">
                        <!-- gesamte   -->
                        <p class="black-text center" style="font-family: monospace; font-size: 30px;" id="all">
                        </p>
                        <p class="center-align"><b>Gesamt</b></p>
                    </div>
                    <!-- Zeile 2 -->
                    <div class="card-panel light-green accent-2 col s12 m3">
                        <!--   Besucher -->
                        <p class="black-text center" style="font-family: monospace; font-size: 30px;" id="visitors">
                        </p>
                        <p class="center-align"><b>Besucher</b></p>
                    </div>
                    <div class="card-panel light-green accent-2 col s12 m4 offset-m1">
                        <!-- Schueler   -->
                        <p class="black-text center" style="font-family: monospace; font-size: 30px;" id="students">
                        </p>
                        <p class="center-align"><b>Schüler</b></p>
                    </div>
                    <div class="card-panel light-green accent-2 col s12 m3 offset-m1">
                        <!--   Kurriere -->
                        <p class="black-text center" style="font-family: monospace; font-size: 30px;" id="courriers">
                        </p>
                        <p class="center-align"><b>Kurriere</b></p>
                    </div>
                    <!-- Zeile 3 -->
                    <div class="card-panel red col s12 m3">
                        <!--   badCitizens -->
                        <p class="white-text center" style="font-family: monospace; font-size: 30px;" id="badcitizen">
                        </p>
                        <p class="center-align"><b>Böse Schüler</b></p>
                    </div>
                    <div class="card-panel red col s12 m4 offset-m1">
                        <!--   aktive Errors -->
                        <p class="white-text center" style="font-family: monospace; font-size: 30px;" id="errors">
                        </p>
                        <p class="center-align"><b>Fehler</b></p>
                    </div>
                    <div class="card-panel red col s12 m3 offset-m1">
                        <!--   aktive Fahndungen -->
                        <p class="white-text center" style="font-family: monospace; font-size: 30px;" id="tracings">
                        </p>
                        <p class="center-align"><b>Fahndungen</b></p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card-panel">
                    <!-- die letzten 5 Logs aus der Datenbank -->
                    <p class="header indigo-text">Logs</p>
                    <ul class="collection" id="logs">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/dashboard.js" />
{include file="newEnd.tpl"}