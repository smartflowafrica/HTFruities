@extends('frontend.default.layouts.master')
@section('title') Parfait Test @endsection
@section('contents')
<div class="container py-5">
    <h1>Test View</h1>
    <p>Bases Count: {{ $bases->count() }}</p>
    <p>Fruits Count: {{ $fruits->count() }}</p>
</div>
@endsection
