<!-- This page will be run through when user is heading to activity page. It will receive list of activities in database
     And all of them will be ran through as foreach loop to create table content -->
@foreach($activities as $activity)
  <tr>
    <td style="vertical-align:middle;">
        <b>{{$activity->actor}}</b>
        @if($activity->act == "deleted")
        <span style="color:#ff4444;">{{$activity->act}}</span>
        @elseif($activity->act == "uploaded" || $activity->act == "created")
        <span style="color:#00C851;">{{$activity->act}}</span>
      @elseif($activity->act == "changed" || $activity->act == "renamed")
        <span style="color:#33b5e5;">{{$activity->act}}</span>
        @endif
        {{$activity->object}}
        @if($activity->target)
          <kbd>{{$activity->target}}</kbd>
        @endif
        {{$activity->preposition}}
        @if($activity->result)
          <kbd>{{$activity->result}}</kbd></span>
        @endif
    </td>
    <td style="text-align:center;">
      <span>{{date_format($activity->created_at, 'd/m/Y')}}
      </span>
      <br>
      <span>{{date_format($activity->created_at, 'H:i')}}</span>
    </td>
@endforeach
