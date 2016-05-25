@extends('layouts.app')
@section('content')
<div class="container col-md-12">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">In Behandeling</div>
                  <div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                        <th>Gemaakt op</th>
                        <th>Tags</th>
                        <th>title</th>
                        <th>naam</th>
                        <th>Status</th>
                       @if($user->role == 1)  <th>button hier</th>@endif
                      </thead>
                      <tbody id="behandeling">
                     
                    </tbody>
                    </table>
                  </div>
            </div>
        </div>
    </div>
    <div class="container col-md-12">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Wachtrij</div>
                  <div class="panel-body">
                    <table class="table table-hover">
                      <thead>
                        <th>Gemaakt op</th>
                        <th>Tags</th>
                        <th>title</th>
                        <th>naam</th>
                        <th>Status</th>
                        @if($user->role == 1)<th>button hier</th>@endif
                      </thead>

                      <tbody id="open">

                    </tbody></table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
 var refInterval = window.setInterval('update()', 1500); // 30 seconds

var update = function() {
    $.ajax({
        type : 'GET',
        url : '/queue/ajax',
        success : InBehandeling});
};
update();

function InBehandeling(data){

  var loops = data.length;
  var open = document.getElementById("open");
   var behandelingen = document.getElementById("behandeling");
  behandelingen.innerHTML = "";
  open.innerHTML = "";
  //console.log(data[0].tag[0].tag_name);
    for (var i = 0; i < loops; i++){
      var total = -1
      var tags = "";
      total += data[i].tag.length;

      for (var t = 0; t <= total; t++){
    tags = tags+"<span class='label label-primary' style='background-color:#337ab7;'>" + data[i].tag[t].tag_name + "</span>  ";
}
    
    if(data[i].status === 1){

    var   behandeling = '<tr><td>' + data[i].created_at+'</td>'
        +'<td>' + tags + '</td>'
        +'<td>' + data[i].title + '</td>'
        +'<td>' + data[i].user.name +  '</td>'
        +'<td>' + data[i].status + '</td>'
        +'<?php if($user->role == 1){ ?> <td>' + '<a class="btn btn-primary" href="/queue/'+data[i].id+'">Afsluiten</a>' +'</td><?php } ?></tr>'; 
        
      // console.log(behandeling.length);
       
       behandelingen.innerHTML += behandeling;
     }

     if(data[i].status === 0){
    var   openingen = '<tr><td>' + data[i].created_at+'</td>'
        +'<td>' + tags + '</td>'
        +'<td>' + data[i].title + '</td>'
        +'<td>' + data[i].user.name +  '</td>'
        +'<td>' + data[i].status + '</td>'
        +'<?php if($user->role == 1){ ?> <td>' + '<a class="btn btn-primary" href="/queue/'+data[i].id+'">Behandelen</a>' +'</td><?php } ?></tr>'; 


        open.innerHTML += openingen;
       }  
     }

}



</script>
@endsection
