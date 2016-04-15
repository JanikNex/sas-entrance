{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m4 offset-m8">
                <div class="card-panel s12">
                    <!-- Uhrzeit -->
                    <h6>Uhrzeit</h6>
                </div>
            </div>
            <div class="col s12 m8">
                <div class="row">
                    <div class="card-panel col s12 m8">
                        <!-- Staatkontrolle -->
                        <h5>Staatskontrolle</h5>
                        <!-- aktueller Status (geöffnet/geschlossen) und Button zum wechseln des Status (nur wenn Permission vorhanden,
                        weiterleitunng auf "dashboard.php?action=openState" bzw. "closeState" -->
                    </div>
                    <div class="card-panel yellow lighten-2 col s12 m3 offset-m1">
                        <!-- gesamte   -->
                        <h5>  gesamt</h5>
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                    </div>
                    <!-- Zeile 2 -->
                    <div class="card-panel light-green accent-2 col s12 m3">
                        <!--   Besucher -->
                        <h5>  Besucher</h5>
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                    </div>
                    <div class="card-panel light-green accent-2 col s12 m4 offset-m1">
                        <!-- Schueler   -->
                        <h5>  Schüler</h5>
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                    </div>
                    <div class="card-panel light-green accent-2 col s12 m3 offset-m1">
                        <!--   Kurriere -->
                        <h5>  Kurriere</h5>
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                    </div>
                    <!-- Zeile 3 -->
                    <div class="card-panel red col s12 m3">
                        <!--   badCitizens -->
                        <h5>  böse Schüler</h5>
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                    </div>
                    <div class="card-panel red col s12 m4 offset-m1">
                        <!--   aktive Errors -->
                        <h5>  Fehler</h5>
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                    </div>
                    <div class="card-panel red col s12 m3 offset-m1">
                        <!--   aktive Fahndungen -->
                        <h5>  Fahndungen</h5>
                        <p class="white-text">
                            <!-- Zahl -->
                        </p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card-panel">
                    <!-- die letzten 5 Logs aus der Datenbank -->
                    <span class="card-title">Logs<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></span>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/dashboard.js" />
{include file="newEnd.tpl"}