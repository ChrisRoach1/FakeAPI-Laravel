<x-app-layout>
    <x-slot:title>FakeAPI</x-slot:title>

    <div class="px-6 pt-14 lg:px-8">
        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">The easiest way to fake some APIs</h1>
                <p class="mt-6 text-lg leading-8 text-gray-600">
                    Fake it til you make it!
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    @if(auth())
                        <x-mary-button class="btn btn-primary" wire:navigate link="{{route('dashboard')}}">
                            Get Started
                        </x-mary-button>
                    @else
                        <x-mary-button class="btn btn-primary" wire:navigate link="{{route('login')}}">
                            Get Started
                        </x-mary-button>
                    @endif


                </div>
            </div>
        </div>
    </div>
</x-app-layout>