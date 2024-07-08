<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('views.welcome.hello') }}
        </h1>
        <p>{{ __('views.welcome.thisIs') }}</p>
    </x-slot>
</x-app-layout>
