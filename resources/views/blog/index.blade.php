<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('blog.index') }}" class="text-xl font-bold text-gray-800">MyBlog</a>
                </div>
                    @auth
                        <div class="relative group flex items-center h-full">
                            <button class="flex items-center text-gray-600 hover:text-gray-900 focus:outline-none py-4">
                                <span>{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute right-0 top-full w-48 pt-1 hidden group-hover:block z-50">
                                <div class="bg-white rounded-md shadow-lg border py-1">
                                    @if(auth()->user()->email === 'muhamadarul746@gmail.com')
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    @endif
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Settings</a>
                                    <form action="{{ route('logout') }}" method="POST" class="block w-full">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
                    @endauth
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 w-full">
        <!-- Search and Filter Bar -->
        <div class="mb-8 p-4 bg-white rounded-lg shadow flex flex-col md:flex-row gap-4">
            <form action="{{ route('blog.index') }}" method="GET" class="flex flex-grow gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="w-full md:w-1/2 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <select name="category" class="w-full md:w-1/4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    Filter
                </button>
            </form>
        </div>

        <!-- Post List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col">
                @if($post->featured_image)
                <img src="{{ Str::startsWith($post->featured_image, 'http') ? $post->featured_image : asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">No Image</span>
                </div>
                @endif
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-blue-600 uppercase tracking-wider">{{ $post->category->name }}</span>
                        <span class="text-sm text-gray-500">{{ $post->created_at->format('M d, Y') }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">
                        <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600">{{ $post->title }}</a>
                    </h2>
                    <p class="text-gray-600 text-sm flex-grow mb-4">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                    <div class="flex flex-wrap gap-2 mt-auto">
                        @foreach($post->tags as $tag)
                        <span class="px-2 py-1 bg-gray-100 text-xs text-gray-600 rounded-full">#{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12 bg-white rounded-lg shadow">
                <p class="text-gray-500 text-lg">No posts found.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow mt-auto border-t">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} MyBlog. All rights reserved. | <a href="{{ route('sitemap.index') }}" class="hover:text-gray-900">Sitemap</a>
        </div>
    </footer>
</body>

</html>