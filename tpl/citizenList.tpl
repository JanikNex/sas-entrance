{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <tr>
                        <th style="width: 30px; max-width: 30px;">#</th>
                        <th style="width: 90%; max-width: 90%;"></th>
                        <th style="width: 100px; max-width: 100px;"></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <tr>
                            <td>{$id}</td>
                            <td>
                                <div class="list-name">{$firstname} {$lastname} {if $inState == 1}<span class="live"><i class="mdi mdi-login-variant"></i></span>{else}<span class="invalid"><i class="mdi mdi-logout-variant"></i></span>{/if}</div>
                                <div class="list-type">{$classlevel} | <i class="mdi mdi-barcode"></i>{$barcode}</div>
                            </td>
                            <td style="">
                                <a href="citizen.php?action=edit&cID={$id}" class="normal"><i class="mdi mdi-pencil"></i></a>
                                <a href="citizen.php?action=viewLog&cID={$id}" class="normal"><i class="mdi mdi-format-list-bulleted"></i></a>
                                <a href="citizen.php?action=del&cID={$id}" class="normal"><i class="mdi mdi-delete"></i></a>
                            </td>
                        </tr>
                    {/loop}
            </table>
            <div style="position: fixed; bottom: 20px; right: 20px;">
                <div class="fab">
                </div>
            </div>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>