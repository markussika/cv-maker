<x-app-layout>
    <div class="max-w-4xl mx-auto py-10">
        <!-- Step Indicator -->
        <div class="flex justify-between items-center mb-8">
            @foreach (['1' => 'Personal Info', '2' => 'Education', '3' => 'Experience', '4' => 'Finish'] as $step => $label)
                <div class="flex-1 text-center">
                    <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center 
                        {{ $loop->first ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                        {{ $step }}
                    </div>
                    <p class="text-sm mt-2">{{ $label }}</p>
                </div>
            @endforeach
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('cv.store') }}" class="bg-white shadow-lg rounded-xl p-8 space-y-6">
            @csrf

            <!-- Step 1: Personal Info -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1 font-medium">First Name</label>
                        <input type="text" name="first_name" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Last Name</label>
                        <input type="text" name="last_name" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Birthday</label>
                        <input type="date" name="birthday" max="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Country</label>
                        <select name="country" id="country" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}">{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">City</label>
                        <select name="city" id="city" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                            <option value="">Select City</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Step 2: Education -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Education</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">School / University</label>
                        <input type="text" name="education[school]" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Degree</label>
                        <input type="text" name="education[degree]" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Step 3: Experience -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Experience</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">Company</label>
                        <input type="text" name="experience[company]" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Role</label>
                        <input type="text" name="experience[role]" class="w-full rounded-lg border-gray-300 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Step 4: Finish -->
            <div class="text-right">
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                    Save & Preview
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('country').addEventListener('change', function () {
            const country = this.value;
            const cityDropdown = document.getElementById('city');
            cityDropdown.innerHTML = '<option value="">Loading...</option>';

            if (country) {
                fetch(`/api/cities/${country}`)
                    .then(res => res.json())
                    .then(data => {
                        cityDropdown.innerHTML = '<option value="">Select City</option>';
                        data.forEach(city => {
                            let option = document.createElement('option');
                            option.value = city;
                            option.textContent = city;
                            cityDropdown.appendChild(option);
                        });
                    })
                    .catch(() => {
                        cityDropdown.innerHTML = '<option value="">Error loading cities</option>';
                    });
            }
        });
    </script>
</x-app-layout>
