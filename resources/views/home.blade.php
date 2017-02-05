@extends('layouts.app')

@section('meta')
<meta name="Description" content="USF System Course Proposals tracking and submission.">
<meta name="Keywords" content="usf, system, course, proposal">
@endsection

@section('pagetitle') Welcome @endsection

@section('css')
<link rel="stylesheet" href="{{ url('css/home.min.css') }}" />
@endsection

@section('breadcrumbs')
<li class="last">Home</li>
@endsection

@section('js') @endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <p>Welcome to the integrated USF System Course Proposal site. This site is the official USF System course proposal site to be used by USF, USF St. Petersburg and USF Sarasota-Manatee faculty to propose new and changes to existing undergraduate and graduate courses.</p>
    <p>Integration of processes will be completed in phases. The current planned phases are:</p>
    <ol>
      <li>New &amp; Change Course Proposals (including General Education). <em>Launched: Fall 2016</em></li>
      <li>Curriculum proposals (including Majors/Programs, Minors, Certificates, and Accelerated Programs).</li>
      <li>General Education Recertifications.</li>
    </ol>
  </div>
</div>
<div class="row" style="margin-top:2em;">
  <div class="col-xs-4 text-left">
    <h2 class="w-name"><a href="{{ url('tracking') }}">Proposal Tracking</a></h2>
    <p><a href="{{ url('tracking') }}"><img src="{{ url('images/widget-tracking.jpg') }}" class="img-responsive" alt="Tracking Page"></a></p>
    <p class="text-left">View all proposals that have been submitted beginning with the 16/17 academic year. USF, USFSP, and USFSM course proposals are all listed on this tracking page. This is a public tracking page; no login is required.</p>
  </div>
  <div class="col-xs-4 text-left">
    <h2 class="w-name"><a href="{{ url('dashboard') }}">Proposal System Login</a></h2>
    <p><a href="{{ url('dashboard') }}"><img src="{{ url('images/widget-system-login.jpg') }}" class="img-responsive" alt="System Login"></a></p>
    <p class="text-left">Creation and modification of course proposals and the management of the course proposal process now via a secure dashboard. Login with you NetID is required and may be done here.</p>
  </div>
  <div class="col-xs-4 text-left">
    <h2 class="w-name"><a href="{{ url('resources') }}">Proposal Resources</a></h2>
    <p><a href="{{ url('resources') }}"><img src="{{ url('images/widget-resources.jpg') }}" class="img-responsive" alt="Resources"></a></p>
    <p class="text-left">Visit this section to view helpful resources such as syllabus guidelines, concurrency forms, Course Inventory link, SCNS link, etc. for preparing a course proposal. The resources section also provides documents from individual colleges such as signature pages.</p>
  </div>
</div>
@endsection
