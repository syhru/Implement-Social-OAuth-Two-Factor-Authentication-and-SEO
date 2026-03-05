@extends('dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Profile Settings</h2>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6 bg-gray-50 border p-4 rounded-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Two-Factor Authentication (OTP)</h3>
                    <p class="text-sm text-gray-500 mt-1">When enabled, you will receive a 6-digit verification code via email every time you log in.</p>
                </div>
                <!-- Toggle Label -->
                <label for="two_factor_enabled" class="flex items-center cursor-pointer">
                    <!-- Toggle Input -->
                    <div class="relative">
                        <input type="checkbox" id="two_factor_enabled" name="two_factor_enabled" value="1" class="sr-only" {{ $user->two_factor_enabled ? 'checked' : '' }}>
                        <!-- Track -->
                        <div class="block bg-gray-300 w-14 h-8 rounded-full border-2 border-transparent transition-colors duration-300 {{ $user->two_factor_enabled ? 'bg-blue-600' : '' }}" id="toggle-track"></div>
                        <!-- Dot -->
                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition transform duration-300 {{ $user->two_factor_enabled ? 'translate-x-6' : '' }}" id="toggle-dot"></div>
                    </div>
                </label>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow transition duration-200">
                Save Changes
            </button>
        </div>
    </form>
</div>

<!-- Simple Script for Toggle Visual Feedback -->
<script>
    document.getElementById('two_factor_enabled').addEventListener('change', function() {
        var track = document.getElementById('toggle-track');
        var dot = document.getElementById('toggle-dot');
        if (this.checked) {
            track.classList.add('bg-blue-600');
            track.classList.remove('bg-gray-300');
            dot.classList.add('translate-x-6');
        } else {
            track.classList.remove('bg-blue-600');
            track.classList.add('bg-gray-300');
            dot.classList.remove('translate-x-6');
        }
    });
</script>
@endsection