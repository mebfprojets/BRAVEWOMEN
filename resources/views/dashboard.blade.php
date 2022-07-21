@extends("layouts.dashboard")
@section('dashboard', 'active')
@section('dashboardss', 'active')
@section('content')
@include('partials.admin._entete_dashboard')
<div id="indicateur1" style="width: 50%; float: left">
</div>
<div id="indicateur2" style="width: 50%; float: left">
</div>
{{-- <div id="indicateur3" style="width: 40%; float: left">
</div> --}}

@endsection
