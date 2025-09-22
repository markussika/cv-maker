<x-app-layout>
    <x-slot name="header">Choose Your CV Template</x-slot>

    <div class="p-6 bg-white rounded-xl shadow">
        <p class="mb-6 text-gray-600">Select a CV template you like. You can preview how your CV looks in each style.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @php
                $templates = [
                    ['name' => 'Classic', 'file' => 'classic.png'],
                    ['name' => 'Modern', 'file' => 'modern.png'],
                    ['name' => 'Creative', 'file' => 'creative.png'],
                    ['name' => 'Minimal', 'file' => 'minimal.png'],
                    ['name' => 'Elegant', 'file' => 'elegant.png'],
                    ['name' => 'Bold', 'file' => 'bold.png'],
                    ['name' => 'Professional', 'file' => 'professional.png'],
                    ['name' => 'Futuristic', 'file' => 'futuristic.png'],
                    ['name' => 'Simple', 'file' => 'simple.png'],
                ];
            @endphp

            @foreach ($templates as $template)
                <div class="border rounded-xl overflow-hidden shadow hover:shadow-lg transition">
                    <img src="{{ asset('templates/previews/' . $template['file']) }}" alt="{{ $template['name'] }}" class="w-full h-56 object-cover">
                    <div class="p-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $template['name'] }}</h3>
                        <form method="POST" action="{{ route('cv.preview') }}">
                            @csrf
                            <input type="hidden" name="template" value="{{ $template['name'] }}">
                            <button class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">Select</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
