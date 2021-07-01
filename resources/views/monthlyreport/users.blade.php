<!DOCTYPE html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table>
<thread>
<tr>
<th>Province Name</th>
<th>Site Type Name</th>                      
<th>Site Name</th>
<th>Book No</th>
</tr>
</thread>
<tbody>
@foreach($users as $item)
<tr>
<td>{{$item->mr_id}}</td>
<td>{{$item->st_id}}</td>
<td>{{$item->provincesss_id}}</td>
<td>{{$item->algorithm_type}}</td>
</tr>
@endforeach
</tbody>
</table>
</body>
</html>