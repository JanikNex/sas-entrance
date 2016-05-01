<table border="1" style="border-collapse:collapse; text-align: center" >
    <tr>
        <td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[0].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[0].name}</span><br/>
            <span style="font-size: 5mm">{$data[0].firstname}</span><br/><br/>
            {if $data[0].roll != ""}<span style="font-size: 5mm">{$data[0].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[0].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}
        </td>
        {if $size >= 2}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[1].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[1].name}</span><br/>
            <span style="font-size: 5mm">{$data[1].firstname}</span><br/>
            {if $data[1].roll != ""}<span style="font-size: 5mm">{$data[1].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[1].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
    </tr>
    <tr>
        {if $size >= 3}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[2].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[2].name}</span><br/>
            <span style="font-size: 5mm">{$data[2].firstname}</span><br/>
            {if $data[2].roll != ""}<span style="font-size: 5mm">{$data[2].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[2].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
        {if $size >= 4}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[3].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[3].name}</span><br/>
            <span style="font-size: 5mm">{$data[3].firstname}</span><br/>
            {if $data[3].roll != ""}<span style="font-size: 5mm">{$data[3].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[3].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
    </tr>
    <tr>
        {if $size >= 5}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[4].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[4].name}</span><br/>
            <span style="font-size: 5mm">{$data[4].firstname}</span><br/>
            {if $data[4].roll != ""}<span style="font-size: 5mm">{$data[4].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[4].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
        {if $size >= 6}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[5].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[5].name}</span><br/>
            <span style="font-size: 5mm">{$data[5].firstname}</span><br/>
            {if $data[5].roll != ""}<span style="font-size: 5mm">{$data[5].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[5].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
    </tr>
    <tr>
        {if $size >= 7}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[6].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[6].name}</span><br/>
            <span style="font-size: 5mm">{$data[6].firstname}</span><br/>
            {if $data[6].roll != ""}<span style="font-size: 5mm">{$data[6].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[6].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
        {if $size >= 8}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[7].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[7].name}</span><br/>
            <span style="font-size: 5mm">{$data[7].firstname}</span><br/>
            {if $data[7].roll != ""}<span style="font-size: 5mm">{$data[7].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[7].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
    </tr>
    <tr>
        {if $size >= 9}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[8].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[8].name}</span><br/>
            <span style="font-size: 5mm">{$data[8].firstname}</span><br/>
            {if $data[8].roll != ""}<span style="font-size: 5mm">{$data[8].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[8].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
        {if $size >= 10}<td style="width: 65.60mm; height: 52.98mm; padding-left: 10mm">
            <span style="font-size: 4mm">Staat Schlopolis - Ausweiskarte</span>
            <br/>
            <br/>
            {if $data[9].roll == ""}<br/>{/if}
            <span style="font-size: 5mm">{$data[9].name}</span><br/>
            <span style="font-size: 5mm">{$data[9].firstname}</span><br/>
            {if $data[9].roll != ""}<span style="font-size: 5mm">{$data[9].roll}</span><br/><br/>{/if}
            <barcode type="CODABAR" value="{$data[9].barcode}" label="label" style="width:31mm; height:13mm; color: #000000; font-size: 3mm"></barcode>
            {*<img src="../Schlopolis.png" style="float: right">*}</td>{/if}
    </tr>
</table>