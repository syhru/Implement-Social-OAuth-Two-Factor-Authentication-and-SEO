@extends('dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Posts</h2>
        <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded shadow">Add New</a>
    </div>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-600 border-b">
                <th class="py-3 px-4">#</th>
                <th class="py-3 px-4">Title</th>
                <th class="py-3 px-4">Category</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4 w-32">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                <td class="py-3 px-4 font-semibold">{{ Str::limit($post->title, 40) }}</td>
                <td class="py-3 px-4 text-gray-500">{{ $post->category->name }}</td>
                <td class="py-3 px-4">
                    @if($post->is_published)
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Published</span>
                    @else
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Draft</span>
                    @endif
                </td>
                <td class="py-3 px-4 flex gap-2">
                    <a href="{{ route('posts.edit', $post) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded shadow transition duration-200">
                        Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this post?');">
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
                <td colspan="5" class="py-6 text-center text-gray-500">No posts found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection