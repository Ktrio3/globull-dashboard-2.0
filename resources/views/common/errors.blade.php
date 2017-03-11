@if (count($errors) > 0)
  <!-- Form Error List -->
  <div class="row">
    <div class="col-xs-12">
      <div class="alert alert-danger">
        <h3><span class="glyphicon glyphicon-alert"></span>&nbsp;&nbsp;Errors were encountered with your request:</h3>
        <ul>
          @foreach ($errors as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
@endif

@if (session('error'))
  <!-- Form Error List -->
  <div class="row">
    <div class="col-xs-12">
      <div class="alert alert-danger">
        <h3><span class="glyphicon glyphicon-alert"></span>&nbsp;&nbsp; {{session('error')}}</h3>
      </div>
    </div>
  </div>
@endif
