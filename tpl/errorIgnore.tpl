{include file="newbase.tpl" args=$header}
<main>
            <div class="container">
                <div class="row">
                    <div class="col s12 m6">
                        <div class="card-panel row">
                            <form action="errors.php?action=autoIgnore" method="post">
                                <div class="input-field col s11">
                                    <i class="prefix mdi mdi-barcode-scan"></i>
                                    <label for="barcode">Hier scannen</label>
                                    <input id="barcode" required type="text" name="barcode" length="13" autofocus/>
                                </div>
                                <button class="btn-flat waves-effect waves-light col s1" style="margin-top:15px;" type="submit" name="action">
                                    <i class="material-icons right">send</i>
                                </button>
                            </form>
                            <div class="col s12">
                                {if $page.scan.success == 1}
                                    <p class="green-text"><img src="checkOk.png" height="16px"> Scan Erfolgreich. Fehler erfolgreich ignoriert!</p>
                                {elseif $page.scan.success == 2}
                                    <p class="red-text"><img src="checkFail.png" height="16px"> Scan Fehlgeschlagen. <i>Jetzt</i> habt ihr ein Problem.</p>
                                {/if}
                            </div>
                        </div>
                    </div>
                    <div class="col s12 offset-m1 m5">
                        <div class="card-panel">
                            <h5>Schüler</h5>
                            {if $locked == 1}<p class="red-text"><b>!</b> Person gesperrt</p><br/>{/if}
                            <p><b>Name:</b> {$page.citizen.firstname} {$page.citizen.lastname}</p>
                            <p><b>Geburtstag:</b> {$page.citizen.birthdayNice}</p>
                            <p><b>Klassenstufe:</b>
                                {if $page.citizen.classlevel<=13}{$page.citizen.classlevel}
                                {elseif $page.citizen.classlevel==14}Lehrer
                                {elseif $page.citizen.classlevel==15}Visum
                                {else}Kurier{/if}
                            </p>
                        </div>
                    </div>
                    <div class="col s12 offset-m7 m5">
                        <div class="card-panel">
                            <ul class="collection">
                                {loop $page.logs}
                                    <li class="collection-item avatar">
                                    {if $action == 0}
                                        <i class="material-icons circle green">navigate_before</i>
                                        <span class="title">Staat betreten</span>
                                        <p>{$timestamp}<br/>
                                            {if $_.page.citizen.classlevel == 16}
                                                Im Staat: {$timeSinceLast}<br/>
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

    });
</script>
{include file="newEnd.tpl"}