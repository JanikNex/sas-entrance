{include file="newbase.tpl" args=$header}
<main>
            <div class="container">
                <div class="row">
                    <ul class="collection">
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
                                    @Citizen: [#{$cID}]{$citizenName}</span>
                                <p>
                                    {$timestamp}
                                </p>
                                <span class="secondary-content">
                                    <a href="errors.php?action=correctThis&eID={$eID}">
                                        <i class="material-icons grey-text text-darken-1" style="margin: 0px 5px;">done</i>
                                    </a>
                                    <a href="errors.php?action=del&eID={$eID}" style="margin: 0px 5px;">
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