const initCvForm = () => {
    const form = document.getElementById('cvForm');
    if (!form) {
        return;
    }

    const stepButtons = Array.from(document.querySelectorAll('[data-step-trigger]'));
    const stepPanels = Array.from(document.querySelectorAll('[data-step-panel]'));
    const connectors = Array.from(document.querySelectorAll('[data-step-connector]'));
    const nextButton = document.getElementById('nextStep');
    const prevButton = document.getElementById('prevStep');
    const submitButton = document.getElementById('submitStep');
    const totalSteps = stepPanels.length;
    let currentStep = 1;
    let maxStepVisited = 1;

    const updateStepVisuals = () => {
        stepButtons.forEach((button) => {
            const step = Number(button.dataset.stepTrigger);
            const circle = button.querySelector('[data-step-circle]');
            const isActive = step === currentStep;
            const isVisited = step <= maxStepVisited;

            button.classList.toggle('text-slate-900', isActive);
            button.classList.toggle('text-slate-400', !isActive);
            button.classList.toggle('cursor-pointer', isVisited);
            button.classList.toggle('cursor-not-allowed', !isVisited);
            button.disabled = !isVisited;

            if (!circle) {
                return;
            }

            circle.className = 'flex h-12 w-12 items-center justify-center rounded-full border text-base font-semibold shadow-sm transition-all duration-300';
            if (step < currentStep) {
                circle.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-blue-200');
            } else if (isActive) {
                circle.classList.add('bg-black', 'text-white', 'border-black', 'ring', 'ring-blue-100');
            } else {
                circle.classList.add('bg-white', 'text-slate-400', 'border-slate-200');
            }
        });

        connectors.forEach((connector) => {
            const index = Number(connector.dataset.stepConnector);
            connector.classList.toggle('bg-blue-500', index < currentStep);
            connector.classList.toggle('bg-slate-200', index >= currentStep);
        });

        stepPanels.forEach((panel) => {
            const step = Number(panel.dataset.stepPanel);
            panel.classList.toggle('hidden', step !== currentStep);
        });

        prevButton?.classList.toggle('hidden', currentStep === 1);
        nextButton?.classList.toggle('hidden', currentStep === totalSteps);
        submitButton?.classList.toggle('hidden', currentStep !== totalSteps);
    };

    stepButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const targetStep = Number(button.dataset.stepTrigger);
            if (targetStep <= maxStepVisited) {
                currentStep = targetStep;
                updateStepVisuals();
            }
        });
    });

    nextButton?.addEventListener('click', () => {
        if (currentStep < totalSteps) {
            currentStep += 1;
            maxStepVisited = Math.max(maxStepVisited, currentStep);
            updateStepVisuals();
        }
    });

    prevButton?.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep -= 1;
            updateStepVisuals();
        }
    });

    updateStepVisuals();

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? null;
    const citiesEndpoint = form.dataset.citiesEndpoint ?? null;

    const fetchCitiesForCountry = async (country) => {
        if (!country || !citiesEndpoint) {
            return [];
        }

        try {
            const response = await fetch(citiesEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                },
                body: JSON.stringify({ country }),
            });

            if (!response.ok) {
                return [];
            }

            const payload = await response.json();
            return Array.isArray(payload) ? payload : [];
        } catch (error) {
            return [];
        }
    };

    const initLocationGroups = (root = document) => {
        const groups = root.matches?.('[data-location-group]') ? [root] : Array.from(root.querySelectorAll('[data-location-group]'));

        groups.forEach((group) => {
            if (!group || group.dataset.locationReady === 'true') {
                return;
            }

            const countryField = group.querySelector('[data-country-select]');
            const cityField = group.querySelector('[data-city-select]');
            if (!countryField || !cityField) {
                return;
            }

            group.dataset.locationReady = 'true';
            let rememberedCity = cityField.dataset.selectedCity || '';

            const populateCities = (cities, selectedCity) => {
                cityField.innerHTML = '<option value="">Select city</option>';
                if (!Array.isArray(cities) || cities.length === 0) {
                    return;
                }

                cities.forEach((city) => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    if (selectedCity && selectedCity === city) {
                        option.selected = true;
                    }
                    cityField.appendChild(option);
                });

                if (selectedCity && cityField.value !== selectedCity) {
                    const fallback = document.createElement('option');
                    fallback.value = selectedCity;
                    fallback.textContent = selectedCity;
                    fallback.selected = true;
                    cityField.appendChild(fallback);
                }

                cityField.dataset.selectedCity = cityField.value || '';
            };

            const loadCities = async (country, selectedCity = '') => {
                if (!country) {
                    cityField.innerHTML = '<option value="">Select city</option>';
                    cityField.dataset.selectedCity = '';
                    cityField.disabled = false;
                    return;
                }

                cityField.disabled = true;
                cityField.innerHTML = '<option value="">Loading...</option>';

                const cities = await fetchCitiesForCountry(country);
                cityField.disabled = false;

                if (!cities.length) {
                    cityField.innerHTML = '<option value="">No cities found</option>';
                    return;
                }

                populateCities(cities, selectedCity);
            };

            countryField.addEventListener('change', () => {
                rememberedCity = '';
                loadCities(countryField.value, '');
            });

            cityField.addEventListener('change', () => {
                rememberedCity = cityField.value || '';
                cityField.dataset.selectedCity = rememberedCity;
            });

            if (countryField.value) {
                loadCities(countryField.value, rememberedCity);
            }
        });
    };

    const initExperienceItem = (scope) => {
        const checkbox = scope.querySelector('[data-currently-checkbox]');
        const endInput = scope.querySelector('[data-end-input]');
        if (!checkbox || !endInput || checkbox.dataset.ready === 'true') {
            return;
        }

        const toggleEndDate = () => {
            const active = checkbox.checked;
            endInput.disabled = active;
            endInput.classList.toggle('opacity-60', active);
            if (active) {
                endInput.value = '';
            }
        };

        checkbox.addEventListener('change', toggleEndDate);
        checkbox.dataset.ready = 'true';
        toggleEndDate();
    };

    const setupCollection = (name, { onCreate } = {}) => {
        const container = document.querySelector(`[data-collection="${name}"]`);
        const template = document.getElementById(`${name}-template`);
        const addButton = document.querySelector(`[data-add="${name}"]`);
        if (!container || !template) {
            return;
        }

        const initialItems = Array.from(container.querySelectorAll('[data-collection-item]'));
        const minItems = Number(container.dataset.minItems || 1);
        let nextIndex = Number(container.dataset.nextIndex ?? initialItems.length);
        if (Number.isNaN(nextIndex)) {
            nextIndex = initialItems.length;
        }
        nextIndex = Math.max(nextIndex, initialItems.length);

        const updateRemoveButtons = () => {
            const items = container.querySelectorAll('[data-collection-item]');
            items.forEach((item) => {
                const removeButton = item.querySelector('[data-action="remove"]');
                if (!removeButton) {
                    return;
                }
                if (items.length <= minItems) {
                    removeButton.classList.add('hidden');
                } else {
                    removeButton.classList.remove('hidden');
                }
            });
        };

        const renderTemplate = (index) => {
            const html = template.innerHTML.replace(/__INDEX__/g, index);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            return wrapper.firstElementChild;
        };

        const registerItem = (item, index) => {
            item.dataset.collectionIndex = index;
            initLocationGroups(item);
            if (typeof onCreate === 'function') {
                onCreate(item, index);
            }
        };

        initialItems.forEach((item, index) => {
            registerItem(item, index);
        });

        addButton?.addEventListener('click', () => {
            const item = renderTemplate(nextIndex);
            container.appendChild(item);
            registerItem(item, nextIndex);
            nextIndex += 1;
            container.dataset.nextIndex = String(nextIndex);
            updateRemoveButtons();

            const focusable = item.querySelector('input, select, textarea');
            focusable?.focus();
        });

        container.addEventListener('click', (event) => {
            const removeButton = event.target.closest('[data-action="remove"]');
            if (!removeButton) {
                return;
            }

            const item = removeButton.closest('[data-collection-item]');
            if (!item) {
                return;
            }

            const items = container.querySelectorAll('[data-collection-item]');
            if (items.length <= minItems) {
                item.querySelectorAll('input, textarea, select').forEach((field) => {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        field.checked = false;
                    } else {
                        field.value = '';
                    }
                });

                item.querySelectorAll('[data-city-select]').forEach((select) => {
                    select.innerHTML = '<option value="">Select city</option>';
                    select.dataset.selectedCity = '';
                });

                return;
            }

            item.remove();
            updateRemoveButtons();
        });

        updateRemoveButtons();
    };

    initLocationGroups();
    setupCollection('education');
    setupCollection('experience', { onCreate: initExperienceItem });
    setupCollection('languages');
    setupCollection('skills');
    setupCollection('hobbies');
};

document.addEventListener('DOMContentLoaded', initCvForm);
