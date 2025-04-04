<div class="min-h-screen flex items-center justify-center bg-gray-900">
    <form wire:submit="register" class="w-full max-w-md mx-auto p-6 bg-gray-800 rounded-lg shadow-lg">
        <h1 class="text-xl text-gray-200 text-center m-2 py-2">Register Here</h1>
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-white">Your email</label>
            <input wire:model="email" type="email" value="{{ old('email') }}" id="email"
                class="shadow-xs bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 placeholder-gray-400"
                placeholder="name@example.com" required />
            @error('email')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-white">Your Name</label>
            <input wire:model="name" type="text" id="name" value="{{ old('name') }}" placeholder="John doe"
                class="shadow-xs bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 placeholder-gray-400"
                required />
            @error('name')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                    {{ $message }}
                </p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-white">Password</label>
            <input wire:model="password" type="password" id="password" value="{{ old('password') }}"
                class="shadow-xs bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 placeholder-gray-400"
                required />
            @error('password')
                <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center my-5">
            <input wire:model="remember_me" checked id="checked-checkbox" type="checkbox" value=""
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember
                Me</label>
        </div>

        <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Register new account
        </button>
        <div class="my-5">
            <a href="{{ route('login') }}" class="text-blue-400 text-center underline">
                Already Have An Account?
            </a>
        </div>
    </form>
</div>
