{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <div class="card-panel col s12 m8 offset-m2">
                Bist du sicher?<br/>
                <i>Diese Aktion sollte/kann nicht rückgängig gemacht werden.</i><br/>
                Dann schreibe: (Caps dabei vertauschen.)
                <form method="post" action="citizen.php?action=confirmKickAll">
                    <div class="input-field col s6">
                        <input type="text" name="security1" id="security1">
                        <label for="security1"><i>IsCh BiN mIr WiRkLiScH SiScHaAaA!!</i></label>
                        <br/>
                        Welche Farbe hat Graß normalerweiße?
                        <select id="type" title="Type" name="security2">
                            <option value="nope" disabled selected>Bitte nicht rot, gelb oder blau nehmen!</option>
                            <option value="nope">Gelb</option>
                            <option value="nope">Rot</option>
                            <option value="ok">Grün</option>
                            <option value="nope">Blau</option>
                            <option value="nope">Welche Sonne meinst du?</option>
                        </select>
                        <br/>
                        <b>(27 + 12,5 * 0,5)^2</b><br/>
                        <button class="btn waves-effect waves-light btn-flat" name="action">1099.8525
                            <i class="material-icons left">done_all</i>
                        </button>
                        <button class="btn waves-effect waves-light btn-flat" name="action">1105.5625
                            <i class="material-icons left">done_all</i>
                        </button>
                        <button class="btn waves-effect waves-light btn-flat" type="submit" name="action">7001.4575
                            <i class="material-icons left">done_all</i>
                        </button>
                        <button class="btn waves-effect waves-light btn-flat" name="action">5329.4650
                            <i class="material-icons left">done_all</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    jQuery(document).ready(function($) {
        $('select').material_select();
    });
</script>
{include file="newEnd.tpl"}