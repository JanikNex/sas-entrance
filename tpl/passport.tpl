<page>
<table border="1" style="border-collapse:collapse; text-align: center">
    <tr>
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[0].roll[0] == ""}<br/>{/if}
                            {if $data[0].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[0].name}</span><br/>
                            <span style="font-size: 5mm">{$data[0].firstname}</span><br/><br/>
                            {if $data[0].roll[0] != ""}<span style="font-size: 3mm">{$data[0].roll[0]}</span><br/><br/>{/if}
                            {if $data[0].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[0].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[0].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {if $size >= 2}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[1].roll[0] == ""}<br/>{/if}
                            {if $data[1].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[1].name}</span><br/>
                            <span style="font-size: 5mm">{$data[1].firstname}</span><br/><br/>
                            {if $data[1].roll[0] != ""}<span style="font-size: 3mm">{$data[1].roll[0]}</span><br/><br/>{/if}
                            {if $data[1].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[1].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[1].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 3}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[2].roll[0] == ""}<br/>{/if}
                            {if $data[2].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[2].name}</span><br/>
                            <span style="font-size: 5mm">{$data[2].firstname}</span><br/><br/>
                            {if $data[2].roll[0] != ""}<span style="font-size: 3mm">{$data[2].roll[0]}</span><br/><br/>{/if}
                            {if $data[2].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[2].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[2].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}{if $size >= 4}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[3].roll[0] == ""}<br/>{/if}
                            {if $data[3].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[3].name}</span><br/>
                            <span style="font-size: 5mm">{$data[3].firstname}</span><br/><br/>
                            {if $data[3].roll[0] != ""}<span style="font-size: 3mm">{$data[3].roll[0]}</span><br/><br/>{/if}
                            {if $data[3].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[3].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[3].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 5}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[4].roll[0] == ""}<br/>{/if}
                            {if $data[4].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[4].name}</span><br/>
                            <span style="font-size: 5mm">{$data[4].firstname}</span><br/><br/>
                            {if $data[4].roll[0] != ""}<span style="font-size: 3mm">{$data[4].roll[0]}</span><br/><br/>{/if}
                            {if $data[4].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[4].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[4].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}{if $size >= 6}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[5].roll[0] == ""}<br/>{/if}
                            {if $data[5].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[5].name}</span><br/>
                            <span style="font-size: 5mm">{$data[5].firstname}</span><br/><br/>
                            {if $data[5].roll[0] != ""}<span style="font-size: 3mm">{$data[5].roll[0]}</span><br/><br/>{/if}
                            {if $data[5].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[5].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[5].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 7}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[6].roll[0] == ""}<br/>{/if}
                            {if $data[6].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[6].name}</span><br/>
                            <span style="font-size: 5mm">{$data[6].firstname}</span><br/><br/>
                            {if $data[6].roll[0] != ""}<span style="font-size: 3mm">{$data[6].roll[0]}</span><br/><br/>{/if}
                            {if $data[6].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[6].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[6].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}{if $size >= 8}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[7].roll[0] == ""}<br/>{/if}
                            {if $data[7].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[7].name}</span><br/>
                            <span style="font-size: 5mm">{$data[7].firstname}</span><br/><br/>
                            {if $data[7].roll[0] != ""}<span style="font-size: 3mm">{$data[7].roll[0]}</span><br/><br/>{/if}
                            {if $data[7].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[7].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[7].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
    <tr>
        {if $size >= 9}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[8].roll[0] == ""}<br/>{/if}
                            {if $data[8].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[8].name}</span><br/>
                            <span style="font-size: 5mm">{$data[8].firstname}</span><br/><br/>
                            {if $data[8].roll[0] != ""}<span style="font-size: 3mm">{$data[8].roll[0]}</span><br/><br/>{/if}
                            {if $data[8].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[8].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[8].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}{if $size >= 10}
            <td style="width: 65.60mm; height: 52.98mm; padding-left: 5mm; max-height: 53.98mm; max-width: 65.50mm;">
                <table>
                    <tr style="height: 10mm;"><td colspan="2" style="font-size: 4mm">Staat Schlopolis - Ausweis</td></tr>
                    <tr style="height: 42.98mm;">
                        <td style="width: 40.60mm;">
                            <br/>
                            {if $data[9].roll[0] == ""}<br/>{/if}
                            {if $data[9].roll[1] == ""}<br/>{/if}
                            <span style="font-size: 5mm">{$data[9].name}</span><br/>
                            <span style="font-size: 5mm">{$data[9].firstname}</span><br/><br/>
                            {if $data[9].roll[0] != ""}<span style="font-size: 3mm">{$data[9].roll[0]}</span><br/><br/>{/if}
                            {if $data[9].roll[1] != ""}<span style="font-size: 3mm">Weisungsbefugnis: {$data[9].roll[1]}</span><br/><br/>{/if}
                            {if $mode == "normal"}<barcode type="CODABAR" value="{$data[9].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
                            {else}<span style="font-size: 13mm">DIENSTAUSWEIS</span>
                            {/if}
                        </td>
                        <td style="width: 25mm;">
                            <img src="http://entrance.yannickfelix.tk/Schlopolis.png" style="position: fixed; top: 0; right: 0;" />
                        </td>
                    </tr>
                </table>
            </td>
        {/if}
    </tr>
</table>
</page>