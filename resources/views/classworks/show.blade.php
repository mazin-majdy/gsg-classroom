<x-main-layout title="Create classwork">
    <div class="container">
        <h1>{{ $classroom->name }} (#{{ $classroom->id }})</h1>
        <h3>{{ $classwork->title }}</h3>

        {{-- <x-alert :name="$success" class="alert-success" />
        <x-alert :name="$error" class="alert-danger" /> --}}
        <hr>

        <div class="row">
            <div class="col-md-8">
                <div>
                    <p>{!! $classwork->description !!}</p>
                </div>
                <h4>Comments</h4>
                <form action="{{ route('comments.store') }}" method="post">
                    @csrf

                    <input type="hidden" name="id" value="{{ $classwork->id }}">
                    <input type="hidden" name="type" value="classwork">
                    <div class="d-flex">
                        <div class="col-8">
                            <x-form.floating.control name="description" placeholder="Comment">
                                <x-form.textarea name="content" placeholder="Comment" />
                            </x-form.floating.control>
                        </div>
                        <div class="ms-1">
                            <button type="submit" class="btn btn-primary">Comment</button>

                        </div>
                    </div>
                </form>
                <div class="mt-4">

                    {{-- @foreach ($classwork->comments()->with('user')->get() as $comment) --}}
                    @foreach ($classwork->comments as $comment)
                        <div class="row">
                            <div class="col-md-2">
                                <img class="img-profile rounded-circle"
                                    src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-10">
                                <p>By: {{ $comment->user->name }} . Time:
                                    {{ $comment->created_at->diffForHumans(null, false, true) }}</p>
                                <p>{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="col-md-4">
                @can('submissions.create', [$classwork])

                    <div class="bordered rounded p-3 bg-light">
                        <h4>Submissions</h4>
                        @if ($submissions->count())
                            <ul>
                                @foreach ($submissions as $submission)
                                    <li><a href="{{ route('submissions.file', $submission->id) }}">File
                                            #{{ $loop->iteration }}</a></li>
                                @endforeach
                            </ul>
                        @else
                            <form action="{{ route('submissions.store', $classwork->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <x-form.floating.control name="files." placeholder="Upload Files">
                                    <x-form.input type="file" multiple name="files[]" accept="image/*, application/pdf"
                                        placeholder="Select Files" />
                                </x-form.floating.control>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>
                        @endif
                    </div>
                @endcan

            </div>
        </div>
    </div>

    </div>
</x-main-layout>
