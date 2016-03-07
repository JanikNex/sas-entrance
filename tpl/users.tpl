{include file="newbase.tpl" args=$header}
        <main>
            <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neuen Benutzer erstellen">
                <i class="large material-icons">add</i>
                </a>
            </div>
            <div class="container">
                <div class="row">
                    <ul class="collection">
                        {loop $page.items}
                            <li class="collection-item avatar">
                                <i class="material-icons circle {if $lvl == 2}red{elseif $lvl == 1}orange{else}grey{/if}">person</i>
                                <span class="title">{$usrname}</span>
                                <p>{$prefix} {$usrname} | {$email}
                                </p>
                                <span class="secondary-content">
                                    <a href="users.php?action=edit&uID={$id}">
                                        <i class="material-icons grey-text text-darken-1">create</i>
                                    </a>
                                    <a href="users.php?action=del&uID={$id}">
                                        <i class="material-icons grey-text text-darken-1">delete</i>
                                    </a>
                                </span>
                            </li>
                        {/loop}
                    </ul>
                </div>
            </div>
        </main>
{include file="newEnd.tpl"}