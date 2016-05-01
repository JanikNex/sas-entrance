{include file="newbase.tpl" args=$header}
<main>
            <div class="container">
                <div class="row">
                    <div class="col s12 m5">
                        <div class="card-panel">
                            <h5>Person</h5>
                            <p><b>Name:</b> {$page.citizen.firstname} {$page.citizen.lastname}</p>
                            {if $page.citizen.age <= 100}
                            <p><b>Geburtstag:</b> {$page.citizen.birthdayNice}</p>
                            {/if}
                            <p><b>Klassenstufe:</b>
                                {if $page.citizen.classlevel<=13}{$page.citizen.classlevel}
                                {elseif $page.citizen.classlevel==14}Lehrer
                                {elseif $page.citizen.classlevel==15}Visum
                                {else}Kurier{/if}
                            </p>
                            {if $page.citizen.roll != ""}
                                <p><b>Rollen:</b> {$page.citizen.roll}</p>
                            {/if}
                            <p><b>Barcode:</b> {$page.citizen.barcode}</p>
                            <div id="bcTarget"></div>
                            {if $header.perm.citizen_info_difference == 1}
                                {loop $page.times}<p><b>Zeit am {$date}:</b> {$time}</p>{/loop}
                                <p><b>Gesamt:</b> {$page.timeTotal}</p>
                            {/if}
                            <p><b>Fahndungsstatus:</b>
                                {if $page.citizen.isWanted}<span class="red-text">gesucht</span>
                                {else}<span class="green-text">nicht gesucht</span>
                                {/if}
                            </p>
                            {if $page.citizen.isWanted}
                                {if $header.perm.citizen_tracing_remove == 1}
                                    <a class="btn green" href="citizen.php?action=removeTracing&cID={$page.citizen.id}"><i class="small material-icons">lock_open</i>Fahndung entfernen</a>
                                {/if}
                            {else}
                                {if $header.perm.citizen_tracing_add == 1}
                                    <a class="btn red" href="citizen.php?action=addTracing&cID={$page.citizen.id}"><i class="small material-icons">lock_outline</i>Fahndung hinzufügen</a>
                                {/if}
                            {/if}<br/>
                            {if $header.perm.admin_export == 1}
                                <a class="btn grey" href="export.php?action=printThisPassport&cID={$page.citizen.id}"><i class="small material-icons">print</i>Ausweis ausdrucken</a>
                            {/if}
                            {if $header.perm.citizen_edit == 1}
                                <p>
                                    <a class="btn orange col s1" href="citizen.php?action=addRoll&roll=orga&cID={$page.citizen.id}"><i class="small material-icons">library_add</i>Orga</a>
                                    <a class="btn blue col s1" href="citizen.php?action=addRoll&roll=police&cID={$page.citizen.id}"><i class="small material-icons">library_add</i>Police</a>
                                    <a class="btn pink col s1" href="citizen.php?action=addRoll&roll=parliament&cID={$page.citizen.id}"><i class="small material-icons">library_add</i>Parliament</a>
                                </p>
                                <p>
                                    <a class="btn orange col s1" href="citizen.php?action=removeRoll&roll=orga&cID={$page.citizen.id}"><i class="small material-icons">delete</i>Orga</a>
                                    <a class="btn blue col s1" href="citizen.php?action=removeRoll&roll=police&cID={$page.citizen.id}"><i class="small material-icons">delete</i>Police</a>
                                    <a class="btn pink col s1" href="citizen.php?action=removeRoll&roll=parliament&cID={$page.citizen.id}"><i class="small material-icons">delete</i>Parliament</a>
                                </p>
                            {/if}
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