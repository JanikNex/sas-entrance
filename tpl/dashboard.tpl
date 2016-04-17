{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m4 offset-m8">
                <div class="card-panel s12">
                    <!-- Uhrzeit -->
                    <p class="center-align"><b>Zeit</b></p>
                </div>
            </div>
            <div class="col s12 m8">
                <div class="row">
                    <div class="card-panel col s12 m8">
                        <!-- Staatkontrolle -->
                        <p class="center-align"><b>Staatskontrolle</b></p>
                        <!-- aktueller Status (geöffnet/geschlossen) und Button zum wechseln des Status (nur wenn Permission vorhanden,
                        weiterleitunng auf "dashboard.php?action=openState" bzw. "closeState" -->
                    </div>
                    <div class="card-panel yellow lighten-2 col s12 m3 offset-m1">
                        <!-- gesamte   -->
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                        <p class="center-align"><b>Gesamt</b></p>
                    </div>
                    <!-- Zeile 2 -->
                    <div class="card-panel light-green accent-2 col s12 m3">
                        <!--   Besucher -->
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                        <p class="center-align"><b>Besucher</b></p>
                    </div>
                    <div class="card-panel light-green accent-2 col s12 m4 offset-m1">
                        <!-- Schueler   -->
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                        <p class="center-align"><b>Schüler</b></p>
                    </div>
                    <div class="card-panel light-green accent-2 col s12 m3 offset-m1">
                        <!--   Kurriere -->
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                        <p class="center-align"><b>Kurriere</b></p>
                    </div>
                    <!-- Zeile 3 -->
                    <div class="card-panel red col s12 m3">
                        <!--   badCitizens -->
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                        <p class="center-align"><b>Böse Schüler</b></p>
                    </div>
                    <div class="card-panel red col s12 m4 offset-m1">
                        <!--   aktive Errors -->
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                        <p class="center-align"><b>Fehler</b></p>
                    </div>
                    <div class="card-panel red col s12 m3 offset-m1">
                        <!--   aktive Fahndungen -->
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                        <p class="center-align"><b>Fahndungen</b></p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card-panel">
                    <!-- die letzten 5 Logs aus der Datenbank -->
                    <p class="center-align"><b>Logs</b></p>
                    <span><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></span>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/dashboard.js" />
{include file="newEnd.tpl"}