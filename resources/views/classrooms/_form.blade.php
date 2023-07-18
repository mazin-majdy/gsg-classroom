<x-form.floating.control name="name" placeholder="Classroom Name">
    <x-form.input name="name" :value="$classroom->name" placeholder="Classroom Name" />
</x-form.floating.control>

<x-form.floating.control name="section" placeholder="Section">
    <x-form.input name="section" value="{{ $classroom->section }}" placeholder="Section" />
</x-form.floating.control>

<x-form.floating.control name="subject" placeholder="Subject">
    <x-form.input name="subject" value="{{ $classroom->subject }}" placeholder="subject" />
</x-form.floating.control>

<x-form.floating.control name="room" placeholder="Room">
    <x-form.input name="room" value="{{ $classroom->room }}" placeholder="room" />

</x-form.floating.control>

<x-form.floating.control name="cover_image" placeholder="Cover Image">
    @if ($classroom->cover_image_path)
        <img style="max-width: 100%" src="{{ Storage::disk('public')->url($classroom->cover_image_path) }}"
            alt="">
    @endif

    <x-form.input type="file" name="cover_image" value="{{ $classroom->cover_image }}" placeholder="cover_image" />

</x-form.floating.control>

<button type="submit" class="btn btn-primary">{{ $button_label }}</button>
