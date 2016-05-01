{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            {if $page.type == ""}
            <div class="col s12 m12">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title"><i class="material-icons circle">import_export</i> Daten exportieren</span>
                        <p>Durch einen klick auf einen der untenstehenden Buttons kann die jeweilige Datei exportiert werden!
                        Bitte beachten Sie, dass dies einige Minuten dauern kann. Betätigen Sie den jeweiligen Button bitte nur einmal!
                        </p>
                    </div>
                    <div class="card-action">
                        <a href="export.php?action=exportClasslist">Klassenliste</a>
                        <a href="export.php?action=printAllPassports">Alle Ausweise</a>
                    </div>
                </div>
            </div>{/if}
            {if $page.type == "waiting"}
            <div class="col s12 m12">
                <div class="card-panel teal white-text">
                    <p class="center-align bolden">Bitte warten....</p><br/>
                    <p>Der Exportvorgang läuft gerade.....</p>
                </div>
            </div>{/if}
            {if $page.type == "classlist"}
                <div class="col s12 m12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title"><i class="material-icons circle green">import_export</i>Klassenliste</span>
                            <p>Die aktuelle Klassenliste mit allen Zeiten aller Schüler wurde unter folgendem Pfad:<br/></p>
                            <p class="bolden">../csv/classlist[Datum]</p>
                            <p>gespeichert!</p>
                        </div>
                        <div class="card-action">
                            <a href="export.php">Zurück</a>
                        </div>
                    </div>
                </div>{/if}
            {if $page.type == "printAllPassports"}
                <div class="col s12 m12">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title"><i class="material-icons circle green">import_export</i>Ausweise</span>
                            <p>Sie können die Ausweise durch einen Rechtsklick und anschließendem Klick auf <b>Speichern unter</b> auf ihrem PC speichern!</p>
                        </div>
                        <div class="card-action">
                            <a href="export.php">Zurück</a>
                        </div>
                    </div>
                </div>{/if}
        </div>
    </div>
</main>
{include file="newEnd.tpl"}