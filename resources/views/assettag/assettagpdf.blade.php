<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style media="screen"> 
        table { 
            border-style: dotted;
            border-collapse: collapse; 
        } 
        table td { 
            /* padding: 0.5rem; */
            border-style: dotted;
            /* border: 2px solid;  */
        } 
        table th { 
            /* padding: 0.5rem;  */
            border-style: dotted;
            /* border: 2px solid;  */
        } 
    </style> 
</head>
<body>
    <div class="container">
        <table style="width:100%">
        <?php
        for($i=0;$i<5;$i++){
        ?>
        <tr>
            <td style="padding:6px;">
                <img src="{{$assetResult[0]->logo}}" alt="logo">
                <h3 style="text-transform:uppercase;">{{$assetResult[0]->asset_tag}}</h3>
                <span>{!!DNS1D::getBarcodeHTML($assetResult[0]->asset_id, 'C128')!!}</span>
            </td>
            <td style="padding:6px;">
                <img src="{{$assetResult[0]->logo}}" alt="logo">
                <h3 style="text-transform:uppercase;">{{$assetResult[0]->asset_tag}}</h3>
                <span>{!!DNS1D::getBarcodeHTML($assetResult[0]->asset_id, 'C128')!!}</span>
            </td>
            <td style="padding:6px;">
                <img src="{{$assetResult[0]->logo}}" alt="logo">
                <h3 style="text-transform:uppercase;">{{$assetResult[0]->asset_tag}}</h3>
                <span>{!!DNS1D::getBarcodeHTML($assetResult[0]->asset_id, 'C128')!!}</span>
            </td>
        </tr>
            {{-- <div style="clear:both;position: relative;margin-top:0.5%">
                <div style="position:absolute; left:0pt;width:172pt;border: 1px solid;border-style: dotted;padding:4px;">
                    <img src="{{$assetResult[0]->logo}}" alt="logo">
                    <h3 style="text-transform:uppercase;">{{$assetResult[0]->asset_tag}}</h3>
                    <span>{!!DNS1D::getBarcodeHTML($assetResult[0]->asset_tag, 'C128')!!}</span>
                </div>
                <div style="position:absolute;margin-left:185pt;width:172pt;border: 1px solid;border-style: dotted;padding:4px;">
                    <img src="{{$assetResult[0]->logo}}" alt="logo">
                    <h3 style="text-transform:uppercase;">{{$assetResult[0]->asset_tag}}</h3>
                    <span>{!!DNS1D::getBarcodeHTML($assetResult[0]->asset_tag, 'C128')!!}</span>
                </div>
                <div style="margin-left:370pt;width:172pt;border: 1px solid;border-style: dotted;padding:4px;">
                    <img src="{{$assetResult[0]->logo}}" alt="logo">
                    <h3 style="text-transform:uppercase;">{{$assetResult[0]->asset_tag}}</h3>
                    <span>{!!DNS1D::getBarcodeHTML($assetResult[0]->asset_tag, 'C128')!!}</span>
                </div>
            </div> --}}
            {{-- <br/> --}}
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>