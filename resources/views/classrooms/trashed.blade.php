<x-main-layout title="Classrooms">

    <div class="container">

        {{-- alert component --}}
        {{-- <x-alert :success='$success' /> --}}
        {{-- @if ($success)
            <div class="alert alert-success">{{ $success }}</div>
            @endif --}}



        <h1>Trashed Classrooms</h1>


        <div class="row">

            @foreach ($classrooms as $classroom)
                <div class="col-md-3">
                    <div class="card">
                        {{-- php artisan storage:link --}}
                        <img src="{{ asset('storage/' . $classroom->cover_image_path) }}" class="card-img-top"
                            alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <p class="card-text">{{ $classroom->section }} - {{ $classroom->room }}</p>
                            <form class="d-inline" action="{{ route('classrooms.restore', $classroom->id) }}"
                                method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-danger btn-sm">Restore</button>
                            </form>
                            <form class="d-inline" action="{{ route('classrooms.force-delete', $classroom->id) }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm">Delete Forever</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-main-layout>

{{-- @push('scripts')
    <script>alert(1)</script>
    @endpush --}}
