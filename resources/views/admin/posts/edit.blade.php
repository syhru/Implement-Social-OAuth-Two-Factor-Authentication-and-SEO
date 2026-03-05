@extends('dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Post</h2>

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                    @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Content</label>
                    <textarea name="content" rows="10" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>{{ old('content', $post->content) }}</textarea>
                    @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- SEO Metrics -->
                <div class="p-4 bg-gray-50 border rounded-lg space-y-4">
                    <h3 class="font-bold text-gray-700">SEO Settings & References</h3>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Sumber Referensi (URL / Opsional)</label>
                        <input type="url" name="source_url" id="source_url" value="{{ old('source_url', $post->source_url) }}" placeholder="https://..." class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('source_url')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Slug (Auto-generated if empty)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('slug')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500 outline-none">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Status -->
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-bold text-gray-700 mb-3">Publish</h3>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_published" class="rounded text-blue-600" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                        <span class="text-gray-700">Published</span>
                    </label>
                    <button type="submit" class="mt-4 w-full bg-blue-600 text-white font-bold py-2 px-4 rounded shadow hover:bg-blue-700">Update Post</button>
                    <a href="{{ route('posts.index') }}" class="block text-center mt-2 text-gray-500 hover:text-gray-700 text-sm">Cancel</a>
                </div>

                <!-- Category -->
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-bold text-gray-700 mb-3">Category</h3>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Tags -->
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-bold text-gray-700 mb-3">Tags</h3>
                    <div class="max-h-48 overflow-y-auto space-y-2 border p-2 rounded">
                        @php
                        $selectedTags = old('tags', $post->tags->pluck('id')->toArray());
                        @endphp
                        @foreach($tags as $tag)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded text-blue-600" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                            <span class="text-gray-700">{{ $tag->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-bold text-gray-700 mb-3">Featured Image</h3>
                    @if($post->featured_image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current Image" class="w-full h-32 object-cover rounded">
                    </div>
                    @endif
                    <input type="file" name="featured_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('featured_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </form>
</div>
@endsection