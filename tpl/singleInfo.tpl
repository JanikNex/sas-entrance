{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m5">
                <div class="card-panel row">
                    <p class="header indigo-text">Scannen</p>
                    <form action="check.php?action=checkInScan" method="post">
                        <div class="input-field col s12">
                            <i class="prefix mdi mdi-barcode-scan"></i>
                            <label for="barcode">Hier scannen</label>
                            <input id="barcode" required type="text" name="barcode" length="13" autofocus/>
                        </div>
                    </form>
                </div>
                <div class="card-panel row">
                    <p class="header indigo-text">Personsinfo</p>
                    <span class="col s6 bolden">ID:</span><span class="col s6" id="iCID">...</span><br/>
                    <span class="col s6 bolden">Name:</span><span class="col s6" id="iName">...</span><br/>
                    <span class="col s6 bolden">Klassenstufe:</span><span class="col s6" id="iClasslvl">...</span><br/>
                    <span class="col s6 bolden">Zeit heute:</span><span class="col s6" id="iTimeToday">...</span><br/>
                    <span class="col s6 bolden">Zurzeit:</span><span class="col s6" id="iState">...</span><br/>
                    <span class="col s6 bolden">Fahndung:</span><span class="col s6" id="iWanted">...</span><br/>
                    <span class="col s6 bolden">Gesperrt:</span><span class="col s6" id="iLocked">...</span><br/>
                </div>
            </div>
            <div class="col s12 m6 offset-m1">
                <div class="card-panel row">
                    <p class="header indigo-text">Aktionen</p>
                    <a onclick="currInfo()" class="col s12 btn indigo">Infoseite</a><br/><br/>
                    <a onclick="currCheckIn()" class="col s12 btn indigo">Einbuchen</a><br/><br/>
                    <a onclick="currCheckOut()" class="col s12 btn indigo">Ausbuchen</a><br/><br/>
                </div>
                <div class="card-panel row">
                    <p class="header indigo-text">Logs</p>
                    <ul class="collection" id="logs">
                        <li class="collection-item avatar"><i class="material-icons circle grey">code</i> <span class="title">Warte auf Scan...</span> <p> </p> </li>
                    </ul>
                </div>
            </div>
            <div class="col s12 offset-m7 m5">
            </div>
        </div>
    </div>
</main>
<script src="js/singleInfo.js">
</script>
{include file="newEnd.tpl"}