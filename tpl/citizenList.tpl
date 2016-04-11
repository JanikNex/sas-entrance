{include file="newbase.tpl" args=$header}
<main>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neue Person anlegen">
        <i class="large material-icons">add</i>
        </a>
    </div>
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
                    {if $page.sort != "ascName"} <li><a href="?filter={$page.filter}&sort=ascName"> <i class="mdi mdi-sort-ascending"> </i> Name</a></li>{/if}
                    {if $page.sort != "descName"}<li><a href="?filter={$page.filter}&sort=descName"><i class="mdi mdi-sort-descending"></i> Name</a></li>{/if}
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
                    {if $page.filter != "Alle"}<li>  <a href="?sort={$page.sort}&filter=Alle">Alle</a></li>{/if}
                    {if $page.filter != "Gesperrt"}<li> <a href="?sort={$page.sort}&filter=Gesperrt">Gesperrt</a></li>{/if}
                    {if $page.filter != "Stufe05"}<li>  <a href="?sort={$page.sort}&filter=Stufe05" >Stufe05 </a></li>{/if}
                    {if $page.filter != "Stufe06"}<li>  <a href="?sort={$page.sort}&filter=Stufe06" >Stufe06 </a></li>{/if}
                    {if $page.filter != "Stufe07"}<li>  <a href="?sort={$page.sort}&filter=Stufe07" >Stufe07 </a></li>{/if}
                    {if $page.filter != "Stufe08"}<li>  <a href="?sort={$page.sort}&filter=Stufe08" >Stufe08 </a></li>{/if}
                    {if $page.filter != "Stufe09"}<li>  <a href="?sort={$page.sort}&filter=Stufe09" >Stufe09 </a></li>{/if}
                    {if $page.filter != "Stufe10"}<li>  <a href="?sort={$page.sort}&filter=Stufe10" >Stufe10 </a></li>{/if}
                    {if $page.filter != "Stufe11"}<li>  <a href="?sort={$page.sort}&filter=Stufe11" >Stufe11 </a></li>{/if}
                    {if $page.filter != "Stufe12"}<li>  <a href="?sort={$page.sort}&filter=Stufe12" >Stufe12 </a></li>{/if}
                    {if $page.filter != "Lehrer"} <li>  <a href="?sort={$page.sort}&filter=Lehrer"  >Lehrer  </a></li>{/if}
                    {if $page.filter != "Visum"}  <li>  <a href="?sort={$page.sort}&filter=Visum"   >Visum   </a></li>{/if}
                    {if $page.filter != "Kurier"} <li>  <a href="?sort={$page.sort}&filter=Kurier"  >Kurier  </a></li>{/if}
                </ul>
            </div>
            <ul class="collection col s12">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="material-icons circle {if $inState == 0}green{elseif $inState == 1}red{else}grey{/if}">person</i>
                        <span class="title">{$firstname} {$lastname}</span>
                        <p> {if $locked == 1}<span class="red-text"><b>!</b> Person gesperrt</span><br/>{/if}
                            {if $classlevel<=13}Klassenstufe {$classlevel}
                            {elseif $classlevel==14}Lehrer
                            {elseif $classlevel==15}Visum
                            {else}Kurier{/if}<br/>
                            {if $header.perm.citizen_info_difference == 1}
                                Zeit heute: {$timeToday} | Zeit gesamt: {$timeProject}
                            {/if}
                        </p>
                        <span class="secondary-content">
                            <a class="waves-effect waves-circle" href="citizen.php?action=edit&cID={$id}">
                                <i class="material-icons grey-text text-darken-1" style="margin: 0px 5px;">create</i>
                            </a>
                            <a class="waves-effect waves-circle" href="citizen.php?action=citizeninfo&cID={$id}" style="margin: 0px 5px;">
                                <i class="material-icons grey-text text-darken-1">reorder</i>
                            </a>
                            <a class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$id}" style="margin: 0px 5px;">
                                <i class="material-icons grey-text text-darken-1">delete</i>
                            </a>
                        </span>
                        <div id="modal{$id}" class="modal">
                            <div class="modal-content black-text">
                                <h4>L&ouml;schen</h4>
                                <p>M&ouml;chtest Du die Person "{$firstname} {$lastname}" wirklich l&ouml;schen?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                <a href="citizen.php?action=del&cID={$id}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
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