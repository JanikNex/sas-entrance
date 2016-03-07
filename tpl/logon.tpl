<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="css/logon.css" type="text/css" />
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic|Ubuntu:400,700' rel='stylesheet' type='text/css'>
        <meta charset="UTF-8" />
    </head>
    <body>
        <div class="login-container">
            <form action="logon.php" method="post">
                <h2>LOGIN</h2>
                <div class="group">
                    <input type="text" name="usrname" class="{if $err==1}err{else}nor{/if}" {if $usrname != ""}value="{$usrname}"{/if} required/>
                    <span class="highlight"></span>
                    <span class="bar{if $err==1}err{/if}"></span>
                    <label>Benutzername</label>
                    <span class="err">{if $err==1}Benutzername existiert nicht.{/if}{if $ses == 1}Keine gültige Session.{/if}</span>
                </div>
                <div class="group">
                    <input type="password" name="password" class="{if $err==2}err{else}nor{/if}" required/>
                    <span class="highlight"></span>
                    <span class="bar{if $err==2}err{/if}"></span>
                    <label>Passwort</label>
                    <span class="err">{if $err==2}Passwort falsch{/if}</span>
                </div>
                <input class="btn" type="submit" value="OK"/>
            </form>
            <a href="" class="close">x</a>
        </div>
    </body>
</html>