<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
        <h2 style="text-align: center">All Report File</h2>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Report Type</th>
            <th scope="col">Report Name</th>
            <th scope="col">Report File</th>
            <th class="text-center" scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($file_data as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->report_type}}</td>
                <td>{{$data->report_name}}</td>
                <td>{{$data->report_file}}</td>

                <td class="text-center"><a title="View Report"  class="btn btn-raised btn-primary btn-sm" href="{{route('processfile', $data->id)}}"><i class="" aria-hidden="true"></i>view</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
