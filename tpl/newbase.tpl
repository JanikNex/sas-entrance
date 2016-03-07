<!DOCTYPE html>
<html>
    <head>
        <title>Sas Entrance</title>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="libs/materialize/css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="libs/materialize/js/materialize.min.js"></script>

        <!-- Dropdown Structure -->
        <ul id="dropdown1" class="dropdown-content">
            <li><a href="users.php?action=edit&uID={$args.uID}">Mein Account</a></li>
            <li class="divider"></li>
            <li><a href="logon.php?logout=1">Abmelden</a></li>
        </ul>
        <nav>
            <div class="nav-wrapper indigo">
                <a href="#!" class="brand-logo" style="padding-left: 250px;">Sas Entrance - {$args.title}</a>
                <ul class="right hide-on-med-and-down">
                    <!-- Dropdown Trigger -->
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1">{$args.usrname}<i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
                <ul id="slide-out" class="side-nav fixed">
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">ICH<i class="mdi-navigation-arrow-drop-down"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!">Dashboard</a></li>
                                        <li><a href="users.php?action=edit&uID={$args.uID}">Mein Account</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {if $args.perm.citizen_login == 1 or $args.perm.citizen_logout == 1}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Ein/Ausbuchen<i class="mdi-navigation-arrow-drop-down"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        {if $args.perm.citizen_login == 1}<li><a href="#!">Einbuchen</a></li>{/if}
                                        {if $args.perm.citizen_logout == 1}<li><a href="#!">Ausbuchen</a></li>{/if}
                                        {if $args.perm.citizen_correcterrors == 1}<li><a href="#!">Fehler</a></li>{/if}
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {/if}
                    {if $args.perm.citizen_view == 1}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Schüler<i class="mdi-navigation-arrow-drop-down"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        {if $args.perm.citizen_view == 1}<li><a href="citizen.php">Alle Schüler</a></li>{/if}
                                        {if $args.perm.citizen_info_difference == 1}<li><a href="#!">Böse Schüler</a></li>{/if}
                                        {if $args.perm.citizen_present_list == 1}<li><a href="#!">zZ im Staat</a></li>{/if}
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {/if}
                    {if $args.perm.citizen_present_number == 1}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Infobildschirm<i class="mdi-navigation-arrow-drop-down"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="#!">Anzahl zZ im Staat</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {/if}
                    {if $args.perm.users_view == 1 or $args.perm.admin_database}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Administration<i class="mdi-navigation-arrow-drop-down"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        {if $args.perm.users_view == 1}<li><a href="users.php">Benutzerkonten</a></li>{/if}
                                        {if $args.perm.admin_database == 1}<li><a href="adminer-4.2.4-mysql.php">Adminer (Datenbank)</a></li>{/if}
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="divider"></li>
                    {/if}
                </ul>
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
            </div>
        </nav>