<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <div class="container text-center">
        <img src="{{$assetResult[0]->logo}}" alt="logo"><br/>
        <h2 style="text-transform:uppercase;">{{$assetResult[0]->asset_tag}}</h2>

        <div class="" style="border: 1px solid #a1a1a1;padding: 15px;">
            <div>{!!DNS1D::getBarcodeHTML($assetResult[0]->asset_tag, 'C128')!!}</div></br>
        </div>
        {{-- @php print_r($result); @endphp --}}
    </div>
</body>
</html>