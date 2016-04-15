<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="libs/materialize/css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css" />
        <link type="text/css" rel="stylesheet" href="css/odometer-theme-minimal.css" />

      <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <!--Import jQuery before materialize.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="libs/materialize/js/materialize.min.js"></script>
        <script type="text/javascript" src="libs/jquery-barcode.min.js"></script>
        <script type="text/javascript" src="libs/odometer.min.js"></script>
        <nav>
            <div class="nav-wrapper indigo">
                <span class="brand-logo" style="padding-left: 20px;">Schlopolis</span>
                <ul class="right hide-on-med-and-down">
                    <li id="timehour" style="font-size: 40px;" class="odometer"></li>
                    <li style="font-size: 40px;"> : </li>
                    <li id="timemin" style="font-size: 40px;" class="odometer"></li>
                    <li style="font-size: 40px;"> : </li>
                    <li id="timesec" style="font-size: 40px;" class="odometer"></li>
                </ul>
            </div>
        </nav>
        <script>
        window.odometerOptions = {
            format: '(.ddd)'
        };
        </script>
        <main style="padding:0;">
            <div class="container">
                <div class="row center">
                        <h1 class="center">Aktuell sind</h1>
                        <div id="count" class="odometer" style="text-align: right; font-size: 35vh;"></div>
                    <h1 class="center"><?php if($_GET['type'] == "all") echo "Personen"; elseif($_GET['type'] == "visit") echo "Besucher"; else echo "Bürger";?> im Staat</h1>
                </div>
            </div>
        </main>
    </body>
    <style>
        .odometer .odometer-inside .odometer-digit:first-child,
        .odometer .odometer-inside .odometer-formatting-mark:nth-child(2) {
            display: none
        }

    </style>
    <script>
        $(document).ready(function() {
          $(".dropdown-button").dropdown();

          // Initialize collapse button
          $(".button-collapse").sideNav();
          // Initialize collapsible (uncomment the line below if you use the dropdown variation)
          //$('.collapsible').collapsible();

          $('.odometer').html(123); // with jQuery
          (function() {
              var oldOpen = XMLHttpRequest.prototype.open;
              window.openHTTPs = 0;
              XMLHttpRequest.prototype.open = function(method, url, async, user, pass) {
                  window.openHTTPs++;
                  this.addEventListener("readystatechange", function() {
                      if(this.readyState == 4) {
                          window.openHTTPs--;
                      }
                  }, false);
                  oldOpen.call(this, method, url, async, user, pass);
              }
          })();
            refresh();
            refreshCaller();
        });

        function refreshCaller() {
            if(window.openHTTPs == 0) refresh();
            // den Inhalt des Requests in das <div> schreiben
            var d = new Date();
            $('#timehour').html(100+d.getHours());
            $('#timemin').html(100+d.getMinutes());
            $('#timesec').html(100+d.getSeconds());
            window.setTimeout("refreshCaller()", 250);
        }

        var request = false;

        function refresh() {
            $.get("citizen.php?action=counter&type=<?php echo $_GET['type'];?>", null, function (data) {
                var content = data;
                $('#count').html(1000+content);
            });
        }
    </script>
</html>