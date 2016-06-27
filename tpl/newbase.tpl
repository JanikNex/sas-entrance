<!DOCTYPE html>
<html>
    <head>
        <title>Sas Entrance - {$args.title}</title>
        <!--Import Google Icon Font-->
        <!--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto+Mono' rel='stylesheet' type='text/css'>
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="libs/materialize/css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link type="text/css" rel="stylesheet" href="css/materialdesignicons.min.css" media="all"/>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="manifest" href="manifest.json" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="theme-color" content="#3F51B5" />
    </head>
    <body>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="libs/jquery-2.2.1.min.js"></script>
        <script type="text/javascript" src="libs/materialize/js/materialize.min.js"></script>
        <script type="text/javascript" src="libs/jquery-barcode.min.js"></script>
        <script type="text/javascript" src="libs/handlebars.js"></script>

        <!-- Dropdown Structure -->
        <ul id="dropdown1" class="dropdown-content">
            <li><a href="users.php?action=edit&uID={$args.uID}">Mein Account</a></li>
            <li class="divider"></li>
            <li><a href="logon.php?logout=1">Abmelden</a></li>
        </ul>
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper indigo">
                    <a href="#!" class="brand-logo hide-on-med-and-down" style="padding-left: 250px;">Sas Entrance - <span id="title">{$args.title}</span></a>
                    <a href="#!" class="brand-logo hide-on-large-only" style="">Sas - <span id="title">{$args.title}</span></a>
                    <ul class="right">
                        <!-- Dropdown Trigger -->
                        {if $args.switchmode == 1}
                            <li><a onClick="switchMode()"><i class="material-icons">cached</i></a></li>
                        {/if}
                        {if $args.editor == 1}
                        <li><a href="{$args.undoUrl}"><i class="material-icons">clear</i></a></li>
                        <li><a href="javascript:{}" onclick="document.getElementById('form').submit();"><i class="material-icons">done</i></a></li>
                        {/if}
                        <li><a class="dropdown-button hide-on-med-and-down" href="#!" data-activates="dropdown1">{$args.usrname}<i class="material-icons right">arrow_drop_down</i></a></li>
                    </ul>
                    <ul id="slide-out" class="side-nav fixed">
                        <li class="no-padding">
                            <ul class="collapsible collapsible-accordion">
                                <li>
                                    <a class="collapsible-header">ICH<i class="mdi-navigation-arrow-drop-down"></i></a>
                                    <div class="collapsible-body">
                                        <ul>
                                            <li><a href="index.php">Startseite</a></li>
                                            <li><a href="users.php?action=edit&uID={$args.uID}">Mein Account</a></li>
                                            <li class="hide-on-large-only"><a href="logon.php?logout=1">Abmelden</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        {if $args.perm.citizen_login == 1 or $args.perm.citizen_correcterrors == 1 or $args.perm.citizen_ignoreerrors == 1}
                        <li class="no-padding">
                            <ul class="collapsible collapsible-accordion">
                                <li>
                                    <a class="collapsible-header">Ein/Ausbuchen<i class="mdi-navigation-arrow-drop-down"></i></a>
                                    <div class="collapsible-body">
                                        <ul>
                                            {if $args.perm.citizen_login == 1 and $args.perm.citizen_logout == 1}<li><a href="checkn.php">Ein/Ausbuchen</a></li>{/if}
                                            {if $args.perm.citizen_correcterrors == 1}<li><a href="errors.php?action=correct">Fehler korrigieren</a></li>{/if}
                                            {if $args.perm.citizen_ignoreerrors == 1}<li><a href="errors.php?action=ignore">Fehler ignorieren</a></li>{/if}
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
                                    <a class="collapsible-header">Personen<i class="mdi-navigation-arrow-drop-down"></i></a>
                                    <div class="collapsible-body">
                                        <ul>
                                            {if $args.perm.citizen_view == 1}<li><a href="citizen.php">Alle Personen</a></li>{/if}
                                            {if $args.perm.citizen_info_difference == 1}<li><a href="citizen.php?action=badcitizen">Böse Schüler</a></li>{/if}
                                            {if $args.perm.citizen_present_list == 1}<li><a href="citizen.php?action=listInState">zZ im Staat</a></li>{/if}
                                            {if $args.perm.citizen_tracing_list == 1}<li><a href="citizen.php?action=wantedcitizen">Fahndungsliste</a></li>{/if}
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
                                            <li><a href="counter.php?type=all">Anzahl gesamt</a></li>
                                            <li><a href="counter.php?type=visit">Anzahl Besucher</a></li>
                                            <li><a href="counter.php?type=student">Anzahl Schüler</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        {/if}
                        {if $args.perm.employer_list == 1}
                            <li class="no-padding">
                                <ul class="collapsible collapsible-accordion">
                                    <li>
                                        <a class="collapsible-header">Betriebe<i class="mdi-navigation-arrow-drop-down"></i></a>
                                        <div class="collapsible-body">
                                            <ul>
                                                <li><a href="employer.php">Betriebsliste</a></li>
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
                                            {if $args.perm.users_view == 1}<li><a href="users.php?filter=Alle&sort=ascName">Benutzerkonten</a></li>{/if}
                                            {if $args.perm.admin_database == 1}<li><a href="adminer-4.2.4-mysql.php">Adminer (Datenbank)</a></li>{/if}
                                            {if $args.perm.admin_errors == 1}<li><a href="errors.php">Fehlerliste</a></li>{/if}
                                            {if $args.perm.admin_kickall == 1}<li><a href="citizen.php?action=kickall">Alle Rausschmeißen</a></li>{/if}
                                            {if $args.perm.admin_tracing == 1}<li><a href="citizen.php?action=allTracings">Alle Fahndungen</a></li>{/if}
                                            {if $args.perm.admin_state_dashboard == 1}<li><a href="dashboard.php">Staats Dashboard</a></li>{/if}
                                            {if $args.perm.admin_state_dashboard == 1}<li><a href="stats.php">Statistik</a></li>{/if}
                                            {if $args.perm.admin_export == 1}<li><a href="export.php">Exportieren</a></li>{/if}
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li style="height: 100px"></li>
                        <li class="indigo" style="position: fixed; width: 240px; bottom: 0px; font-size: 12px; line-height: 16px; padding:10px">
                            Entrance Version 0.6.1b<br/>© 2016 Yannick Félix & Janik Rapp
                        </li>
                        {/if}
                    </ul>
                    {if $args.backable == 0}<a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>{/if}
                    {if $args.backable == 1}<a href="{$args.undoUrl}" class="button"><i class="mdi-navigation-arrow-back"></i></a>{/if}
                </div>
            </nav>
        </div>