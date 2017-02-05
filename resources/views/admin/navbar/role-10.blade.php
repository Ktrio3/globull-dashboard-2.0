<li><a href="{{ url('dashboard/queue') }}"><span class="glyphicon glyphicon-inbox"></span>&nbsp;&nbsp;Work Queue <span class="badge">#</span></a></li>
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;Admin <span class="caret"></span></a>
  <ul class="dropdown-menu">
    <li><a href="{{ url('dashboard/admin/proposals') }}">All Proposals <span class="badge">#</span></a></li>
    <li><a href="{{ url('dashboard/admin/proposals/other/course-form') }}">Upload Course Form</a></li>
    <li><a href="{{ url('dashboard/admin/proposals/other/usfsp-new-to-inst') }}">USF St. Petersburg Curriculum New Course Proposals Upload Form</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="{{ route('users.index') }}">User Management</a></li>
    <li><a href="{{ url('dashboard/admin/groups') }}">Group Management</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="{{ route('workflows.index') }}">Workflow Management</a></li>
    <li><a href="{{ route('workflow-steps.index') }}">Workflow Step Management</a></li>
    <li><a href="{{ route('workflow-step-templates.index') }}">Workflow Step Template Management</a></li>
    <li><a href="{{ route('workflow-options.index') }}">Workflow Option Management</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="{{ route('scripts.index') }}">Workflow Script Management</a></li>
    <li><a href="{{ route('views.index') }}">Workflow View Management</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="{{ route('statuses.index') }}">Workflow Status Management</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="{{ route('emails.index') }}">Email Management</a></li>
    <li><a href="{{ route('email_templates.index') }}">Email Template Management</a></li>
  </ul>
</li>
