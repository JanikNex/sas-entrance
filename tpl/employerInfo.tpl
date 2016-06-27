{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m5">
                <div class="card-panel">
                    <h5>Betrieb</h5>
                    <p><b>ID:</b> {$page.employer.emID}</p>
                    <p><b>Art:</b> {$page.employer.kind}</p>
                    <p><b>Name:</b> {$page.employer.name}</p>
                    <p><b>Raum:</b> {$page.employer.room}</p>
                    <h5>Mitarbeiterinformationen</h5>
                    <p><b>Anzahl der Angestellten:</b> {$page.employer.count}</p>
                    <p><b>davon momentan anwesend:</b> {$page.employer.activecount}</p>
                </div>
            </div>
            <div class="col s12 offset-m1 m6">
                <div class="card-panel">
                    <ul class="collection">
                        {loop $page.logs}
                            <!-- Mitarbeiter -> Yannicks Problem -->
                        {/loop}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
{include file="newEnd.tpl"}