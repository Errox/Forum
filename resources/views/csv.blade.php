@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recente leervragen</div>
                  <div class="panel-body centerd">
                    <h1 style="color: red">ALLEEN CSV BESTANDEN</h1>
                      <?php
                          function readCSV($csvFile){
  $file_handle = fopen($csvFile, 'r');
  while (!feof($file_handle) ) {
    $line_of_text[] = fgetcsv($file_handle, 1024);
  }
  fclose($file_handle);
  return $line_of_text;
}


// Set path to CSV file
$csvFile = 'test.csv';

$csv = readCSV($csvFile);
echo '<pre>';
print_r($csv);
echo '</pre>';
                      ?>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
