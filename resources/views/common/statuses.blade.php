@if (session('status'))
  <!-- Form Error List -->
  <div class="row">
    <div class="col-xs-12">
      <div class="alert alert-success">
        <h3><span class="glyphicon glyphicon-alert"></span>&nbsp;&nbsp; {{session('status')}}<?php session()->forget('status')?></h3>
      </div>
    </div>
  </div>
@endif


@if (isset($success))
  <!-- Form Error List -->
  <div class="row">
    <div class="col-xs-12">
      <div class="alert alert-success">
        <h3><span class="glyphicon glyphicon-alert"></span>&nbsp;&nbsp; {{$success}}</h3>
      </div>
    </div>
  </div>
@endif
