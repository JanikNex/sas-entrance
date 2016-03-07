        {include file="base.tpl"}
        <div class="content">
            <form method="post" action="users.php?action=postNew">
                <table class="edit">
                    <thead>
                        <tr>
                            <th>
                                Neuer Benutzer
                            </th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr><td>
                                    <div class="row">
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
                                    </div>
                            </td></tr>
                            <tr><td><input type="submit" value="Neuen Benutzer erstellen"/></td></tr>
                        </tbody>
                </table>
            </form>
        </div>
        {include file="header.tpl" args=$header}
    </body>
</html>