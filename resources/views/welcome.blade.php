<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-primary leading-tight">
            Добро пожаловать в KanjiFlow
        </h2>
    </x-slot>

    <div class="py-12 bg-background">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-6">
                <p class="text-lg font-semibold text-gray-700">
                    Регистрация и вход в систему.
                </p>

                <a class="p-4 bg-secondary text-white rounded hover:bg-primary transition-colors" href="{{ route('register') }}">
                    Регистрация
                </a>
                <a class="ml-4 underline text-secondary" href="{{ route('login') }}">
                    Вход
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
