{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <div class="card-panel row">
                    <form action="check.php?action=checkOutScan" method="post">
                        <input id="barcode" required type="hidden" value="{$page.barcode}" name="barcode" length="13"/>
                        <input id="force" required type="hidden" value="true" name="force" />
                        <h5>Der Schüler "<b>{$page.citizen.firstname} {$page.citizen.lastname}</b>" war heute nur <b>{$page.citizen.timeToday}</b> im Staat. Wirklich auschecken?</h5>
                        <button class="btn waves-effect waves-light col s5 green center" style="margin-top:15px;" type="submit" name="action">
                            <i class="material-icons">done</i>
                        </button>
                        <a class="btn waves-effect waves-light col s5 offset-s2 red" style="margin-top:15px;" href="check.php?action=checkOut">
                            <i class="material-icons">close</i>
                        </a>
                    </form>
                </div>
            </div>
            <div class="col s12 offset-m1 m5">
                <div class="card-panel">
                    <h5>Person</h5>
                    {if $locked == 1}<p class="red-text"><b>!</b> Person gesperrt</p><br/>{/if}
                    <p><b>Name:</b> {if ($page.citizen.firstname == 'Janik' and $page.citizen.lastname == 'Rapp') or ($page.citizen.firstname == 'Yannick' and $page.citizen.lastname == 'Félix')} <span class="red-text"> [Admin] </span>{/if}{$page.citizen.firstname} {$page.citizen.lastname}</p>
                    {if $page.citizen.age <= 100}
                        <p><b>Geburtstag:</b> {$page.citizen.birthdayNice}</p>
                    {/if}
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