@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recente leervragen</div>
                  <div class="panel-body">
                    <body>

                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
