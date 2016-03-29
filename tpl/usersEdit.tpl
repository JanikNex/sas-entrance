{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <br/>
            <form method="post" action="users.php?action=postEdit&field=all&uID={$edit.id}">
                <div class="input-field col s6">
                    <label for="username">Benutzername</label>
                    <input id="username" {if $header.uID == $edit.id}disabled{else}required{/if} value="{$edit.usrname}" type="text" name="firstname" length="255"/>
                </div>
                <div class="input-field col s6">
                    <select id="type" title="Type" name="lvl">
                        <option value="" disabled selected>Wähle einen Level</option>
                        <option {if $edit.lvl == 0}selected{/if} {if $header.level < 0}disabled{/if} value="0">User</option>
                        <option {if $edit.lvl == 1}selected{/if} {if $header.level < 1}disabled{/if} value="1">Orga</option>
                        <option {if $edit.lvl == 2}selected{/if} {if $header.level < 2}disabled{/if} value="2">Admin</option>
                    </select>
                    <label for="selInt">Level</label>
                </div>
                <div class="input-field col s12">
                    <label for="email">Email</label>
                    <input id="email" required value="{$edit.email}" type="email" name="email" length="65535"/>
                </div>
                <div class="col s12">
                    <button class="btn waves-effect waves-light btn-flat" type="submit" name="action">SETZTEN
                        <i class="material-icons left">done</i>
                    </button>
                </div>
            </form>
            <form method="post" action="users.php?action=postEdit&field=passwd&uID={$edit.id}">
                <div class="input-field col s6">
                    <label for="pw1">Passwort</label>
                    <input id="pw1" type="password" name="passwd" length="18446744073709551615"/>
                </div>
                <div class="input-field col s6">
                    <label for="pw2">Passwort wiederholen</label>
                    <input id="pw2" type="password" name="passwd2" length="18446744073709551615"/>
                </div>
                <div class="col s12">
                    <button class="btn waves-effect waves-light btn-flat" type="submit" name="action">SETZTEN
                        <i class="material-icons left">done</i>
                    </button>
                </div>
            </form>

            <div class="s12">
                <form action="users.php?action=updatePerms&uID={$edit.id}" method="post">
                    <table>
                        <tr><th>Rechte</th><th>{if $permU.users_perms == 1}
                            <button class="btn waves-effect waves-light btn-flat" type="submit" name="action">SETZTEN
                                <i class="material-icons left">done</i>
                            </button>{/if}
                        </th></tr>
                        <tr><td><b>Benutzer</b></td></tr>
                        <tr><td>Benutzer ansehen      </td><td><div class="switch"><label>Off<input type="checkbox" id="cb00" {if $perm.users_view   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh00" type="hidden" value="0" name="users.view"/>  </td></tr>
                        <tr><td>Benutzer erstellen    </td><td><div class="switch"><label>Off<input type="checkbox" id="cb01" {if $perm.users_create == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh01" type="hidden" value="0" name="users.create"/></td></tr>
                        <tr><td>Benutzer bearbeiten   </td><td><div class="switch"><label>Off<input type="checkbox" id="cb02" {if $perm.users_edit   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh02" type="hidden" value="0" name="users.edit"/>  </td></tr>
                        <tr><td>Benutzerrechte ändern </td><td><div class="switch"><label>Off<input type="checkbox" id="cb03" {if $perm.users_perms  == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh03" type="hidden" value="0" name="users.perms"/> </td></tr>
                        <tr><td>Benutzer löschen      </td><td><div class="switch"><label>Off<input type="checkbox" id="cb04" {if $perm.users_del    == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh04" type="hidden" value="0" name="users.del"/>   </td></tr>

                        <tr><td><b>Personen</b></td></tr>
                        <tr><td>Person ansehen      </td><td><div class="switch"><label>Off<input type="checkbox" id="cb05" {if $perm.citizen_view   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh05" type="hidden" value="0" name="citizen.view"/>  </td></tr>
                        <tr><td>Person erstellen    </td><td><div class="switch"><label>Off<input type="checkbox" id="cb06" {if $perm.citizen_create == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh06" type="hidden" value="0" name="citizen.create"/></td></tr>
                        <tr><td>Person bearbeiten   </td><td><div class="switch"><label>Off<input type="checkbox" id="cb07" {if $perm.citizen_edit   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh07" type="hidden" value="0" name="citizen.edit"/>  </td></tr>
                        <tr><td>Person löschen      </td><td><div class="switch"><label>Off<input type="checkbox" id="cb08" {if $perm.citizen_del    == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh08" type="hidden" value="0" name="citizen.del"/>   </td></tr>

                        <tr><td><b>Personen Ein/Ausbuchen</b></td></tr>
                        <tr><td>Personen einbuchen       </td><td><div class="switch"><label>Off<input type="checkbox" id="cb09" {if $perm.citizen_login           == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh09" type="hidden" value="0" name="citizen.login"/>         </td></tr>
                        <tr><td>Personen ausbuchen       </td><td><div class="switch"><label>Off<input type="checkbox" id="cb10" {if $perm.citizen_logout          == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh10" type="hidden" value="0" name="citizen.logout"/>        </td></tr>
                        <tr><td>Fehler korrigieren       </td><td><div class="switch"><label>Off<input type="checkbox" id="cb11" {if $perm.citizen_correcterrors   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh11" type="hidden" value="0" name="citizen.correcterrors"/> </td></tr>
                        <tr><td>Fehler ignorieren        </td><td><div class="switch"><label>Off<input type="checkbox" id="cb19" {if $perm.citizen_ignoreerrors   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh19" type="hidden" value="0" name="citizen.ignoreerrors"/>   </td></tr>

                        <tr><td><b>Personen Fahndung</b></td></tr>
                        <tr><td>Fahndung hinzufügen       </td><td><div class="switch"><label>Off<input type="checkbox" id="cb24" {if $perm.tracing_add           == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh24" type="hidden" value="0" name="tracing.add"/>      </td></tr>
                        <tr><td>Fahndung entfernen        </td><td><div class="switch"><label>Off<input type="checkbox" id="cb25" {if $perm.tracing_remove          == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh25" type="hidden" value="0" name="tracing.remove"/> </td></tr>
                        <tr><td>Fahndungen anzeigen       </td><td><div class="switch"><label>Off<input type="checkbox" id="cb26" {if $perm.tracing_list   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh26" type="hidden" value="0" name="tracing.list"/>            </td></tr>

                        <tr><td><b>Personeninfos</b></td></tr>
                        <tr><td>Anwesende Personen ansehen(Zahl)  </td><td><div class="switch"><label>Off<input type="checkbox" id="cb12" {if $perm.citizen_present_number  == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh12" type="hidden" value="0" name="citizen.present.number"/>  </td></tr>
                        <tr><td>Anwesende Personen ansehen(Liste) </td><td><div class="switch"><label>Off<input type="checkbox" id="cb13" {if $perm.citizen_present_list    == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh13" type="hidden" value="0" name="citizen.present.list"/>    </td></tr>
                        <tr><td>Personeninfo ansehen              </td><td><div class="switch"><label>Off<input type="checkbox" id="cb14" {if $perm.citizen_info_specific   == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh14" type="hidden" value="0" name="citizen.info.specific"/>   </td></tr>
                        <tr><td>Böse Schüler ansehen              </td><td><div class="switch"><label>Off<input type="checkbox" id="cb15" {if $perm.citizen_info_difference == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh15" type="hidden" value="0" name="citizen.info.difference"/> </td></tr>

                        <tr><td><b>Sonstige</b></td></tr>
                        <tr><td>Datenbank               </td> <td><div class="switch"><label>Off<input type="checkbox" id="cb16" {if $perm.admin_database == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh16" type="hidden" value="0" name="admin.database"/>              </td></tr>
                        <tr><td>Fehler ansehen          </td> <td><div class="switch"><label>Off<input type="checkbox" id="cb17" {if $perm.admin_errors == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh17" type="hidden" value="0" name="admin.errors"/>                  </td></tr>
                        <tr><td>Alle kicken             </td> <td><div class="switch"><label>Off<input type="checkbox" id="cb18" {if $perm.admin_kickall == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh18" type="hidden" value="0" name="admin.kickall"/>                </td></tr>
                        <tr><td>Staats Dashboard ansehen</td> <td><div class="switch"><label>Off<input type="checkbox" id="cb20" {if $perm.admin_state_dashboard == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh20" type="hidden" value="0" name="admin.state.dashboard"/></td></tr>
                        <tr><td>Staat öffnen            </td> <td><div class="switch"><label>Off<input type="checkbox" id="cb21" {if $perm.admin_state_open == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh21" type="hidden" value="0" name="admin.state.open"/>          </td></tr>
                        <tr><td>Staat schließen         </td> <td><div class="switch"><label>Off<input type="checkbox" id="cb22" {if $perm.admin_state_close == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh22" type="hidden" value="0" name="admin.state.close"/>        </td></tr>
                        <tr><td>Daten exportieren       </td> <td><div class="switch"><label>Off<input type="checkbox" id="cb23" {if $perm.admin_export == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh23" type="hidden" value="0" name="admin.export"/>                  </td></tr>
                        <tr><td>Admins benachichtigen   </td> <td><div class="switch"><label>Off<input type="checkbox" id="cb27" {if $perm.admin_notify == 1}checked{/if}><span class="lever"></span>On</label></div><input id="hh27" type="hidden" value="0" name="admin.notify"/>                  </td></tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    jQuery(document).ready(function($) {
        $('select').material_select();
        checkBoxes();
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

    function checkBoxes() {
        $("input[type=checkbox]").each(function(){
            if(this.checked) checked = 1;
            else checked = 0;
            console.log(this.id);

            str = this.id;
            id = str.replace("cb", "hh");
            document.getElementById(id).value = checked;
        });

        window.setTimeout("checkBoxes()", 50)
    }
</script>
{include file="newEnd.tpl"}