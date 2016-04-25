{include file="newbase.tpl" args=$header}
<main>
    {if $page.type == ""}
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neue Person anlegen">
        <i class="large material-icons">add</i>
        </a>
    </div>{/if}
    <div class="container">
        <div class="row">
            <form class="col s12 {if $page.type != "Wanted"}m7{/if}" method="post" action="" id="live-search">
                <div class="row">
                    <div class="input-field col s12 ">
                        <i class="material-icons prefix">search</i>
                        <input id="filter" type="text" class="validate">
                        <label for="filter">In Benutzer suchen ...</label>
                    </div>
                </div>
            </form>
            {if $page.type != "Wanted" and $page.type != "Tracing" and $page.type != "bad"}<div class="col offset-s4 s4 offset-m1 m2 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a id="sortCurr" class='dropdown-button btn indigo' href='#' data-activates='dropdown0'><i class="mdi mdi-sort"></i></a>

                <!-- Dropdown Structure -->
                <ul id='dropdown0' class='dropdown-content'>
                    <li><a onclick="setSort('ascName');"> <i class="mdi mdi-sort-ascending"> </i> Name</a></li>
                    <li><a onclick="setSort('descName');"><i class="mdi mdi-sort-descending"></i> Name</a></li>
                    <li><a onclick="setSort('ascID');">   <i class="mdi mdi-sort-ascending"> </i> ID</a></li>
                    <li><a onclick="setSort('descID');">  <i class="mdi mdi-sort-descending"></i> ID</a></li>
                </ul>
            </div>
            <div class="col s4 m2 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a id="filterCurr" class='dropdown-button btn indigo' href='#' data-activates='dropdown'><i class="mdi mdi-filter"></i></a>

                <!-- Dropdown Structure -->
                <ul id='dropdown' class='dropdown-content'>
                    <li> <a onclick="setFilter('Alle');">Alle        </a></li>
                    <li> <a onclick="setFilter('Gesperrt');">Gesperrt</a></li>
                    <li> <a onclick="setFilter('Stufe05');">Stufe 5  </a></li>
                    <li> <a onclick="setFilter('Stufe06');">Stufe 6  </a></li>
                    <li> <a onclick="setFilter('Stufe07');">Stufe 7  </a></li>
                    <li> <a onclick="setFilter('Stufe08');">Stufe 8  </a></li>
                    <li> <a onclick="setFilter('Stufe09');">Stufe 9  </a></li>
                    <li> <a onclick="setFilter('Stufe10');">Stufe 10 </a></li>
                    <li> <a onclick="setFilter('Stufe11');">Stufe 11 </a></li>
                    <li> <a onclick="setFilter('Stufe12');">Stufe 12 </a></li>
                    <li> <a onclick="setFilter('Lehrer');">Lehrer    </a></li>
                    <li> <a onclick="setFilter('Visum');">Visum      </a></li>
                    <li> <a onclick="setFilter('Kurier');">Kurier    </a></li>
                </ul>
            </div>{elseif $page.type == "Tracing"}
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
                        <li><a onclick="setFilter('Active')"                >Aktiv                 </a></li>
                        <li><a onclick="setFilter('Inactive')"              >Inaktiv               </a></li>
                    </ul>
                </div>
            {elseif $page.type == "bad"}
                <div class="col offset-s4 s4 offset-m1 m2 right-align">
                    <br class="hide-on-small-only"/>
                    <!-- Dropdown Trigger -->
                    <a id="sortCurr" class='dropdown-button btn indigo' href='#' data-activates='dropdown0'></a>

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
                    <a id="filterCurr" class='dropdown-button btn indigo' href='#' data-activates='dropdown'></a>

                    <!-- Dropdown Structure -->
                    <ul id='dropdown' class='dropdown-content'>
                        <li><a id="currFilter"></a></li>
                        <li class="divider"></li>
                        <li> <a onclick="setFilter('Stufe05');">Stufe 5  </a></li>
                        <li> <a onclick="setFilter('Stufe06');">Stufe 6  </a></li>
                        <li> <a onclick="setFilter('Stufe07');">Stufe 7  </a></li>
                        <li> <a onclick="setFilter('Stufe08');">Stufe 8  </a></li>
                        <li> <a onclick="setFilter('Stufe09');">Stufe 9  </a></li>
                        <li> <a onclick="setFilter('Stufe10');">Stufe 10 </a></li>
                        <li> <a onclick="setFilter('Stufe11');">Stufe 11 </a></li>
                        <li> <a onclick="setFilter('Stufe12');">Stufe 12 </a></li>
                        <li> <a onclick="setFilter('Schüler');">Schüler   </a></li>
                    </ul>
                </div>
            {/if}
            <ul id="pages" class="pagination col s12 center">
            </ul>
            <ul class="collection col s12" id="citizens">
            </ul>
        </div>
    </div>
</main>
<script src="js/citizen{$page.type}.js" />
{include file="newEnd.tpl"}