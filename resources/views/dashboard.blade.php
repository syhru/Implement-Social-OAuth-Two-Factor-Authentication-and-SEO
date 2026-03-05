<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 flex h-screen text-gray-800">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
        <div class="h-16 flex items-center justify-center font-bold text-2xl border-b border-gray-800">
            Admin Panel
        </div>
        <nav class="flex-grow p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block p-3 rounded hover:bg-gray-800 transition {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}">Dashboard</a>
            <a href="{{ route('categories.index') }}" class="block p-3 rounded hover:bg-gray-800 transition {{ request()->is('categories*') ? 'bg-gray-800' : '' }}">Categories</a>
            <a href="{{ route('tags.index') }}" class="block p-3 rounded hover:bg-gray-800 transition {{ request()->is('tags*') ? 'bg-gray-800' : '' }}">Tags</a>
            <a href="{{ route('posts.index') }}" class="block p-3 rounded hover:bg-gray-800 transition {{ request()->is('posts*') ? 'bg-gray-800' : '' }}">Posts</a>
        </nav>
        <div class="p-4 border-t border-gray-800">
            <a href="{{ route('blog.index') }}" target="_blank" class="block p-3 rounded hover:bg-gray-800 text-center border font-semibold border-gray-600 mb-2">View Public Site</a>
        </div>
    </aside>

    <!-- Main Content wrapper -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Header -->
        <header class="bg-white shadow h-16 flex items-center justify-between px-6 z-10">
            <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600">Welcome, {{ Auth::user()->name }}</span>
                <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 font-medium ml-4">Profile Settings</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium ml-4">Logout</button>
                </form>
            </div>
        </header>

        <!-- Dynamic Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg shadow mb-6" x-data="{ show: true }" x-show="show">
                <div class="flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button @click="show = false" class="text-green-700 font-bold">&times;</button>
                </div>
            </div>
            @endif

            @yield('content')

            @if(!View::hasSection('content'))
            <div class="bg-white rounded-lg shadow p-8 text-center border-dashed border-4 border-gray-200 h-96 flex flex-col items-center justify-center">
                <p class="text-gray-500 text-2xl font-semibold mb-2">Welcome to Admin Panel</p>
                <p class="text-gray-400">Select a menu from the sidebar to start managing your blog.</p>
            </div>
            @endif
        </main>
    </div>
</body>

</html>