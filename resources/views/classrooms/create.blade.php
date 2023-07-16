@extends('layouts.master')
@section('title', 'Create Classroom')
@section('content')
    <div class="container">

        <h1>Create Classroom</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('classrooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- {{ csrf_filed() }} --}}
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
            @include('classrooms._form', [
                'button_label' => 'Create Room',
            ])

        </form>
    </div>

@endsection
