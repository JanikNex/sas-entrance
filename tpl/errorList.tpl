{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <form class="col s12 m7" method="post" action="" id="live-search">
                <div class="row">
                    <div class="input-field col s12 ">
                        <i class="material-icons prefix">search</i>
                        <input id="filter" type="text" class="validate">
                        <label for="filter">In Benutzer suchen ...</label>
                    </div>
                </div>
            </form>
            <div class="col offset-s4 s4 offset-m1 m2 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a class='dropdown-button btn indigo' href='#' data-activates='dropdown0'><i class="mdi mdi-sort"></i> {$page.sort}</a>

                <!-- Dropdown Structure -->
                <ul id='dropdown0' class='dropdown-content'>
                    <li><a href="#!">{$page.sort}</a></li>
                    <li class="divider"></li>
                    {if $page.sort != "ascDate"} <li><a href="?filter={$page.filter}&sort=ascDate"> <i class="mdi mdi-sort-ascending"> </i> Datum</a></li>{/if}
                    {if $page.sort != "descDate"}<li><a href="?filter={$page.filter}&sort=descDate"><i class="mdi mdi-sort-descending"></i> Datum</a></li>{/if}
                    {if $page.sort != "ascID"}   <li><a href="?filter={$page.filter}&sort=ascID">   <i class="mdi mdi-sort-ascending"> </i> ID</a></li>{/if}
                    {if $page.sort != "descID"}  <li><a href="?filter={$page.filter}&sort=descID">  <i class="mdi mdi-sort-descending"></i> ID</a></li>{/if}
                </ul>
            </div>
            <div class="col s4 m2 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a class='dropdown-button btn indigo' href='#' data-activates='dropdown'><i class="mdi mdi-filter"></i> {$page.filter}</a>

                <!-- Dropdown Structure -->
                <ul id='dropdown' class='dropdown-content'>
                    <li><a href="#!">{$page.filter}</a></li>
                    <li class="divider"></li>
                    {if $page.filter != "Alle"}<li>                   <a href="?sort={$page.sort}&filter=Alle">Alle</a></li>{/if}
                    {if $page.filter != "INAlreadyCheckedIn"}<li>     <a href="?sort={$page.sort}&filter=INAlreadyCheckedIn    ">INAlreadyCheckedIn    </a></li>{/if}
                    {if $page.filter != "OUTAlreadyCheckedOut"}<li>   <a href="?sort={$page.sort}&filter=OUTAlreadyCheckedOut  ">OUTAlreadyCheckedOut  </a></li>{/if}
                    {if $page.filter != "OUTNoCheckOutYesterday"}<li> <a href="?sort={$page.sort}&filter=OUTNoCheckOutYesterday">OUTNoCheckOutYesterday</a></li>{/if}
                    {if $page.filter != "INCitizenLocked"}<li>        <a href="?sort={$page.sort}&filter=INCitizenLocked       ">INCitizenLocked       </a></li>{/if}
                    {if $page.filter != "OUTCitizenLocked"}<li>       <a href="?sort={$page.sort}&filter=OUTCitizenLocked      ">OUTCitizenLocked      </a></li>{/if}
                    {if $page.filter != "INCitizenWanted"}<li>        <a href="?sort={$page.sort}&filter=INCitizenWanted       ">INCitizenWanted       </a></li>{/if}
                    {if $page.filter != "OUTCitizenWanted"}<li>       <a href="?sort={$page.sort}&filter=OUTCitizenWanted      ">OUTCitizenWanted      </a></li>{/if}
                    {if $page.filter != "INNoCitizenFound"}<li>       <a href="?sort={$page.sort}&filter=INNoCitizenFound      ">INNoCitizenFound      </a></li>{/if}
                    {if $page.filter != "OUTNoCitizenFound"}<li>      <a href="?sort={$page.sort}&filter=OUTNoCitizenFound     ">OUTNoCitizenFound     </a></li>{/if}
                </ul>
            </div>
            <ul class="collection col s12">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="material-icons circle {if $errorStatus == 0}green{elseif $errorStatus == 1}red{else}grey{/if}">error_outline</i>
                        <span class="title">[{$errorCode}]:
                            {if $errorCode == 1}Error@CheckIn | AlreadyCheckedIn {/if}
                            {if $errorCode == 2}Error@CheckOut | AlreadyCheckedOut {/if}
                            {if $errorCode == 3}Error@CheckOut | NoCheckOutYesterday {/if}
                            {if $errorCode == 4}Error@CheckIn | CitizenLocked {/if}
                            {if $errorCode == 5}Error@CheckOut | CitizenLocked {/if}
                            {if $errorCode == 6}Error@CheckIn | CitizenWanted {/if}
                            {if $errorCode == 7}Error@CheckOut | CitizenWanted {/if}
                            {if $errorCode == 8}Error@CheckIn | NoCitizenFound {/if}
                            {if $errorCode == 9}Error@CheckOut | NoCitizenFound {/if}
                            @Citizen: [#{$cID}]{$citizenName}</span>
                        <p>
                            {$timestamp}
                        </p>
                        <span class="secondary-content">
                            <a class="waves-effect waves-circle" href="errors.php?action=correctThis&eID={$eID}">
                                <i class="material-icons grey-text text-darken-1" style="margin: 0px 5px;">done</i>
                            </a>
                            <a class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$id}" style="margin: 0px 5px;">
                                <i class="material-icons grey-text text-darken-1">delete</i>
                            </a>
                        </span>
                        <div id="modal{$id}" class="modal">
                            <div class="modal-content black-text">
                                <h4>L&ouml;schen</h4>
                                <p>M&ouml;chtest Du den Fehler wirklich l&ouml;schen?<br/>Dies kann zu großen Problemen führen</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                <a href="errors.php?action=del&eID={$eID}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
                            </div>
                        </div>
                    </li>
                {/loop}
            </ul>
        </div>
    </div>
</main>
<script>
  $(document).ready(function(){
      // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
      $('.modal-trigger').leanModal();
      $("#filter").keyup(function(){

          // Retrieve the input field text and reset the count to zero
          var filter = $(this).val(), count = 0;

          // Loop through the comment list
          $("ul.collection li").each(function(){

              // If the list item does not contain the text phrase fade it out
              if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                  $(this).fadeOut();

                  // Show the list item if the phrase matches and increase the count by 1
              } else {
                  $(this).show();
                  count++;
              }
          });

          // Update the count
          var numberItems = count;
      });
  });

  $('.dropdown-button').dropdown({
      inDuration: 300,
      outDuration: 225,
      constrain_width: false, // Does not change width of dropdown to that of the activator
      hover: false, // Activate on hover
      gutter: 0, // Spacing from edge
      belowOrigin: true, // Displays dropdown below the button
      alignment: 'right' // Displays dropdown with edge aligned to the left of button
  });

</script>
{include file="newEnd.tpl"}