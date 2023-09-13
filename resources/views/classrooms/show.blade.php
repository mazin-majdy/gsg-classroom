@extends('layouts.master')
@section('title', ' Classroom ' . $classroom->name)
@section('content')
    @push('styles')
        <style>
            .theme {
                height: 15rem;
                position: relative;
                width: 100%;
                border-radius: 0.5rem;
                overflow: hidden;
            }

            .image-bg {
                background-repeat: no-repeat;
                background-size: cover;
                height: 100%;
                left: 0;
                position: absolute;
                top: 0;
                width: 100%;
            }

            .info {
                bottom: 0;
                color: #fff;
                left: 0;
                padding: 1rem 1.5rem;
                position: absolute;
                right: 0;
            }
        </style>
    @endpush
    <div class="container">

        <div class="theme">
            <div class="image-bg"
                style="background-image: url({{ Storage::disk('public')->url($classroom->cover_image_path) }});">
            </div>
            <div class="info">

                <h1>{{ $classroom->name }} - {{ $classroom->id }}</h1>
                <h3>{{ $classroom->section }}</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="border rounded p-3 text-center">
                    <span class="text-success fs-2">{{ $classroom->code }}</span>
                </div>
                <div class="col-md-9">

                    <p>Invitation Link: <a href="{{ $invitation_link }}">{{ $invitation_link }}</a></p>
                    <p><a href="{{ route('classrooms.classworks.index', $classroom->id) }}" class="btn btn-dark">Classworks</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
