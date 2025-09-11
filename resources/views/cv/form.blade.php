<x-app-layout>
    <x-slot name="header">Create CV</x-slot>
    <div class="p-6 bg-white rounded shadow">
        <form method="POST" action="{{ route('cv.preview') }}" enctype="multipart/form-data">
            @csrf
            <!-- Personal info -->
            <div class="mb-4">
                <label>First Name</label>
                <input type="text" name="first_name" class="border p-2 w-full">
                <label>Last Name</label>
                <input type="text" name="last_name" class="border p-2 w-full">
                <label>Email</label>
                <input type="email" name="email" class="border p-2 w-full">
                <label>Phone</label>
                <input type="text" name="phone" class="border p-2 w-full">
                <label>Profile Image</label>
                <input type="file" name="profile_image" class="border p-2 w-full">
            </div>

            <!-- Work experience -->
            <div id="work_experience_section" class="mb-4">
                <h3>Work Experience</h3>
                <div class="experience_item mb-2">
                    <input type="text" name="work_experience[0][position]" placeholder="Position" class="border p-2 w-full">
                    <select name="work_experience[0][country]" class="border p-2 country_select">
                        <option value="">Select Country</option>
                    </select>
                    <select name="work_experience[0][city]" class="border p-2 city_select">
                        <option value="">Select City</option>
                    </select>
                    <select name="work_experience[0][company]" class="border p-2 company_select">
                        <option value="">Select Company</option>
                    </select>
                    <label><input type="checkbox" name="work_experience[0][still_working]"> Still working</label>
                </div>
                <button type="button" id="add_experience">Add Experience</button>
            </div>

            <!-- Hobbies, Languages, Skills -->
            <div class="mb-4">
                <label>Hobbies</label>
                <select name="hobbies[]" multiple class="border p-2 w-full">
                    <option>Reading</option>
                    <option>Traveling</option>
                    <option>Sports</option>
                </select>

                <label>Languages</label>
                <select name="languages[]" multiple class="border p-2 w-full">
                    <option>English</option>
                    <option>Spanish</option>
                    <option>French</option>
                </select>

                <label>Skills</label>
                <input type="text" name="skills[]" class="border p-2 w-full">
            </div>

            <!-- Education & Extra -->
            <div class="mb-4">
                <label>Education</label>
                <input type="text" name="education[]" class="border p-2 w-full">
                <label>Extra Curricular Activities</label>
                <input type="text" name="extra_curriculum_activities[]" class="border p-2 w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2">Preview CV</button>
        </form>
    </div>

    <script>
        // Fetch countries on page load
        fetch('/countries')
        .then(res => res.json())
        .then(countries => {
            document.querySelectorAll('.country_select').forEach(sel=>{
                countries.forEach(c=>sel.add(new Option(c,c)));
            });
        });

        // Event delegation for country->city->company
        document.addEventListener('change', async function(e){
            if(e.target.classList.contains('country_select')){
                let country = e.target.value;
                let citySelect = e.target.closest('.experience_item').querySelector('.city_select');
                let companySelect = e.target.closest('.experience_item').querySelector('.company_select');

                citySelect.innerHTML='<option>Select City</option>';
                companySelect.innerHTML='<option>Select Company</option>';

                if(country){
                    let cities = await fetch(`/cities?country=${country}`).then(r=>r.json());
                    cities.forEach(c=>citySelect.add(new Option(c,c)));
                }
            }

            if(e.target.classList.contains('city_select')){
                let country = e.target.closest('.experience_item').querySelector('.country_select').value;
                let city = e.target.value;
                let companySelect = e.target.closest('.experience_item').querySelector('.company_select');

                companySelect.innerHTML='<option>Select Company</option>';

                if(country && city){
                    let companies = await fetch(`/companies?country=${country}&city=${city}`).then(r=>r.json());
                    companies.forEach(c=>companySelect.add(new Option(c,c)));
                }
            }
        });

        // Add new experience
        document.getElementById('add_experience').addEventListener('click', ()=>{
            let container=document.getElementById('work_experience_section');
            let count = container.querySelectorAll('.experience_item').length;
            let clone = container.querySelector('.experience_item').cloneNode(true);
            clone.querySelectorAll('input, select').forEach(inp=>{
                let name = inp.name.replace(/\[\d+\]/, `[${count}]`);
                inp.name=name;
                inp.value='';
            });
            container.appendChild(clone);
        });
    </script>
</x-app-layout>
