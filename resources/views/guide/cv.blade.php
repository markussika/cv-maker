<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">CV Guide</h1>

        <p class="mb-4">
            Creating a strong CV can help you stand out to employers. Here are some best practices:
        </p>

        <h2 class="text-xl font-semibold mt-4 mb-2">1. Keep it concise</h2>
        <p>Limit your CV to one or two pages, highlighting only relevant information.</p>

        <h2 class="text-xl font-semibold mt-4 mb-2">2. Focus on achievements</h2>
        <p>Highlight accomplishments rather than just job responsibilities.</p>

        <h2 class="text-xl font-semibold mt-4 mb-2">3. Use clear formatting</h2>
        <p>Use headings, bullet points, and consistent fonts to make your CV readable.</p>

        <h2 class="text-xl font-semibold mt-4 mb-2">4. Include key sections</h2>
        <ul class="list-disc list-inside mb-4">
            <li>Basic Information</li>
            <li>Summary / Objective</li>
            <li>Work Experience</li>
            <li>Education</li>
            <li>Skills</li>
            <li>Additional Info (certifications, languages, etc.)</li>
        </ul>

        <p class="mt-6">
            Ready to create your CV? <a href="{{ route('cv.create') }}" class="text-blue-600 hover:underline">Start here</a>.
        </p>
    </div>
</x-app-layout>
