@extends('layouts.app')                                                                                             <!-- Define that this page extend layouts/app.blade.php -->
@section('content')                                                                                                 <!-- Define section named [Content] witch is included in app.blade.php page -->


<div class="container" style="margin-bottom:50px;">
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
      <tbody id="activityTable">
        <?php echo $activities; ?>
        </tbody>
      </table>
    </div>
  </div>
  <center><button class="btn btn-primary" type="button" id="loadMoreActivities" value="30">Load more</button></center>
</div>

@endsection
