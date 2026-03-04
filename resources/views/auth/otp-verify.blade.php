<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Two-Factor Authentication</h2>
        <p class="text-gray-600 mb-6 text-center">Please enter the 6-digit code sent to your email.</p>

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
        @endif

        @if (session('status'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('status') }}
        </div>
        @endif

        <form action="{{ route('otp.verify.submit') }}" method="POST">
            @csrf
            <div class="mb-4">
                <input type="text" name="code" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-center text-2xl tracking-widest" maxlength="6" required autocomplete="off">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                Verify Code
            </button>
        </form>

        <form action="{{ route('otp.resend') }}" method="POST" class="mt-4 text-center">
            @csrf
            <button type="submit" class="text-blue-600 hover:underline text-sm focus:outline-none">
                Didn't receive a code? Resend
            </button>
        </form>
    </div>
</body>

</html>