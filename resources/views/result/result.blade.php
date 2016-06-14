@extends('layouts.app')
@extends('layouts.menu')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profiel</div>
                  <div class="panel-body">
                      <table class="table table-hover table-striped">
                        <h4> Hier wordt laten zien hoevaak leerlingen in de queue hebben gestaan. </h4>
                        <thead>
                          <th>Naam</th>
                          <th>Aantalvragen</th>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                          <tr>
                            <td style="text-transform:capitalize;"><a href="/profile/<?=$user->id?>"><?=$user->name?></a></td>
                            <?php 
                                  $subs = $user->queueCommentCount->first() ?>
                              <td class="text-center">
                                @if($subs == null)
                                  {{'0'}}
                                @else
                                  {{$subs['aggregate']}}
                                @endif
                            <td> 
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
