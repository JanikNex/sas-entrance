{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="card-panel col s12 m12 l5 offset-l4">
                <!-- Uhrzeit -->
                <span class="card-title">Uhrzeit</span>
            </div>
        </div>
        <div class="row">
            <div class="card-panel col s12 m12 l5">
                <!-- Staatkontrolle -->
                <span class="card-title">Staatskontrolle</span>
                <!-- aktueller Status (geöffnet/geschlossen) und Button zum wechseln des Status (nur wenn Permission vorhanden,
                weiterleitunng auf "dashboard.php?action=openState" bzw. "closeState" -->
            </div>
            <div class="card-panel yellow lighten-2 col s12 m12 l5 offset-l2">
                <!-- gesamte Anzahl -->
                <span class="card-title">Anzahl gesamt</span>
                <p class="white-text">
                    <!-- Zahl -->
                </p>
            </div>
            <div class="card-panel col s12 m12 l5 offset-l3">
                <!-- die letzten 5 Logs aus der Datenbank -->
                <span class="card-title">Logs</span>
            </div>
        </div>
        <div class="row">
            <div class="card-panel light-green accent-2 col s12 m12 l5">
                <!-- Schueler Anzahl -->
                <span class="card-title">Anzahl Schüler</span>
                <p class="white-text">
                    <!-- Zahl -->
                </p>
            </div>
            <div class="card-panel light-green accent-2 col s12 m12 l5 offset-l1">
                <!-- Anzahl Besucher -->
                <span class="card-title">Anzahl Besucher</span>
                <p class="white-text">
                    <!-- Zahl -->
                </p>
            </div>
            <div class="card-panel light-green accent-2 col s12 m12 l5 offset-l2">
                <!-- Anzahl Kurriere -->
                <span class="card-title">Anzahl Kurriere</span>
                <p class="white-text">
                    <!-- Zahl -->
                </p>
            </div>
        </div>
        <div class="row">
            <div class="card-panel red col s12 m12 l5">
                <!-- Anzahl badCitizens -->
                <span class="card-title">Anzahl böse Schüler</span>
                <p class="white-text">
                    <!-- Zahl -->
                </p>
            </div>
            <div class="card-panel red col s12 m12 l5 offset-l1">
                <!-- Anzahl aktive Errors -->
                <span class="card-title">Anzahl Fehler</span>
                <p class="white-text">
                    <!-- Zahl -->
                </p>
            </div>
            <div class="card-panel red col s12 m12 l5 offset-l2">
                <!-- Anzahl aktive Fahndungen -->
                <span class="card-title">Anzahl Fahndungen</span>
                <p class="white-text">
                    <!-- Zahl -->
                </p>
            </div>
        </div>
    </div>
</main>
<script src="js/dashboard.js" />
{include file="newEnd.tpl"}