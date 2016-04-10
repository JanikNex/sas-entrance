{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="card-panel col s12 m12 l5">
                <!-- Linker Kasten -->
                <h1 style="font-family: 'Roboto Condensed'">Willkommen!</h1>
                <p>SaSEntrance - {if $header.usrname == "YannickFelix" or $header.usrname == "JanikRapp"}StaSi Schlopolis{else}Staatsverwaltung Schlopolis{/if}</p>
            </div>
            <div class="card-panel col s12 m12 l5 offset-l2">
                <!-- Rechter Kasten -->
                <p><b>Technische Ansprechpartner:</b></p>
                <p>Janik Rapp 11DE1<br/>Yannick Félix 11EN1</p>
            </div>
            <div class="card-panel col s12 m12 l12">
                <!-- Unterer Kasten -->
                <p class="red-text text-darken-2 bolden">Jegliche Interaktionen mit SaSEntrance werden geloggt!</sp>
                <p>Versuche der Kompromittierung, Manipulation oder Sabotage ziehen rechtliche Konsequenzen mit sich!</p>
            </div>
        </div>
    </div>
</main>
<script>
    jQuery(document).ready(function($) {

    });
</script>
{include file="newEnd.tpl"}