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
      <a class="navbar-brand" href="{{ url('dashboard') }}">Dashboard</a>
    </div>

    <div class="collapse navbar-collapse" id="dashboard-navbar-collapse">
      <ul class="nav navbar-nav">
        <li><a href="{{ route('proposal.start') }}"><span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;Create a Proposal</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;My Proposals</a></li>
        @if (View::exists('dashboard.navbar.role-' . Auth::user()->role_id))
          @include ('dashboard.navbar.role-' . Auth::user()->role_id)
        @endif
      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-question-sign" aria-label="Help"></span> <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ url('documents/usf-system-course-proposals-college-user-guide.pdf') }}" target="_blank">College Administrator User Guide</a></li>
                <li><a href="{{ url('documents/usf-system-course-proposals-council-support-user-guide.pdf') }}" target="_blank">Council Support Staff User Guide</a></li>
                <li><a href="{{ url('documents/usf-system-course-proposals-council-reviewer-user-guide.pdf') }}" target="_blank">Council Reviewer User Guide</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{ Auth::user()->netid }} <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
