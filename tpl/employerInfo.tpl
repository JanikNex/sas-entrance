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
                    <p><b>Anzahl der Angestellten:</b> {$page.employer.staffCount}</p>
                    <p><b>davon momentan anwesend:</b> {$page.employer.activeStaffCount}</p>
                    <h5>Betriebsleitung</h5>
                    {loop $page.chief}
                    <p><b>Name:</b> {$firstname} {$lastname}<br/>
                    <b>Klassenstufe:</b>
                        {if $classlevel<=13}{$classlevel}
                        {elseif $classlevel==14}Lehrer
                        {elseif $classlevel==15}Visum
                        {else}Kurier{/if}
                        <br/>
                    {if $classlevel != 14}
                    <b>Status: </b>
                        {if $inState == 0}<span class="green-text">Anwesend</span>
                        {else}<span class="red-text">Nicht Anwesend</span>
                        {/if}
                    </p>
                    {/if}
                    {/loop}
                </div>
            </div>
            <div class="col s12 offset-m1 m6">
                <div class="card-panel">
                    <ul class="collection">
                        {loop $page.employees}
                            <li class="collection-item avatar clickable" onclick="window.location = 'citizen.php?action=citizeninfo&cID={$id}'">
                                <i class="material-icons circle grey">perm_identity</i>
                                <span class="title">{$firstname} {$lastname}</span>
                                <p>Klassenstufe: {$classlevel}<br/>
                                    {if $classlevel != 14}
                                        Status:
                                        {if $inState == 0}<span class="green-text">Anwesend</span>
                                        {else}<span class="red-text">Nicht Anwesend</span>
                                        {/if}
                                    {/if}
                                </p>
                            </li>
                        {/loop}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
{include file="newEnd.tpl"}