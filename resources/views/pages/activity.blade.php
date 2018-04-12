@extends('layouts.app')                                                                                             <!-- Define that this page extend layouts/app.blade.php -->
@section('content')                                                                                                 <!-- Define section named [Content] witch is included in app.blade.php page -->


<div class="container">
    <h3>Activity Log</h3>

  <div class="panel panel-default" style="border-radius:0px; border:solid 1px #343d46;">
    <div class="panel-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th style="width:80%;">Activity</th>
            <th style="text-align:center;">Time</th>
          </tr>
        </thead>
      <tbody>
        @foreach($activities as $activity)
          <tr>
            <td style="vertical-align:middle;">{{$activity->actor}}
                {{$activity->act}}
                {{$activity->object}}
                @if($activity->target)
                  <kbd>{{$activity->target}}</kbd>
                @endif
                {{$activity->preposition}}
                @if($activity->result)
                  <kbd>{{$activity->result}}</kbd>
                @endif
            <td style="text-align:center;">
              <span>{{date_format($activity->created_at, 'd/m/Y')}}
              </span>
              <br>
              <span>{{date_format($activity->created_at, 'H:i')}}</span>
            </td>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
