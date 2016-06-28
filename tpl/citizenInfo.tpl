{include file="newbase.tpl" args=$header}
<main>
            <div class="container">
                <div class="row">
                    <div class="col s12 m5">
                        <div class="card-panel">
                            <h5 class="indigo-text text-darken-2 bolden">Person</h5>
                            <p><b>Name:</b> {$page.citizen.firstname} {$page.citizen.lastname}<br/>
                                <b>Klassenstufe:</b>
                                {if $page.citizen.classlevel<=13}{$page.citizen.classlevel}
                                {elseif $page.citizen.classlevel==14}Lehrer
                                {elseif $page.citizen.classlevel==15}Visum
                                {else}Kurier{/if}<br/>
                                <b>Angestellt bei:</b><br/>
                                {loop $page.employer}
                                    <a class="lbtn btn-flat left-align white black-text col s12" href="employer.php?action=info&emID={$emID}">{$emID}: {$name}</a>
                                {/loop}
                                {if $page.citizen.roll[0] != ""}
                                    <b>Rollen:</b> {$page.citizen.roll[0]}<br/>
                                {/if}
                                {if $page.citizen.roll[1] != ""}
                                    <b>Weisungsbefugnisse:</b> {$page.citizen.roll[1]}<br/>
                                {/if}
                            </p>
                            <p><b>Barcode:</b> {$page.citizen.barcode}</p>
                            <div id="bcTarget"></div>
                            {if $header.perm.citizen_info_difference == 1}
                                <p>{loop $page.times}<b>Zeit am {$date}:</b> {$time}<br/>{/loop}</p>
                                <p><b>Gesamt:</b> {$page.timeTotal}</p>
                            {/if}
                            <p><b>Fahndungsstatus:</b>
                                {if $page.citizen.isWanted}<span class="red-text">gesucht</span>
                                {else}<span class="green-text">nicht gesucht</span>
                                {/if}
                            </p>
                            {if $page.citizen.isWanted}
                                {if $header.perm.citizen_tracing_remove == 1}
                                    <a class="btn green col s12" href="citizen.php?action=removeTracing&cID={$page.citizen.id}"><i class="small mdi mdi-lock-open-outline"></i> - Fahndung</a><br/><br/>
                                {/if}
                            {else}
                                {if $header.perm.citizen_tracing_add == 1}
                                    <a class="btn red col s12" href="citizen.php?action=addTracing&cID={$page.citizen.id}"><i class="small mdi mdi-lock-outline"></i> + Fahndung</a><br/><br/>
                                {/if}
                            {/if}
                            {if $header.perm.admin_export == 1}
                                <a class="btn grey col s12" href="export.php?action=printThisPassport&cID={$page.citizen.id}"><i class="small mdi mdi-printer"></i> Ausweis</a><br/><br/>
                            {/if}
                            {if $header.perm.citizen_edit == 1}
                                <p>
                                    <a class="btn red col s2 tooltipped" href="citizen.php?action=addRoll&roll=monarch&cID={$page.citizen.id}"             data-position="top" data-delay="50" data-tooltip="Monarch"><i class="small material-icons">library_add</i></a>
                                    <a class="btn red col s2 tooltipped" href="citizen.php?action=addRoll&roll=government&cID={$page.citizen.id}"          data-position="top" data-delay="50" data-tooltip="Regierung"><i class="small material-icons">library_add</i></a>
                                    <a class="btn red col s2 tooltipped" href="citizen.php?action=addRoll&roll=constitutional&cID={$page.citizen.id}"      data-position="top" data-delay="50" data-tooltip="Verfassungsrat"><i class="small material-icons">library_add</i></a>
                                    <a class="btn orange col s2 tooltipped" href="citizen.php?action=addRoll&roll=parliament&cID={$page.citizen.id}"          data-position="top" data-delay="50" data-tooltip="Parlament"><i class="small material-icons">library_add</i></a>
                                    <a class="btn yellow col s2 tooltipped" href="citizen.php?action=addRoll&roll=justice&cID={$page.citizen.id}"             data-position="top" data-delay="50" data-tooltip="Justiz"><i class="small material-icons">library_add</i></a>
                                    <a class="btn green darken-4 col s2 tooltipped" href="citizen.php?action=addRoll&roll=centralbank&cID={$page.citizen.id}"         data-position="top" data-delay="50" data-tooltip="Zentralbank"><i class="small material-icons">library_add</i></a>
                                    <a class="btn cyan accent-3 col s2 tooltipped" href="citizen.php?action=addRoll&roll=police&cID={$page.citizen.id}"              data-position="top" data-delay="50" data-tooltip="Polizei"><i class="small material-icons">library_add</i></a>
                                    <a class="btn cyan lighten-4 col s2 tooltipped" href="citizen.php?action=addRoll&roll=borderguard&cID={$page.citizen.id}"         data-position="top" data-delay="50" data-tooltip="Grenzschutz"><i class="small material-icons">library_add</i></a>
                                    <a class="btn grey col s2 tooltipped" href="citizen.php?action=addRoll&roll=factoryinspectorare&cID={$page.citizen.id}" data-position="top" data-delay="50" data-tooltip="Gewerbeaufsicht"><i class="small material-icons">library_add</i></a>
                                    <a class="btn light-green lighten-1 col s2 tooltipped" href="citizen.php?action=addRoll&roll=warehouse&cID={$page.citizen.id}"           data-position="top" data-delay="50" data-tooltip="Warenlager"><i class="small material-icons">library_add</i></a>
                                    <a class="btn white black-text col s2 tooltipped" href="citizen.php?action=addRoll&roll=orga&cID={$page.citizen.id}"              data-position="top" data-delay="50" data-tooltip="Orga"><i class="small material-icons">library_add</i></a>
                                </p><br/><br/><br/>
                                <p>
                                    <a class="btn red col s2 tooltipped" href="citizen.php?action=removeRoll&roll=monarch&cID={$page.citizen.id}"          data-position="bottom" data-delay="50" data-tooltip="Monarch"><i class="small material-icons">delete</i></a>
                                    <a class="btn red col s2 tooltipped" href="citizen.php?action=removeRoll&roll=government&cID={$page.citizen.id}"       data-position="bottom" data-delay="50" data-tooltip="Regierung"><i class="small material-icons">delete</i></a>
                                    <a class="btn red col s2 tooltipped" href="citizen.php?action=removeRoll&roll=constitutional&cID={$page.citizen.id}"   data-position="bottom" data-delay="50" data-tooltip="Verfassungsrat"><i class="small material-icons">delete</i></a>
                                    <a class="btn orange col s2 tooltipped" href="citizen.php?action=removeRoll&roll=parliament&cID={$page.citizen.id}"       data-position="bottom" data-delay="50" data-tooltip="Parlament"><i class="small material-icons">delete</i></a>
                                    <a class="btn yellow col s2 tooltipped" href="citizen.php?action=removeRoll&roll=justice&cID={$page.citizen.id}"          data-position="bottom" data-delay="50" data-tooltip="Justiz"><i class="small material-icons">delete</i></a>
                                    <a class="btn green darken-4 col s2 tooltipped" href="citizen.php?action=removeRoll&roll=centralbank&cID={$page.citizen.id}"      data-position="bottom" data-delay="50" data-tooltip="Zentralbank"><i class="small material-icons">delete</i></a>
                                    <a class="btn cyan accent-3 col s2 tooltipped" href="citizen.php?action=removeRoll&roll=police&cID={$page.citizen.id}"           data-position="bottom" data-delay="50" data-tooltip="Polizei"><i class="small material-icons">delete</i></a>
                                    <a class="btn cyan lighten-4 col s2 tooltipped" href="citizen.php?action=removeRoll&roll=borderguard&cID={$page.citizen.id}"      data-position="bottom" data-delay="50" data-tooltip="Grenzschutz"><i class="small material-icons">delete</i></a>
                                    <a class="btn grey col s2 tooltipped" href="citizen.php?action=removeRoll&roll=factoryinspectorare&cID={$page.citizen.id}" data-position="bottom" data-delay="50" data-tooltip="Gewerbeaufsicht"><i class="small material-icons">delete</i></a>
                                    <a class="btn light-green lighten-1 col s2 tooltipped" href="citizen.php?action=removeRoll&roll=warehouse&cID={$page.citizen.id}"        data-position="bottom" data-delay="50" data-tooltip="Warenlager"><i class="small material-icons">delete</i></a>
                                    <a class="btn white black-text col s2 tooltipped" href="citizen.php?action=removeRoll&roll=orga&cID={$page.citizen.id}"           data-position="bottom" data-delay="50" data-tooltip="Orga"><i class="small material-icons">delete</i></a>
                                </p>
                            {/if}
                            <br/><br/><br/>
                        </div>
                    </div>
                    <div class="col s12 offset-m1 m6">
                        <div class="card-panel">
                            <ul class="collection">
                                {loop $page.logs}
                                <li class="collection-item avatar">
                                    {if $action == 0}
                                        <i class="material-icons circle green">navigate_before</i>
                                        <span class="title">Staat betreten</span>
                                        <p>{$timestamp}<br/>
                                        {if $_.page.citizen.classlevel == 16}
                                            Außerhalb des Staates: {$timeSinceLast}<br/>
                                        {/if}
                                            <img src="barcode-scan.svg" height="16px" /> {$scanner}
                                        </p>
                                    {elseif $action == 2}
                                        <i class="material-icons circle grey">code</i>
                                        <span class="title">Ignoriert</span>
                                        <p>{$timestamp}<br/>
                                            <img src="barcode-scan.svg" height="16px" /> {$scanner}
                                        </p>
                                    {else}
                                        <i class="material-icons circle red">navigate_next</i>
                                        <span class="title">Staat verlassen</span>
                                        <p>{$timestamp}<br/>
                                        {if $_.page.citizen.classlevel != 16}
                                            Im Staat: {$timeSinceLast}<br/>
                                        {/if}
                                            <img src="barcode-scan.svg" height="16px" /> {$scanner}
                                        </p>
                                    {/if}
                                    <i class="material-icons secondary-content{if $success == 0} red-text{/if}">{if $success == 1}done{else}priority_high{/if}</i>
                                </li>
                                {/loop}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
<script>
    jQuery(document).ready(function($) {
        $("#bcTarget").barcode("{$page.citizen.barcode}", "codabar");
    });
</script>
{include file="newEnd.tpl"}