@extends('layouts.master')
@section('title', ' Topic' . ' ' . $topic->name)
@section('content')
<div class="container">

    <h1>{{ $topic->name }} - {{ $topic->id }}</h1>
</div>

@endsection
