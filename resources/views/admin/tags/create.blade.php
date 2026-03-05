@extends('dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-xl">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Tag</h2>

    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
            @error('slug')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-6 rounded shadow hover:bg-blue-700">Save</button>
        <a href="{{ route('tags.index') }}" class="ml-2 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>

<script>
    document.getElementById('name').addEventListener('keyup', function() {
        let slug = this.value.toLowerCase().replace(/ \s*[^a-zA-Z0-9]\s*/g, '-').replace(/[^a-z0-9-]+/g, '-').replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection