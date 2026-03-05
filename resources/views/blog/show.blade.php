<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->meta_title ?? $post->title }}</title>
    <meta name="description" content="{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 150) }}">

    <!-- JSON-LD Schema -->
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "BlogPosting",
            "mainEntityOfPage": {
                "@@type": "WebPage",
                "@@id": "{{ route('blog.show', $post->slug) }}"
            },
            "headline": "{{ $post->title }}",
            "description": "{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 150) }}",
            "image": "{{ $post->featured_image ? (Str::startsWith($post->featured_image, 'http') ? $post->featured_image : url('storage/' . $post->featured_image)) : '' }}",
            "author": {
                "@@type": "Person",
                "name": "{{ $post->user->name ?? 'Unknown Author' }}",
                "url": "{{ route('blog.index') }}"
            },
            @if($post -> source_url)
            "isBasedOn": "{{ $post->source_url }}",
            @endif "publisher": {
                "@@type": "Organization",
                "name": "MyBlog",
                "logo": {
                    "@@type": "ImageObject",
                    "url": ""
                }
            },
            "datePublished": "{{ $post->created_at->toIso8601String() }}",
            "dateModified": "{{ $post->updated_at->toIso8601String() }}"
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('blog.index') }}" class="text-xl font-bold text-gray-800">MyBlog</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->email === 'muhamadarul746@gmail.com')
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                        @endif
                        <div class="relative group">
                            <button class="flex items-center text-gray-600 hover:text-gray-900 focus:outline-none">
                                <span>{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden group-hover:block z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile Settings</a>
                                <form action="{{ route('logout') }}" method="POST" class="block w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 w-full">
        <article class="bg-white rounded-lg shadow overflow-hidden mb-8 p-6 md:p-8">
            <div class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                <span class="text-blue-600 font-semibold uppercase tracking-wider">{{ $post->category->name }}</span>
                <span>&bull;</span>
                <span>{{ $post->created_at->format('M d, Y') }}</span>
                <span>&bull;</span>
                <span>By {{ $post->user->name ?? 'Author' }}</span>
            </div>

            <h1 class="text-3xl font-extrabold text-gray-900 mb-6">{{ $post->title }}</h1>

            @if($post->featured_image)
            <img src="{{ Str::startsWith($post->featured_image, 'http') ? $post->featured_image : asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-lg shadow-md mb-6 object-cover">
            @endif

            <div class="prose max-w-none text-gray-800 leading-relaxed mb-8">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div class="flex flex-wrap gap-2 border-t pt-4">
                @foreach($post->tags as $tag)
                <a href="{{ route('blog.index', ['search' => $tag->name]) }}" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-sm text-gray-600 rounded-full transition">#{{ $tag->name }}</a>
                @endforeach
            </div>

            <!-- Optional Source Reference -->
            @if($post->source_url)
            <div class="mt-8 p-4 bg-blue-50 border border-blue-100 rounded-lg">
                <h4 class="font-bold text-blue-800 mb-2">Sumber Referensi</h4>
                <p class="text-sm text-blue-900">
                    Materi dalam artikel ini didapatkan dari referensi berikut: <br>
                    <a href="{{ $post->source_url }}" target="_blank" rel="nofollow noopener" class="text-blue-600 hover:underline font-medium">{{ $post->source_url }}</a>
                </p>
            </div>
            @endif
        </article>

        <!-- Comments Section -->
        <div class="bg-white rounded-lg shadow p-6 md:p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Comments ({{ $post->comments->count() }})</h3>

            @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            @auth
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-8">
                @csrf
                <div class="mb-4">
                    <label for="body" class="sr-only">Your comment</label>
                    <textarea id="body" name="body" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Leave a comment..."></textarea>
                    @error('body')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    Post Comment
                </button>
            </form>
            @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-8 text-center">
                <p class="text-gray-600 text-sm">You must be <a href="{{ route('login') }}" class="text-blue-600 hover:underline">logged in</a> to post a comment.</p>
            </div>
            @endauth

            <div class="space-y-6">
                @foreach($post->comments as $comment)
                <div class="flex space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold uppercase">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex items-center space-x-2">
                            <span class="font-bold text-gray-900">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="mt-1 text-gray-800 text-sm">{{ $comment->body }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</body>

</html>