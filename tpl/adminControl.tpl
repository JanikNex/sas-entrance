{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m4">
                <div class="card-panel row">
                    <p class="header indigo-text">Optionen</p>
                    <div class="input-field col s11">
                        <label for="scanner">Scanner</label>
                        <input id="scanner" type="text" name="scanner" autofocus/>
                    </div>
                </div>
                <div class="card-panel row">
                    <p class="header indigo-text">Aktionen</p>
                </div>
            </div>
            <div class="col s12 m7 offset-m1">
                <div class="card-panel row">
                    <p class="header indigo-text">Info</p>
                    <span class="col s6 bolden">Personen im Staat:</span><span class="col s6" id="iInStateAll">...</span><br/>
                    <span class="col s6 bolden">- Schüler:</span><span class="col s6" id="iInStateStudents">...</span><br/>
                    <span class="col s6 bolden">- Visum:</span><span class="col s6" id="iInStateVisum">...</span><br/>
                    <span class="col s6 bolden">- Kurier:</span><span class="col s6" id="iInStateCourrier">...</span><br/>
                    <span class="col s6 bolden">Buchungen heute:</span><span class="col s6" id="iLogsToday">...</span><br/>
                </div>
                <div class="card-panel row">
                    <p class="header indigo-text">Buchungen</p>
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th><-></th>
                            <th>Zeit</th>
                            <th>Person</th>
                            <th>Info</th>
                        </tr>
                        </thead>
                        <tbody id="logs">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col s12 offset-m7 m5">
            </div>
        </div>
    </div>
</main>
<script src="js/adminControl.js">
</script>
{include file="newEnd.tpl"}