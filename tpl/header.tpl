<div class="header">
            <div class="logo"><b>SaS</b> Entrance</div>
            <!--<input class="search" type="text" placeholder="Suchen" />-->
            <div class="account-logo" onclick="onclickaccount()">{$args.usrchar}</div>
            <div class="account-detail" id="toggl">
                <ul>
                    <li>Eingeloggt als</li>
                    <li>{$args.usrname}</li>
                    <hr/>
                    <li><a href="users.php?action=edit&uID={$args.uID}">Account</a></li>
                    <hr/>
                    <li><a href="logon.php?logout=1">Logout</a></li>
                </ul>
            </div>
            <div class="title">{$args.title}</div>
        </div>
        <div class="aside">
            <ul>
                {if $args.level >= 1}
                    <li>ICH</li>
                    {if 0 == 1}<li><a href="">Dashboard</a></li>{/if}
                    {if $args.perm.site_view == 1 and false}<li><a href="">Meine Änderungen</a></li>{/if}
                    <li><a href="users.php?action=edit&uID={$args.uID}">Mein Account</a></li>
                    <hr/>
                    {if $args.perm.citizen_login or $args.perm.citizen_logout}
                        <li>Ein/Ausbuchen</li>
                        {if $args.perm.citizen_login == 1}<li><a href="files.php">Einbuchen</a></li>{/if}
                        {if $args.perm.citizen_logout == 1}<li><a href="protocols.php">Ausbuchen</a></li>{/if}
                        {if $args.perm.citizen_correcterrors == 1}<li><a href="">Fehler</a></li>{/if}
                        <hr/>
                    {/if}
                    {if $args.perm.citizen_view == 1}
                        <li>Schüler</li>
                        {if $args.perm.citizen_view == 1}<li><a href="">Alle Schüler</a></li>{/if}
                        {if $args.perm.citizen_info_difference == 1}<li><a href="">Böse Schüler</a></li>{/if}
                        {if $args.perm.citizen_present_list == 1}<li><a href="">zZ im Staat</a></li>{/if}
                        <hr/>
                    {/if}
                    {if $args.perm.citizen_present_list == 1}
                        <li>Infobildschirm</li>
                            <li><a href="">Anzahl im Staat</a></li>
                        <hr/>
                    {/if}
                    <li>Administration</li>
                    {if $args.perm.users_view == 1}<li><a href="users.php">Benutzerkonten</a></li>{/if}
                    {if $args.perm.admin_database == 1}<li><a href="adminer-4.2.4-mysql.php">Adminer (DB)</a></li>{/if}
                {/if}
                <hr/>
                <li>{exectime 3}ms</li>
            </ul>
            <span style="position: absolute; bottom: 5px; font-family: 'Roboto'; font-size: 11.5px;">SaS Entrance&trade; Version <span style="color: red;">b</span>0.0.2<br/>&copy;2016<br/> Janik Rapp, Yannick F&#233;lix</span>
        </div>
        <div style="position: fixed; top: 0; left: 310px; z-index: 1000; color: red; font-family: 'Roboto'; font-size: 15px">beta</div>
        <!-- Before body closing tag -->
        <script src="libs/bower_components/velocity/velocity.js"></script>
        <script src="libs/bower_components/moment/min/moment-with-locales.js"></script>
        <script src="libs/bower_components/angular/angular.js"></script>
        <script src="libs/bower_components/lumx/dist/lumx.js"></script>