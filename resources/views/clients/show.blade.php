@extends('layouts.app')

@section('content')
<div class="container">
    <client-show :client='@json($client)'></client-show>
</div>
@endsection