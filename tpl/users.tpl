{include file="newbase.tpl" args=$header}
<main>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neuen Benutzer erstellen">
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
                    {if $page.filter != "Admin"}<li> <a href="?sort={$page.sort}&filter=Admin">Admins</a></li>{/if}
                    {if $page.filter != "Orga"}<li>  <a href="?sort={$page.sort}&filter=Orga">Orga</a></li>{/if}
                    {if $page.filter != "User"}<li>  <a href="?sort={$page.sort}&filter=User">User</a></li>{/if}
                </ul>
            </div>
            <ul class="collection col s12">
                {loop $page.items}
                    <li class="collection-item avatar">
                        <i class="material-icons circle {if $lvl == 4}red{elseif $lvl == 3}orange{elseif $lvl == 2}blue{elseif $lvl == 1}green{else}grey{/if}">person</i>
                        <span class="title">{$usrname}</span>
                        <p>{$prefix} {$usrname} | {$email}
                        </p>
                        <span class="secondary-content">
                            <a class="waves-effect waves-circle" href="users.php?action=edit&uID={$id}">
                                <i class="material-icons grey-text text-darken-1">create</i>
                            </a>
                            <a class="waves-effect waves-circle waves-red modal-trigger" href="#modal{$id}">
                                <i class="material-icons grey-text text-darken-1">delete</i>
                            </a>
                        </span>
                        <div id="modal{$id}" class="modal">
                            <div class="modal-content black-text">
                                <h4>L&ouml;schen</h4>
                                <p>M&ouml;chtest Du den Benutzer "{$usrname}" wirklich l&ouml;schen?</p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Abbrechen</a>
                                <a href="users.php?action=del&vID={$id}" class="modal-action modal-close waves-effect waves-green btn-flat red-text">L&ouml;schen</a>
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