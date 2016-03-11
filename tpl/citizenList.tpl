{include file="newbase.tpl" args=$header}
<main>
            <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
                <a href="?action=new" class="btn-floating btn-large green tooltipped"  data-position="left" data-delay="50" data-tooltip="Neue Person anlegen">
                <i class="large material-icons">add</i>
                </a>
            </div>
            <div class="container">
                <div class="row">
                    <ul class="collection">
                        {loop $page.items}
                            <li class="collection-item avatar">
                                <i class="material-icons circle {if $inState == 0}green{elseif $inState == 1}red{else}grey{/if}">person</i>
                                <span class="title">{$firstname} {$lastname}</span>
                                <p> {if $locked == 1}<span class="red-text"><b>!</b> Person gesperrt</span><br/>{/if}
                                    {if $classlevel<=13}Klassenstufe {$classlevel}
                                    {elseif $classlevel==14}Lehrer
                                    {elseif $classlevel==15}Visum
                                    {else}Kurier{/if}<br/>
                                    Zeit heute: {$timeToday} | Zeit gesamt: {$timeProject}
                                </p>
                                <span class="secondary-content">
                                    <a href="citizen.php?action=edit&cID={$id}">
                                        <i class="material-icons grey-text text-darken-1" style="margin: 0px 5px;">create</i>
                                    </a>
                                    <a href="citizen.php?action=citizeninfo&cID={$id}" style="margin: 0px 5px;">
                                        <i class="material-icons grey-text text-darken-1">reorder</i>
                                    </a>
                                    <a href="citizen.php?action=del&cID={$id}" style="margin: 0px 5px;">
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