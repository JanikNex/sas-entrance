<page>
<table border="1" style="border-collapse:collapse; text-align: center">
    <tr>
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[0].roll[0] == ""}<br/>{/if}
                            {if $data[0].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[0].name}</span><br/>
                            <span style="font-size: 4mm">{$data[0].firstname}</span><br/>
                            {if $data[0].roll[0] != ""}<span style="font-size: 2mm">{$data[0].roll[0]}</span><br/>{/if}
                            {if $data[0].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[0].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[0].classlevel != 14}<barcode type="CODABAR" value="{$data[0].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[0].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {if $size >= 2}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[1].roll[0] == ""}<br/>{/if}
                            {if $data[1].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[1].name}</span><br/>
                            <span style="font-size: 4mm">{$data[1].firstname}</span><br/>
                            {if $data[1].roll[0] != ""}<span style="font-size: 2mm">{$data[1].roll[0]}</span><br/>{/if}
                            {if $data[1].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[1].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[1].classlevel != 14}<barcode type="CODABAR" value="{$data[1].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[1].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 3}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[2].roll[0] == ""}<br/>{/if}
                            {if $data[2].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[2].name}</span><br/>
                            <span style="font-size: 4mm">{$data[2].firstname}</span><br/>
                            {if $data[2].roll[0] != ""}<span style="font-size: 2mm">{$data[2].roll[0]}</span><br/>{/if}
                            {if $data[2].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[2].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[2].classlevel != 14}<barcode type="CODABAR" value="{$data[2].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[2].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}{if $size >= 4}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[3].roll[0] == ""}<br/>{/if}
                            {if $data[3].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[3].name}</span><br/>
                            <span style="font-size: 4mm">{$data[3].firstname}</span><br/>
                            {if $data[3].roll[0] != ""}<span style="font-size: 2mm">{$data[3].roll[0]}</span><br/>{/if}
                            {if $data[3].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[3].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[3].classlevel != 14}<barcode type="CODABAR" value="{$data[3].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[3].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 5}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[4].roll[0] == ""}<br/>{/if}
                            {if $data[4].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[4].name}</span><br/>
                            <span style="font-size: 4mm">{$data[4].firstname}</span><br/>
                            {if $data[4].roll[0] != ""}<span style="font-size: 2mm">{$data[4].roll[0]}</span><br/>{/if}
                            {if $data[4].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[4].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[4].classlevel != 14}<barcode type="CODABAR" value="{$data[4].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[4].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}{if $size >= 6}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[5].roll[0] == ""}<br/>{/if}
                            {if $data[5].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[5].name}</span><br/>
                            <span style="font-size: 4mm">{$data[5].firstname}</span><br/>
                            {if $data[5].roll[0] != ""}<span style="font-size: 2mm">{$data[5].roll[0]}</span><br/>{/if}
                            {if $data[5].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[5].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[5].classlevel != 14}<barcode type="CODABAR" value="{$data[5].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[5].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 7}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[6].roll[0] == ""}<br/>{/if}
                            {if $data[6].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[6].name}</span><br/>
                            <span style="font-size: 4mm">{$data[6].firstname}</span><br/>
                            {if $data[6].roll[0] != ""}<span style="font-size: 2mm">{$data[6].roll[0]}</span><br/>{/if}
                            {if $data[6].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[6].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[6].classlevel != 14}<barcode type="CODABAR" value="{$data[6].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[6].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}{if $size >= 8}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[7].roll[0] == ""}<br/>{/if}
                            {if $data[7].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[7].name}</span><br/>
                            <span style="font-size: 4mm">{$data[7].firstname}</span><br/>
                            {if $data[7].roll[0] != ""}<span style="font-size: 2mm">{$data[7].roll[0]}</span><br/>{/if}
                            {if $data[7].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[7].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[7].classlevel != 14}<barcode type="CODABAR" value="{$data[7].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[7].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 9}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[8].roll[0] == ""}<br/>{/if}
                            {if $data[8].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[8].name}</span><br/>
                            <span style="font-size: 4mm">{$data[8].firstname}</span><br/>
                            {if $data[8].roll[0] != ""}<span style="font-size: 2mm">{$data[8].roll[0]}</span><br/>{/if}
                            {if $data[8].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[8].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[8].classlevel != 14}<barcode type="CODABAR" value="{$data[8].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[8].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
        {if $size >= 10}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[9].roll[0] == ""}<br/>{/if}
                            {if $data[9].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[9].name}</span><br/>
                            <span style="font-size: 4mm">{$data[9].firstname}</span><br/>
                            {if $data[9].roll[0] != ""}<span style="font-size: 2mm">{$data[9].roll[0]}</span><br/>{/if}
                            {if $data[9].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[9].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[9].classlevel != 14}<barcode type="CODABAR" value="{$data[9].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[9].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 11}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[10].roll[0] == ""}<br/>{/if}
                            {if $data[10].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[10].name}</span><br/>
                            <span style="font-size: 4mm">{$data[10].firstname}</span><br/>
                            {if $data[10].roll[0] != ""}<span style="font-size: 2mm">{$data[10].roll[0]}</span><br/>{/if}
                            {if $data[10].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[10].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[10].classlevel != 14}<barcode type="CODABAR" value="{$data[10].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[10].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
        {if $size >= 12}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[11].roll[0] == ""}<br/>{/if}
                            {if $data[11].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[11].name}</span><br/>
                            <span style="font-size: 4mm">{$data[11].firstname}</span><br/>
                            {if $data[11].roll[0] != ""}<span style="font-size: 2mm">{$data[11].roll[0]}</span><br/>{/if}
                            {if $data[11].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[11].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[11].classlevel != 14}<barcode type="CODABAR" value="{$data[11].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[11].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 13}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[12].roll[0] == ""}<br/>{/if}
                            {if $data[12].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[12].name}</span><br/>
                            <span style="font-size: 4mm">{$data[12].firstname}</span><br/>
                            {if $data[12].roll[0] != ""}<span style="font-size: 2mm">{$data[12].roll[0]}</span><br/>{/if}
                            {if $data[12].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[12].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[12].classlevel != 14}<barcode type="CODABAR" value="{$data[12].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[12].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
        {if $size >= 14}
            <td style="width: 45.00mm; height: 20mm; padding-left: 5mm; padding-right: 2mm; max-height: 20mm; max-width: 45.00mm;">
                <table>
                    <tr style="height: 5mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 16mm;">
                        <td style="width: 36.00mm;">
                            {if $data[13].roll[0] == ""}<br/>{/if}
                            {if $data[13].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 4mm">{$data[13].name}</span><br/>
                            <span style="font-size: 4mm">{$data[13].firstname}</span><br/>
                            {if $data[13].roll[0] != ""}<span style="font-size: 2mm">{$data[13].roll[0]}</span><br/>{/if}
                            {if $data[13].roll[1] != ""}<span style="font-size: 2mm">Weisungsbefugnis: {$data[13].roll[1]}</span>{/if}<br/>
                            {if $mode == "work"}<span style="font-size: 4mm; font-weight: bold">Dienstausweis</span>{/if}
                        </td>
                        <td>
                            <img src="{$IP}/entrance/Schlopolis.png" style="position: fixed; top: 0; right: 0; height: 23mm; width: 23mm" /><br/>
                            {if $mode == "normal" and $data[13].classlevel != 14}<barcode type="CODABAR" value="{$data[13].barcode}" label="label" style="width:28mm; height:9mm; color: #000000; font-size: 2mm"></barcode>
                            {elseif $mode == "normal" and $data[13].classlevel == 14}<barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {else} <barcode type="CODABAR" value="0000000000000" label="label" style="width:28mm; height:9mm; color: #FFFFFF; font-size: 2mm"></barcode>
                            {/if}
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
</table>
</page>