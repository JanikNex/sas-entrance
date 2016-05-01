<table border="1" style="border-collapse:collapse" >
    <tr>
        <td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[0].name}</p>
            <p>{$data[0].firstname}</p>
            <barcode type="CODABAR" value="{$data[0].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png">
        </td>
        {if $size >= 2}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[1].name}</p>
            <p>{$data[1].firstname}</p>
            <barcode type="CODABAR" value="{$data[1].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
    </tr>
    <tr>
        {if $size >= 3}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[2].name}</p>
            <p>{$data[2].firstname}</p>
            <barcode type="CODABAR" value="{$data[2].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
        {if $size >= 4}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[3].name}</p>
            <p>{$data[3].firstname}</p>
            <barcode type="CODABAR" value="{$data[3].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
    </tr>
    <tr>
        {if $size >= 5}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[4].name}</p>
            <p>{$data[4].firstname}</p>
            <barcode type="CODABAR" value="{$data[4].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
        {if $size >= 6}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[5].name}</p>
            <p>{$data[5].firstname}</p>
            <barcode type="CODABAR" value="{$data[5].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
    </tr>
    <tr>
        {if $size >= 7}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[6].name}</p>
            <p>{$data[6].firstname}</p>
            <barcode type="CODABAR" value="{$data[6].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
        {if $size >= 8}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[7].name}</p>
            <p>{$data[7].firstname}</p>
            <barcode type="CODABAR" value="{$data[7].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
    </tr>
    <tr>
        {if $size >= 9}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[8].name}</p>
            <p>{$data[8].firstname}</p>
            <barcode type="CODABAR" value="{$data[8].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
        {if $size >= 10}<td style="width: 85.60mm; height: 53.98mm;">
            <p>Staat Schlopolis - Ausweiskarte</p><br/>
            <p>{$data[9].name}</p>
            <p>{$data[9].firstname}</p>
            <barcode type="CODABAR" value="{$data[9].barcode}" label="label" style=\"width:52mm; height:14mm; color: #000000; font-size: 4mm\"></barcode>
            <img src="../Schlopolis.png"></td>{/if}
    </tr>
</table>