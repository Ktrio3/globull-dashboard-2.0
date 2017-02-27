@if (isset($sticky_nav) AND $sticky_nav)
<nav class="navbar navbar-default navbar-static-top affix">
@else
<nav class="navbar navbar-default navbar-static-top" data-spy="affix" data-offset-top="354">
@endif
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#dashboard-navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('admin.index') }}">Dashboard</a>
    </div>

    <div class="collapse navbar-collapse" id="dashboard-navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="{{ route('admin.students') }}"><span class="glyphicon glyphicon-education"></span>&nbsp;&nbsp;Students</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;Statistics</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('student-types.index') }}">Student Types</a></li>
            <li><a href="{{ route('attribute-types.index') }}">Attribute Types</a></li>
            <li><a href="{{ route('attributes.index') }}">Attributes</a></li>
            <li><a href="{{ route('admin.preview') }}">Preview</a></li>
          </ul>
        </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        @for($i = 5; $i >= Auth::user()->role_id; $i--)
          @if (View::exists('admin.navbar.role-' . $i))
            @include ('admin.navbar.role-' . $i)
          @endif
        @endfor
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ Auth::user()->netid }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('admin.index', ['logout' => 1]) }}">Logout</a></li>
            </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
