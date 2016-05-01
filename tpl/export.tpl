{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m12" id="normal">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title"><i class="material-icons circle">import_export</i> Daten exportieren</span>
                        <p>Durch einen klick auf einen der untenstehenden Buttons kann die jeweilige Datei exportiert werden!
                        Bitte beachten Sie, dass dies einige Minuten dauern kann. Betätigen Sie den jeweiligen Button bitte nur einmal!
                        </p>
                    </div>
                    <div class="card-action">
                        <a onclick="update('exportClasslist')" href="#">Klassenliste</a>
                        <a onclick="update('exportPassports')" href="#">Alle Ausweise</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m12" id="waiting">
                <div class="card-panel blue-grey white-text">
                    <p class="center-align bolden">Bitte warten....</p><br/>
                    <p>Der Exportvorgang läuft gerade.....</p>
                    <div class="progress">
                        <div id="progressbar" class="determinate" style="width: 0"></div>
                    </div>
                    <div id="progressList">
                        <span> Klasse 05 <span id="class05progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 06 <span id="class06progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 07 <span id="class07progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 08 <span id="class08progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 09 <span id="class09progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 10 <span id="class10progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 11 <span id="class11progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 12 <span id="class12progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 13 <span id="class13progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 14 <span id="class14progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 15 <span id="class15progress"><span class="red-text">Pending...</span></span></span>
                        <span> Klasse 16 <span id="class16progress"><span class="red-text">Pending...</span></span></span>
                    </div>
                </div>
            </div>
            <div class="col s12 m12" id="finishedClasslist">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title"><i class="material-icons circle">import_export</i> Klassenliste</span>
                        <p>Die aktuelle Klassenliste mit allen Zeiten aller Schüler wurde gespeichert!</p>
                    </div>
                    <div class="card-action">
                        <a href="#" id="csvdatei">CSV-Datei</a>
                        <a href="#" onclick="update()">Zurück</a>
                    </div>
                </div>
            </div>
            <div class="col s12 m12" id="finishedPassports">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title"><i class="material-icons circle">import_export</i> Ausweise</span>
                        <p>Ausweise wurden fertig generiert und gespeichert. Bitte unten auf PDF-Datei klicken um die PDF-Datei zu öffnen.</p>
                        <div id="progressList">
                            <a href="#" id="class05pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 5</a><br/><br/>
                            <a href="#" id="class06pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 6</a><br/><br/>
                            <a href="#" id="class07pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 7</a><br/><br/>
                            <a href="#" id="class08pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 8</a><br/><br/>
                            <a href="#" id="class09pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 9</a><br/><br/>
                            <a href="#" id="class10pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 10</a><br/><br/>
                            <a href="#" id="class11pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 11</a><br/><br/>
                            <a href="#" id="class12pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 12</a><br/><br/>
                            <a href="#" id="class13pdflink" class="btn btn-flat blue-grey orange-text">Klassenstufe 13</a><br/><br/>
                            <a href="#" id="class14pdflink" class="btn btn-flat blue-grey orange-text">Lehrer</a><br/><br/>
                            <a href="#" id="class15pdflink" class="btn btn-flat blue-grey orange-text">Visum</a><br/><br/>
                            <a href="#" id="class16pdflink" class="btn btn-flat blue-grey orange-text">Kuriere</a><br/><br/>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="#" onclick="update()">Zurück</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="js/export.js"></script>
{include file="newEnd.tpl"}