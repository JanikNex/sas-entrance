{include file="base.tpl"}
<div class="content">
            <link type="text/css" rel="stylesheet" href="libs/materialize/css/materialize.min.css"  media="screen,projection"/>
            <form method="post" action="citizen.php?action=postNew">
                <table class="edit">
                    <thead>
                        <tr>
                            <th>
                                Neuen Schüler anlegen
                            </th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr><td>
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <label for="firstname">Vorname</label>
                                            <input id="firstname" required type="text" name="firstname" length="255"/>
                                        </div>
                                        <div class="input-field col s6">
                                            <label for="lastname">Nachname</label>
                                            <input id="lastname" required type="text" name="lastname" length="255"/>
                                        </div>
                                        <div class="input-field col s6">
                                            <input type="date" name="birthday" id="birthday" class="datepicker">
                                            <label for="date">Geburtstag</label>
                                        </div>
                                        <div class="input-field col s6">
                                            <select id="type" title="classlevel" name="classlevel">
                                                <option value="" disabled selected>Wähle eine Klassenstufe</option>
                                                <option value="5">Stufe 5</option>
                                                <option value="6">Stufe 6</option>
                                                <option value="7">Stufe 7</option>
                                                <option value="8">Stufe 8</option>
                                                <option value="9">Stufe 9</option>
                                                <option value="10">Stufe 10</option>
                                                <option value="11">Stufe 11</option>
                                                <option value="12">Stufe 12</option>
                                                <option value="14">Lehrer</option>
                                                <option value="15">Visum</option>
                                            </select>
                                            <label for="selInt">Klassenstufe</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <label for="barcode"><i class="mdi mdi-barcode-scan"></i>Barcode [als letztes ausfüllen!]</label>
                                            <input id="barcode" required type="text" name="barcode" length="13"/>
                                        </div>
                                    </div>
                            </td></tr>
                            <tr><td><input type="submit" value="Neuen Schüler anlegen"/></td></tr>
                        </tbody>
                </table>
            </form>
        </div>
{include file="header.tpl" args=$header}
        <script>
            jQuery(document).ready(function($) {
                $('select').material_select();
                $('parallax').parallax
            });

            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 15, // Creates a dropdown of 15 years to control year
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
</body>
</html>