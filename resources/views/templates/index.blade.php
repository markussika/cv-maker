<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">CV Templates</h1>

        <p class="mb-4">Choose a template and start building your CV. Click "Use Template" to begin.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="border rounded shadow p-4 flex flex-col justify-between">
                <h2 class="font-semibold mb-2">Classic Template</h2>
                <p class="text-sm mb-4">Clean and professional layout for most industries.</p>
                <a href="{{ route('cv.create', ['template' => 'classic']) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded self-start">Use Template</a>
            </div>

            <div class="border rounded shadow p-4 flex flex-col justify-between">
                <h2 class="font-semibold mb-2">Modern Template</h2>
                <p class="text-sm mb-4">Modern layout emphasizing skills and achievements.</p>
                <a href="{{ route('cv.create', ['template' => 'modern']) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded self-start">Use Template</a>
            </div>

            <div class="border rounded shadow p-4 flex flex-col justify-between">
                <h2 class="font-semibold mb-2">Minimal Template</h2>
                <p class="text-sm mb-4">Simple, minimal design focusing on clarity.</p>
                <a href="{{ route('cv.create', ['template' => 'minimal']) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded self-start">Use Template</a>
            </div>
        </div>
    </div>
</x-app-layout>
