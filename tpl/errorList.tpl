{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <form class="col s12 m7" method="post" action="" id="live-search">
                <div class="row">
                    <div class="input-field col s12 ">
                        <i class="material-icons prefix">search</i>
                        <input id="filter" type="text" class="validate">
                        <label for="filter">In Fehlern suchen ...</label>
                    </div>
                </div>
            </form>
            <div class="col offset-s4 s4 offset-m1 m2 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a id="currSort" class='dropdown-button btn indigo' href='#' data-activates='dropdown0'></a>

                <!-- Dropdown Structure -->
                <ul id='dropdown0' class='dropdown-content'>
                    <li><a onclick="setSort('ascDate')"> <i class="mdi mdi-sort-ascending"> </i> Datum</a></li>
                    <li><a onclick="setSort('descDate')"><i class="mdi mdi-sort-descending"></i> Datum</a></li>
                    <li><a onclick="setSort('ascID')">   <i class="mdi mdi-sort-ascending"> </i> ID</a></li>
                    <li><a onclick="setSort('descID')">  <i class="mdi mdi-sort-descending"></i> ID</a></li>
                </ul>
            </div>
            <div class="col s4 m2 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a id="currFilter" class='dropdown-button btn indigo' href='#' data-activates='dropdown'></a>

                <!-- Dropdown Structure -->
                <ul id='dropdown' class='dropdown-content'>
                    <li><a id="currFilter"></a></li>
                    <li class="divider"></li>
                    <li><a onclick="setFilter('Alle')"                  >Alle                  </a></li>
                    <li><a onclick="setFilter('INAlreadyCheckedIn')"    >INAlreadyCheckedIn    </a></li>
                    <li><a onclick="setFilter('OUTAlreadyCheckedOut')"  >OUTAlreadyCheckedOut  </a></li>
                    <li><a onclick="setFilter('OUTNoCheckOutYesterday')">OUTNoCheckOutYesterday</a></li>
                    <li><a onclick="setFilter('INCitizenLocked')"       >INCitizenLocked       </a></li>
                    <li><a onclick="setFilter('OUTCitizenLocked')"      >OUTCitizenLocked      </a></li>
                    <li><a onclick="setFilter('INCitizenWanted')"       >INCitizenWanted       </a></li>
                    <li><a onclick="setFilter('OUTCitizenWanted')"      >OUTCitizenWanted      </a></li>
                    <li><a onclick="setFilter('INNoCitizenFound')"      >INNoCitizenFound      </a></li>
                    <li><a onclick="setFilter('OUTNoCitizenFound')"     >OUTNoCitizenFound     </a></li>
                </ul>
            </div>
            <ul id="errors" class="collection col s12">

            </ul>
        </div>
    </div>
</main>
<script src="js/errors.js" />
{include file="newEnd.tpl"}