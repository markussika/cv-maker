<x-app-layout>
<div class="container mx-auto py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Create Your CV</h1>

    <form action="{{ route('cv.preview') }}" method="POST">
        @csrf

        {{-- Personal Information --}}
        <h2 class="font-bold text-xl mb-2">Personal Information</h2>
        <div class="mb-4">
            <label class="block mb-1">First Name</label>
            <input type="text" name="first_name" class="border border-gray-300 rounded px-3 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Last Name</label>
            <input type="text" name="last_name" class="border border-gray-300 rounded px-3 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Email</label>
            <input type="email" name="email" class="border border-gray-300 rounded px-3 py-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Phone</label>
            <input type="text" name="phone" class="border border-gray-300 rounded px-3 py-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Location</label>
            <input type="text" name="location" class="border border-gray-300 rounded px-3 py-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Website</label>
            <input type="text" name="website" class="border border-gray-300 rounded px-3 py-2 w-full">
        </div>
        <div class="mb-4">
            <label class="block mb-1">Summary</label>
            <textarea name="summary" class="border border-gray-300 rounded px-3 py-2 w-full"></textarea>
        </div>

        {{-- Work Experience --}}
        <h2 class="font-bold text-xl mb-2 cursor-pointer flex justify-between items-center bg-gray-100 p-3 rounded"
            onclick="toggleSection('work-experience')">
            Work Experience
            <span id="icon-work-experience">+</span>
        </h2>
        <div id="work-experience" class="mb-4 hidden">
            <div id="experience-container">
                <div class="experience-item mb-4 border p-2 rounded">
                    <label>Company</label>
                    <select name="experiences[0][company]" class="border p-1 w-full">
                        <option value="">Select Company</option>
                        <option value="Google">Google</option>
                        <option value="Microsoft">Microsoft</option>
                        <option value="LocalCompany1">LocalCompany1</option>
                    </select>

                    <label>Country</label>
                    <select name="experiences[0][country]" class="border p-1 w-full" onchange="updateCityOptions(0)">
                        <option value="">Select Country</option>
                        <option value="Latvia">Latvia</option>
                        <option value="UK">UK</option>
                    </select>

                    <label>City</label>
                    <select name="experiences[0][city]" class="border p-1 w-full" id="city-0">
                        <option value="">Select City</option>
                    </select>

                    <label>Role</label>
                    <input type="text" name="experiences[0][role]" class="border p-1 w-full">

                    <label>Start Date</label>
                    <input type="date" name="experiences[0][start_date]" class="border p-1 w-full">

                    <label>End Date</label>
                    <input type="date" name="experiences[0][end_date]" class="border p-1 w-full">

                    <label><input type="checkbox" name="experiences[0][currently_working]"> Currently working here</label>

                    <label>Description</label>
                    <textarea name="experiences[0][description]" class="border p-1 w-full"></textarea>

                    <button type="button" class="bg-red-500 text-white px-2 py-1 mt-2 rounded hover:bg-red-600 transition" onclick="removeExperience(this)">Remove</button>
                </div>
            </div>
            <button type="button" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700 transition" onclick="addExperience()">Add Experience</button>
        </div>

        {{-- Activities --}}
        <h2 class="font-bold text-xl mb-2 cursor-pointer flex justify-between items-center bg-gray-100 p-3 rounded"
            onclick="toggleSection('activities')">
            Activities
            <span id="icon-activities">+</span>
        </h2>
        <div id="activities" class="mb-4 hidden">
            <div id="activities-container">
                <div class="activity-item mb-4 border p-2 rounded">
                    <label>Title</label>
                    <input type="text" name="activities[0][title]" class="border p-1 w-full">
                    <label>Description</label>
                    <textarea name="activities[0][description]" class="border p-1 w-full"></textarea>
                    <button type="button" class="bg-red-500 text-white px-2 py-1 mt-2 rounded hover:bg-red-600 transition" onclick="removeActivity(this)">Remove</button>
                </div>
            </div>
            <button type="button" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700 transition" onclick="addActivity()">Add Activity</button>
        </div>

        {{-- Hobbies --}}
        <h2 class="font-bold text-xl mb-2 cursor-pointer flex justify-between items-center bg-gray-100 p-3 rounded"
            onclick="toggleSection('hobbies')">
            Hobbies
            <span id="icon-hobbies">+</span>
        </h2>
        <div id="hobbies" class="mb-4 hidden">
            <div id="hobbies-container">
                <div class="hobby-item mb-2">
                    <input type="text" name="hobbies[0]" class="border p-2 w-full mb-2">
                    <button type="button" onclick="removeHobby(this)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">Remove</button>
                </div>
            </div>
            <button type="button" onclick="addHobby()" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700 transition">Add Hobby</button>
        </div>

        {{-- Languages --}}
        <h2 class="font-bold text-xl mb-2 cursor-pointer flex justify-between items-center bg-gray-100 p-3 rounded"
            onclick="toggleSection('languages')">
            Languages
            <span id="icon-languages">+</span>
        </h2>
        <div id="languages" class="mb-4 hidden">
            <div id="languages-container">
                <div class="language-item mb-2">
                    <input type="text" name="languages[0][name]" placeholder="Language" class="border p-2 w-full mb-1">
                    <select name="languages[0][level]" class="border p-2 w-full mb-2">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                        <option value="fluent">Fluent</option>
                    </select>
                    <button type="button" onclick="removeLanguage(this)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">Remove</button>
                </div>
            </div>
            <button type="button" onclick="addLanguage()" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700 transition">Add Language</button>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded mt-4 hover:bg-green-700 transition">Preview CV</button>
    </form>
</div>

<script>
function toggleSection(id){
    const el = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    el.classList.toggle('hidden');
    icon.textContent = el.classList.contains('hidden') ? '+' : '−';
}

function addExperience(){
    const container = document.getElementById('experience-container');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className = 'experience-item mb-4 border p-2 rounded';
    div.innerHTML = `
        <label>Company</label>
        <select name="experiences[${index}][company]" class="border p-1 w-full">
            <option value="">Select Company</option>
            <option value="Google">Google</option>
            <option value="Microsoft">Microsoft</option>
            <option value="LocalCompany1">LocalCompany1</option>
        </select>
        <label>Country</label>
        <select name="experiences[${index}][country]" class="border p-1 w-full" onchange="updateCityOptions(${index})">
            <option value="">Select Country</option>
            <option value="Latvia">Latvia</option>
            <option value="UK">UK</option>
        </select>
        <label>City</label>
        <select name="experiences[${index}][city]" class="border p-1 w-full" id="city-${index}">
            <option value="">Select City</option>
        </select>
        <label>Role</label>
        <input type="text" name="experiences[${index}][role]" class="border p-1 w-full">
        <label>Start Date</label>
        <input type="date" name="experiences[${index}][start_date]" class="border p-1 w-full">
        <label>End Date</label>
        <input type="date" name="experiences[${index}][end_date]" class="border p-1 w-full">
        <label><input type="checkbox" name="experiences[${index}][currently_working]"> Currently working here</label>
        <label>Description</label>
        <textarea name="experiences[${index}][description]" class="border p-1 w-full"></textarea>
        <button type="button" class="bg-red-500 text-white px-2 py-1 mt-2 rounded hover:bg-red-600 transition" onclick="removeExperience(this)">Remove</button>
    `;
    container.appendChild(div);
}
function removeExperience(el){ el.parentElement.remove(); }
function updateCityOptions(index){
    const country = document.querySelector(`[name='experiences[${index}][country]']`).value;
    const citySelect = document.getElementById(`city-${index}`);
    citySelect.innerHTML = '<option value="">Select City</option>';
    let cities = [];
    if(country === 'Latvia') cities = ['Riga','Daugavpils','Liepaja'];
    else if(country === 'UK') cities = ['London','Manchester','Birmingham'];
    cities.forEach(c => {
        const option = document.createElement('option');
        option.value = c;
        option.textContent = c;
        citySelect.appendChild(option);
    });
}

// Activities
function addActivity(){
    const container = document.getElementById('activities-container');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className = 'activity-item mb-4 border p-2 rounded';
    div.innerHTML = `
        <label>Title</label>
        <input type="text" name="activities[${index}][title]" class="border p-1 w-full">
        <label>Description</label>
        <textarea name="activities[${index}][description]" class="border p-1 w-full"></textarea>
        <button type="button" class="bg-red-500 text-white px-2 py-1 mt-2 rounded hover:bg-red-600 transition" onclick="removeActivity(this)">Remove</button>
    `;
    container.appendChild(div);
}
function removeActivity(el){ el.parentElement.remove(); }

// Hobbies
function addHobby(){
    const container = document.getElementById('hobbies-container');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className = 'hobby-item mb-2';
    div.innerHTML = `<input type="text" name="hobbies[${index}]" class="border p-2 w-full mb-2">
                     <button type="button" onclick="removeHobby(this)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">Remove</button>`;
    container.appendChild(div);
}
function removeHobby(el){ el.parentElement.remove(); }

// Languages
function addLanguage(){
    const container = document.getElementById('languages-container');
    const index = container.children.length;
    const div = document.createElement('div');
    div.className = 'language-item mb-2';
    div.innerHTML = `<input type="text" name="languages[${index}][name]" placeholder="Language" class="border p-2 w-full mb-1">
                     <select name="languages[${index}][level]" class="border p-2 w-full mb-2">
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                        <option value="fluent">Fluent</option>
                     </select>
                     <button type="button" onclick="removeLanguage(this)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">Remove</button>`;
    container.appendChild(div);
}
function removeLanguage(el){ el.parentElement.remove(); }
</script>
</x-app-layout>
