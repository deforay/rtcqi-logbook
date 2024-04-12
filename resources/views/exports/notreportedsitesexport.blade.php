<table style="border: 3px solid black">
    <thead style="border: 3px solid black">
        <tr>            
            <td colspan="6" style="border: 3px solid black;font-weight:bold;">Not Reported Sites Report</td>
        </tr>
        <tr style="border: 3px solid black">
            <th style="border: 3px solid black;font-weight:bold;">Site Name</th>
            <th style="border: 3px solid black;font-weight:bold;">Site ID</th>
            <th style="border: 3px solid black;font-weight:bold;">Email</th>
            <th style="border: 3px solid black;font-weight:bold;">Phone</th>
            <th style="border: 3px solid black;font-weight:bold;">Province</th>
            <th style="border: 3px solid black;font-weight:bold;">District</th>
            <th style="border: 3px solid black;font-weight:bold;">Sub-District</th>
            <th style="border: 3px solid black;font-weight:bold;">Last Modified On</th>
            
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>            
        </tr>
    </thead>
    <tbody style="border: 3px solid black">
        @foreach($report as $notreportedsitesrow)
        
        <tr style="border: 3px solid black">
            <td style="border: 3px solid black">{{ $notreportedsitesrow->site_name }}</td>
            <td style="border: 3px solid black">{{ $notreportedsitesrow->ts_id }}</td>
            <td style="border: 3px solid black">{{ $notreportedsitesrow->site_primary_email }}</td>
            <td style="border: 3px solid black">{{ $notreportedsitesrow->site_primary_mobile_no }}</td>
            <td style="border: 3px solid black">{{ $notreportedsitesrow->province_name }}</td>
            <td style="border: 3px solid black">{{ $notreportedsitesrow->district_name }}</td>
            <td style="border: 3px solid black;;text-align: left;">{{ $notreportedsitesrow->sub_district_name }}</td>
            <td style="border: 3px solid black">{{ $notreportedsitesrow->added_on }}</td>
        </tr>
        @endforeach
    </tbody>
</table>