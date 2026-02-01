<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              
                <p class="text-primary">
                    Привет, {{ auth()->user()->name }} 
                </p>
                  <p>личный кабинет</p>

                {{-- <a href="{{route('learning.index')}}">Список иероглифов</a> --}}
            </div>
</x-app-layout>
