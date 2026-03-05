@extends('dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tags</h2>
        <a href="{{ route('tags.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">Add New</a>
    </div>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-600 border-b">
                <th class="py-3 px-4">#</th>
                <th class="py-3 px-4">Name</th>
                <th class="py-3 px-4">Slug</th>
                <th class="py-3 px-4 w-32">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tags as $tag)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                <td class="py-3 px-4 font-semibold">{{ $tag->name }}</td>
                <td class="py-3 px-4 text-gray-500">{{ $tag->slug }}</td>
                <td class="py-3 px-4 flex gap-2">
                    <a href="{{ route('tags.edit', $tag) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded shadow transition duration-200">
                        Edit
                    </a>
                    <form action="{{ route('tags.destroy', $tag) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this tag?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded shadow transition duration-200">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-6 text-center text-gray-500">No tags found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $tags->links() }}
    </div>
</div>
@endsection