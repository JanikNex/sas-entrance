{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m5">
                <div class="card-panel row">
                    <p class="header indigo-text">Info</p>
                    <span class="col s6 bolden">Personen im Staat:</span><span class="col s6" id="iInStateAll">...</span><br/>
                    <span class="col s6 bolden">- Schüler:</span><span class="col s6" id="iInStateStudents">...</span><br/>
                    <span class="col s6 bolden">- Visum:</span><span class="col s6" id="iInStateVisum">...</span><br/>
                    <span class="col s6 bolden">- Kurier:</span><span class="col s6" id="iInStateCourrier">...</span><br/>
                    <span class="col s6 bolden">Buchungen heute:</span><span class="col s6" id="iLogsToday">...</span><br/>
                </div>
                <div class="card-panel row">
                    <p class="header indigo-text">Aktionen</p>
                    <a id="btnKickAll" onclick="kickAll()" class="col s12 btn indigo">Alle ausbuchen</a><br/><br/>
                    <a id="btnKickStudents" onclick="kickStudents()" class="col s12 btn indigo">Schüler ausbuchen</a><br/><br/>
                    <a id="btnKickVisum" onclick="kickVisum()" class="col s12 btn indigo">Visa ausbuchen</a><br/><br/>
                    <a id="btnPullCourrier" onclick="pullCourrier()" class="col s12 btn indigo">Kuriere einbuchen</a><br/><br/>
                </div>
            </div>
            <div class="col s12 m6 offset-m1">
                <div class="card-panel row">
                    <p class="header indigo-text">Fortschritt</p>
                    <div class="progress">
                        <div id="progressbar" class="determinate" style="width: 0"></div>
                    </div>
                    <span id="progressText">Warte auf Start...</span>
                </div>
            </div>
            <div class="col s12 offset-m7 m5">
            </div>
        </div>
    </div>
</main>
<script src="js/kick.js">
</script>
{include file="newEnd.tpl"}