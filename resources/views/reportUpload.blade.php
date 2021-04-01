<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>
                    {{$error}}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<h1 style="text-align: center; margin-top:30px; margin-bottom:20px">Upload Test Report</h1>
<!-- Form start -->
<form style="margin-left: 40px; margin-right:40px" action="{{route('createreportprocess')}}" method="post" enctype="multipart/form-data" class="register-form" id="appointment-form">
    {{csrf_field()}}
    <div class="row">

        <!-- Text input patient ID-->
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="report_type"><b>Select Report Type</b></label>
                <select id="report_type" name="report_type" required class="form-control">
                    <option value="CBC">CBC</option>
                    <option value="DLC">DLC</option>
                    <option value="ALC">ALC</option>
                </select>
            </div>
        </div>
        <!-- Text Writer Complication -->

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="report_name"><b>Report Name</b></label>
                <div class="form-group">
                    <input type="text" name="report_name" class="form-control" id="report_name" required placeholder="Write Report Name">
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <label class="control-label" for="report_file"><b>Upload PDF Report File</b></label>
            <br>
            <input type="file" id="report_file" name="report_file" required>
        </div>

        <!-- Button -->
        <div class="col-md-12">
            <div class="form-group form-button">
                <br>
                <input type="submit" name="signup" id="signup" class="form-submit" value="Submit"/>
            </div>
        </div>
    </div>
</form>
<!-- Appointment end -->
</body>

</html>
