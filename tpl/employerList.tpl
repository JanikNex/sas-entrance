{include file="newbase.tpl" args=$header}
<main>
    <div class="container">
        <div class="row">
            <form class="col s12" method="post" action="" id="live-search">
                <div class="row">
                    <div class="input-field col s12 ">
                        <i class="material-icons prefix">search</i>
                        <input id="filter" type="text" class="validate">
                        <label for="filter">In Betrieben suchen ...</label>
                    </div>
                </div>
            </form>
            <ul id="pages" class="pagination col s12 center center-align">
            </ul>
            <div id="modals">

            </div>
            <table class="highlight">
                <thead>
                <tr>
                    <th data-field="id">ID</th>
                    <th data-field="name">Name</th>
                    <th data-field="kind">Typ</th>
                    <th data-field="room">Raum</th>
                </tr>
                </thead>
                <tbody id="employer">

                </tbody>
            </table>
        </div>
    </div>
</main>
<script src="js/employer.js" />
{include file="newEnd.tpl"}
