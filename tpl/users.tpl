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
                <a id="sortCurr" class='dropdown-button btn indigo' href='#' data-activates='dropdown0'><i class="mdi mdi-sort"></i></a>

                <!-- Dropdown Structure -->
                <ul id='dropdown0' class='dropdown-content'>
                    <li><a onclick="setSort('ascName')"> <i class="mdi mdi-sort-ascending"> </i> Name</a></li>
                    <li><a onclick="setSort('descName')"><i class="mdi mdi-sort-descending"></i> Name</a></li>
                    <li><a onclick="setSort('ascID')">   <i class="mdi mdi-sort-ascending"> </i> ID</a></li>
                    <li><a onclick="setSort('descID')">  <i class="mdi mdi-sort-descending"></i> ID</a></li>
                </ul>
            </div>
            <div class="col s4 m2 right-align">
                <br class="hide-on-small-only"/>
                <!-- Dropdown Trigger -->
                <a id="filterCurr" class='dropdown-button btn indigo' href='#' data-activates='dropdown'><i class="mdi mdi-filter"></i> {$page.filter}</a>

                <!-- Dropdown Structure -->
                <ul id='dropdown' class='dropdown-content'>
                    <li><a onclick="setFilter('Alle')">Alle</a></li>
                    <li><a onclick="setFilter('Admin')">Admin</a></li>
                    <li><a onclick="setFilter('Orga')">Orga</a></li>
                    <li><a onclick="setFilter('Polizei')">Polizei</a></li>
                    <li><a onclick="setFilter('Grenzer')">Grenzer</a></li>
                    <li><a onclick="setFilter('User')">User</a></li>
                </ul>
            </div>
            <ul id="pages" class="pagination col s12 center">
            </ul>
            <ul class="collection col s12" id="users">
            </ul>
            <div
        </div>
    </div>
</main>
<script src="js/users.js" />
{include file="newEnd.tpl"}