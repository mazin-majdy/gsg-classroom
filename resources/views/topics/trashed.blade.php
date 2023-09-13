@extends('layouts.master')

@section('title', 'Topics')
@section('content')
<div class="container">

    <h1>Trashed Topics</h1>

    <div class="col my-5">

        @foreach ($topics as $topic)
            <div class=" mb-5 border-bottom py-2 d-flex justify-content-between">
                <h5 class="">{{ $topic->name }}</h5>
                <div class="btn-group">
                    <button type="button" class="btn" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <form action="{{ route('topics.restore', [$topic->id, 37]) }}" method="post">
                                @csrf
                                @method('put')
                                <button class="dropdown-item">Restore</button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('topics.force-delete', [$topic->id, 37]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="dropdown-item">Force Delete</button>
                            </form>
                        </li>
                    </ul>
                </div>
                {{-- <a href="{{ route('topics.show', $topic->id) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-sm btn-dark">Edit</a>
                        <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form> --}}
            </div>
        @endforeach
    </div>

</div>
@endsection
