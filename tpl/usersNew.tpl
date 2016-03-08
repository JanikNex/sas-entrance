{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <br/>
            <form action="users.php?action=postNew" method="post" id="form">
                <div class="input-field col s12">
                    <label for="usrname">Benutzername</label>
                    <input id="usrname" required type="text" name="usrname" length="255"/>
                </div>
                <div class="input-field col s12">
                    <label for="email">Email</label>
                    <input id="email" required type="email" name="email" length="65535"/>
                </div>
                <div class="input-field col s6">
                    <label for="pw1">Passwort</label>
                    <input id="pw1" required type="password" name="passwd" length="18446744073709551615"/>
                </div>
                <div class="input-field col s6">
                    <label for="pw2">Passwort wiederholen</label>
                    <input id="pw2" required type="password" name="passwd2" length="18446744073709551615"/>
                </div>
            </form>
        </div>
    </div>
</main>
<script>
    jQuery(document).ready(function($) {
        $('select').material_select();
        $('parallax').parallax
    });

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 20, // Creates a dropdown of 15 years to control year
        // Strings and translations
        monthsFull: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
        weekdaysFull: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],

        today: 'Heute',
        clear: 'Löschen',
        close: 'Schließen',

        labelMonthNext: 'Nächster Monat',
        labelMonthPrev: 'Vorheriger Monat',
        labelMonthSelect: 'Wähle einen Monat',
        labelYearSelect: 'Wähle ein Jahr',

        format: 'yyyy-mm-dd',
        formatSubmit: 'yyyy-mm-dd',
        hiddenPrefix: undefined,
        hiddenSuffix: '_submit',
        hiddenName: undefined,

        firstDay: 1
    });
</script>
{include file="newEnd.tpl"}