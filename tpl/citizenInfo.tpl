{include file="newbase.tpl" args=$header}
<main>
            <div class="container">
                <div class="row">
                    <div class="col s12 m5">
                        <div class="card-panel">
                            <h5>Schüler</h5>
                            <p><b>Name:</b> {$page.citizen.firstname} {$page.citizen.lastname}</p>
                            <p><b>Geburtstag:</b> {$page.citizen.birthday}</p>
                            <p><b>Barcode:</b> {$page.citizen.barcode}</p>
                            <div id="bcTarget"></div>
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
                                        <p>{$timestamp}<br>
                                            <img src="barcode-scan.svg" height="16px" /> {$scanner}
                                        </p>
                                    {else}
                                        <i class="material-icons circle red">navigate_next</i>
                                        <span class="title">Staat verlassen</span>
                                        <p>{$timestamp} | Im Staat: {$timeSinceLast}<br>
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
        $("#bcTarget").barcode("{$page.citizen.barcode}", "ean13");
    });
</script>
{include file="newEnd.tpl"}