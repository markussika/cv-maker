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
    const stepProgress = document.querySelector('[data-step-progress]');
    const stepMobileLabel = document.querySelector('[data-step-mobile-label]');
    const stepLabelTemplate = stepMobileLabel?.dataset.stepLabelTemplate ?? null;
    const stepMobileTitle = document.querySelector('[data-step-mobile-title]');
    const stepMobileSubtitle = document.querySelector('[data-step-mobile-subtitle]');
    const totalSteps = stepPanels.length;
    const isEditing = form.dataset.isEditing === 'true';
    let currentStep = 1;
    let maxStepVisited = isEditing ? totalSteps : 1;
    const stepErrors = new Map();

    const getScrollElement = () => document.scrollingElement || document.documentElement || document.body;

    const animateScrollTo = (targetPosition, { duration = 700 } = {}) => {
        if (typeof window === 'undefined') {
            return;
        }

        const scrollElement = getScrollElement();
        if (!scrollElement) {
            return;
        }

        const safeTarget = Math.max(targetPosition, 0);

        if (typeof window.requestAnimationFrame !== 'function') {
            window.scrollTo({ top: safeTarget, behavior: 'smooth' });
            return;
        }

        const start = scrollElement.scrollTop ?? window.pageYOffset ?? 0;
        const distance = safeTarget - start;
        if (Math.abs(distance) < 1) {
            return;
        }

        let startTime = null;

        const easeInOutQuad = (t) => (t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t);

        const step = (timestamp) => {
            if (startTime === null) {
                startTime = timestamp;
            }

            const elapsed = timestamp - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = easeInOutQuad(progress);
            const nextPosition = start + distance * easedProgress;

            if (typeof scrollElement.scrollTo === 'function') {
                scrollElement.scrollTo({ top: nextPosition });
            } else {
                scrollElement.scrollTop = nextPosition;
            }

            if (elapsed < duration) {
                window.requestAnimationFrame(step);
            }
        };

        window.requestAnimationFrame(step);
    };

    const scrollToFormContainer = () => {
        if (typeof window === 'undefined') {
            return;
        }

        const scrollElement = getScrollElement();
        if (!scrollElement) {
            return;
        }

        const container =
            document.querySelector('[data-scroll-anchor="cv-form-container"]') ??
            document.querySelector('.bg-white\\/95.backdrop-blur-xl.shadow-xl.rounded-\\[32px\\].p-6.sm\\:p-10.md\\:p-12');

        if (!container) {
            animateScrollTo(0, { duration: 600 });
            return;
        }

        const rect = container.getBoundingClientRect();
        const currentScroll = window.pageYOffset ?? scrollElement.scrollTop ?? 0;
        const offset = 32;
        const targetPosition = Math.max(rect.top + currentScroll - offset, 0);

        animateScrollTo(targetPosition, { duration: 700 });
    };

    const photoInput = form.querySelector('input[name="profile_image"]');
    const photoErrorElement = form.querySelector('[data-photo-error]');
    const photoPreviewContainer = form.querySelector('[data-photo-preview]');
    const photoPreviewImage = photoPreviewContainer?.querySelector('[data-photo-preview-image]') ?? null;
    const photoPreviewPlaceholder = photoPreviewContainer?.querySelector('[data-photo-preview-placeholder]') ?? null;
    const initialPhotoSrc = photoPreviewImage?.getAttribute('src')?.trim() || null;
    const photoSection = form.querySelector('[data-photo-section]');
    const getDatasetValue = (element, key) => {
        if (!element || !element.dataset) {
            return null;
        }

        const raw = element.dataset[key];
        if (typeof raw !== 'string') {
            return null;
        }

        const trimmed = raw.trim();
        return trimmed === '' ? null : trimmed;
    };

    const defaultAvatarPreview = getDatasetValue(photoSection, 'avatarUrl');
    const defaultSelectedPhotoSource =
        getDatasetValue(photoSection, 'selectedSource') ?? (defaultAvatarPreview ? 'avatar' : 'upload');
    const defaultUploadPreview =
        getDatasetValue(photoSection, 'initialUploadUrl') ??
        (defaultSelectedPhotoSource === 'upload' ? initialPhotoSrc : null);
    const photoSourceInputs = photoSection
        ? Array.from(photoSection.querySelectorAll('[data-photo-source-option]'))
        : [];
    let currentPhotoObjectUrl = null;

    const applyPhotoError = (message, { display = true } = {}) => {
        if (!photoInput) {
            return;
        }

        const text = message ?? '';
        photoInput.setCustomValidity(text);

        if (!photoErrorElement) {
            return;
        }

        if (!display) {
            if (!text) {
                photoErrorElement.textContent = '';
            }
            photoErrorElement.classList.add('hidden');
            return;
        }

        if (text) {
            photoErrorElement.textContent = text;
            photoErrorElement.classList.remove('hidden');
        } else {
            photoErrorElement.textContent = '';
            photoErrorElement.classList.add('hidden');
        }
    };

    const clearPhotoError = () => {
        applyPhotoError('');
    };

    const updateStepVisuals = () => {
        stepButtons.forEach((button) => {
            const step = Number(button.dataset.stepTrigger);
            const circle = button.querySelector('[data-step-circle]');
            const isActive = step === currentStep;
            const isVisited = step <= maxStepVisited;
            const hasError = stepErrors.get(step) === true;

            button.classList.toggle('text-slate-900', isActive);
            button.classList.toggle('text-slate-400', !isActive && !hasError);
            button.classList.toggle('text-red-600', !isActive && hasError);
            button.classList.toggle('cursor-pointer', isVisited);
            button.classList.toggle('cursor-not-allowed', !isVisited);
            button.disabled = !isVisited;
            button.tabIndex = isVisited ? 0 : -1;
            button.setAttribute('aria-current', isActive ? 'step' : 'false');
            button.setAttribute('aria-disabled', (!isVisited).toString());
            button.classList.toggle('opacity-60', !isVisited && !isActive);
            button.classList.toggle('opacity-100', isVisited || isActive);
            button.classList.toggle('bg-white', isActive && !hasError);
            button.classList.toggle('bg-white/70', !isActive && !hasError);
            button.classList.toggle('bg-red-50', hasError);
            button.classList.toggle('shadow-lg', isActive && !hasError);
            button.classList.toggle('shadow-sm', !isActive || hasError);
            button.classList.toggle('border-violet-200', isActive && !hasError);
            button.classList.toggle('border-slate-200/80', !hasError && !isActive);
            button.classList.toggle('border-red-300', hasError);
            button.classList.toggle('ring-2', isActive);
            button.classList.toggle('ring-violet-200', isActive && !hasError);
            button.classList.toggle('ring-red-200', isActive && hasError);
            button.classList.toggle('ring-0', !isActive);

            if (!circle) {
                return;
            }

            circle.className = 'flex h-12 w-12 shrink-0 items-center justify-center rounded-full border text-base font-semibold shadow-sm transition-all duration-300';
            if (hasError) {
                circle.classList.add('bg-white', 'text-red-600', 'border-red-400', 'ring-2', 'ring-red-200');
            } else if (step < currentStep) {
                circle.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-blue-200');
            } else if (isActive) {
                circle.classList.add('bg-black', 'text-white', 'border-black', 'ring', 'ring-blue-100');
            } else {
                circle.classList.add('bg-white', 'text-slate-400', 'border-slate-200');
            }
        });

        const activeButton =
            stepButtons.find((button) => Number(button.dataset.stepTrigger) === currentStep) ?? null;

        if (stepProgress) {
            const progressPercent = Math.max((currentStep / totalSteps) * 100, 0);
            stepProgress.style.width = `${progressPercent}%`;
        }

        if (stepMobileLabel) {
            if (stepLabelTemplate) {
                stepMobileLabel.textContent = stepLabelTemplate
                    .replace(':current', String(currentStep))
                    .replace(':total', String(totalSteps));
            } else {
                stepMobileLabel.textContent = `Step ${currentStep} of ${totalSteps}`;
            }
        }

        if (stepMobileTitle) {
            stepMobileTitle.textContent = activeButton?.dataset.stepTitle ?? '';
        }

        if (stepMobileSubtitle) {
            stepMobileSubtitle.textContent = activeButton?.dataset.stepDescription ?? '';
        }

        connectors.forEach((connector) => {
            const index = Number(connector.dataset.stepConnector);
            const nextStepIndex = index + 1;
            const hasError = stepErrors.get(nextStepIndex) === true;
            connector.classList.toggle('bg-blue-500', index < currentStep && !hasError);
            connector.classList.toggle('bg-red-300', hasError && !Number.isNaN(nextStepIndex));
            connector.classList.toggle('bg-slate-200', index >= currentStep && !hasError);
        });

        stepPanels.forEach((panel) => {
            const step = Number(panel.dataset.stepPanel);
            panel.classList.toggle('hidden', step !== currentStep);
        });

        prevButton?.classList.toggle('hidden', currentStep === 1);
        nextButton?.classList.toggle('hidden', currentStep === totalSteps);
        submitButton?.classList.toggle('hidden', currentStep !== totalSteps);
    };

    const getPanelByStep = (step) => stepPanels.find((panel) => Number(panel.dataset.stepPanel) === step) ?? null;

    const markStepValidity = (step, isValid) => {
        if (isValid) {
            stepErrors.delete(step);
        } else {
            stepErrors.set(step, true);
        }
    };

    const validateStep = (step, { report = true } = {}) => {
        const panel = getPanelByStep(step);
        if (!panel) {
            markStepValidity(step, true);
            updateStepVisuals();
            return true;
        }

        const fields = Array.from(panel.querySelectorAll('input, select, textarea')).filter((field) => {
            if (!(field instanceof HTMLElement)) {
                return false;
            }

            if (field.disabled) {
                return false;
            }

            if (field.type === 'hidden') {
                return false;
            }

            return true;
        });

        let isValid = true;

        for (const field of fields) {
            if (typeof field.checkValidity === 'function' && !field.checkValidity()) {
                isValid = false;
                if (report && typeof field.reportValidity === 'function') {
                    field.reportValidity();
                }
                break;
            }
        }

        markStepValidity(step, isValid);
        updateStepVisuals();

        return isValid;
    };

    const allowedPhotoTypes = ['image/jpeg', 'image/png', 'image/webp'];
    const maxPhotoSizeBytes = 2 * 1024 * 1024;

    const matchesImageExtension = (fileName) => {
        if (!fileName || typeof fileName !== 'string') {
            return false;
        }

        return /\.(jpe?g|png|webp|gif|bmp|tiff?|heic|heif|svg)$/i.test(fileName);
    };

    const isAllowedPhotoType = (file) => {
        if (!file) {
            return false;
        }

        if (file.type && file.type.startsWith('image/')) {
            return true;
        }

        if (file.type && allowedPhotoTypes.includes(file.type)) {
            return true;
        }

        if (file.name && matchesImageExtension(file.name)) {
            return true;
        }

        return false;
    };

    const revokeCurrentPhotoObjectUrl = () => {
        if (currentPhotoObjectUrl) {
            URL.revokeObjectURL(currentPhotoObjectUrl);
            currentPhotoObjectUrl = null;
        }
    };

    const showPhotoPlaceholder = () => {
        revokeCurrentPhotoObjectUrl();

        if (photoPreviewImage) {
            photoPreviewImage.classList.add('hidden');
            photoPreviewImage.removeAttribute('src');
        }

        if (photoPreviewPlaceholder) {
            photoPreviewPlaceholder.classList.remove('hidden');
        }
    };

    const showPhotoFromUrl = (url) => {
        if (!url) {
            showPhotoPlaceholder();
            return;
        }

        revokeCurrentPhotoObjectUrl();

        if (photoPreviewImage) {
            photoPreviewImage.src = url;
            photoPreviewImage.classList.remove('hidden');
        }

        if (photoPreviewPlaceholder) {
            photoPreviewPlaceholder.classList.add('hidden');
        }
    };

    const getSelectedPhotoSource = () => {
        if (!photoSourceInputs.length) {
            return defaultSelectedPhotoSource;
        }

        const selected = photoSourceInputs.find((input) => input.checked);
        if (selected && typeof selected.value === 'string') {
            return selected.value;
        }

        return defaultSelectedPhotoSource;
    };

    const showInitialPhoto = () => {
        applyPhotoSourceToPreview();
    };

    const updatePhotoPreview = (file) => {
        if (!photoPreviewContainer) {
            return;
        }

        if (!file) {
            applyPhotoSourceToPreview();
            return;
        }

        const objectUrl = URL.createObjectURL(file);
        revokeCurrentPhotoObjectUrl();
        currentPhotoObjectUrl = objectUrl;

        if (photoPreviewImage) {
            photoPreviewImage.src = objectUrl;
            photoPreviewImage.classList.remove('hidden');
        }

        if (photoPreviewPlaceholder) {
            photoPreviewPlaceholder.classList.add('hidden');
        }
    };

    const applyPhotoSourceToPreview = ({ resetFileSelection = false } = {}) => {
        const source = getSelectedPhotoSource();

        if (source === 'avatar' && defaultAvatarPreview) {
            if (resetFileSelection && photoInput) {
                photoInput.value = '';
            }

            validatePhotoFile(null);
            showPhotoFromUrl(defaultAvatarPreview);
            return;
        }

        const file = photoInput?.files && photoInput.files[0] ? photoInput.files[0] : null;
        if (file) {
            const isValid = validatePhotoFile(file);
            if (isValid) {
                updatePhotoPreview(file);
                return;
            }

            if (resetFileSelection && photoInput) {
                photoInput.value = '';
            }
        } else {
            validatePhotoFile(null);
        }

        if (defaultUploadPreview) {
            showPhotoFromUrl(defaultUploadPreview);
        } else {
            showPhotoPlaceholder();
        }
    };

    const validatePhotoFile = (file) => {
        if (!photoInput) {
            return false;
        }

        if (!file) {
            clearPhotoError();
            validateStep(1, { report: false });
            return true;
        }

        if (!isAllowedPhotoType(file)) {
            applyPhotoError('Please upload an image file (JPG, PNG, WebP, HEIC, GIF, etc.).');
            validateStep(1, { report: false });
            return false;
        }

        if (file.size > maxPhotoSizeBytes) {
            applyPhotoError('Images must be 2 MB or smaller.');
            validateStep(1, { report: false });
            return false;
        }

        clearPhotoError();
        validateStep(1, { report: false });
        return true;
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
        if (currentStep >= totalSteps) {
            return;
        }

        if (!validateStep(currentStep)) {
            return;
        }

        currentStep += 1;
        maxStepVisited = Math.max(maxStepVisited, currentStep);
        updateStepVisuals();
        scrollToFormContainer();
    });

    prevButton?.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep -= 1;
            updateStepVisuals();
            scrollToFormContainer();
        }
    });

    form.addEventListener('submit', (event) => {
        for (let step = 1; step <= totalSteps; step += 1) {
            const isValid = validateStep(step);
            if (!isValid) {
                event.preventDefault();
                currentStep = step;
                maxStepVisited = Math.max(maxStepVisited, currentStep);
                updateStepVisuals();
                break;
            }
        }
    });

    form.addEventListener('input', (event) => {
        const target = event.target;
        if (!(target instanceof HTMLElement)) {
            return;
        }

        if (photoInput && target === photoInput) {
            return;
        }

        const panel = target.closest('[data-step-panel]');
        if (!panel) {
            return;
        }

        const step = Number(panel.dataset.stepPanel);
        if (Number.isNaN(step)) {
            return;
        }

        validateStep(step, { report: false });
    });

    form.addEventListener('change', (event) => {
        const target = event.target;
        if (!(target instanceof HTMLElement)) {
            return;
        }

        if (photoInput && target === photoInput) {
            return;
        }

        const panel = target.closest('[data-step-panel]');
        if (!panel) {
            return;
        }

        const step = Number(panel.dataset.stepPanel);
        if (Number.isNaN(step)) {
            return;
        }

        validateStep(step, { report: false });
    });

    stepPanels.forEach((panel) => {
        const step = Number(panel.dataset.stepPanel);
        if (Number.isNaN(step)) {
            return;
        }

        if (panel.querySelector('.border-red-500')) {
            stepErrors.set(step, true);
        }
    });

    updateStepVisuals();

    if (photoPreviewContainer) {
        showInitialPhoto();
        window.addEventListener('beforeunload', revokeCurrentPhotoObjectUrl);
    }

    if (photoSourceInputs.length > 0) {
        photoSourceInputs.forEach((input) => {
            input.addEventListener('change', () => {
                const shouldReset = input.value === 'avatar';
                applyPhotoSourceToPreview({ resetFileSelection: shouldReset });
            });
        });
    }

    if (photoInput) {
        photoInput.addEventListener('change', () => {
            const file = photoInput.files && photoInput.files[0] ? photoInput.files[0] : null;

            if (file) {
                const uploadOption = photoSourceInputs.find((input) => input.value === 'upload');
                if (uploadOption && !uploadOption.checked) {
                    uploadOption.checked = true;
                }
            }

            const isValidPhoto = validatePhotoFile(file);
            if (isValidPhoto && file) {
                updatePhotoPreview(file);
            } else {
                applyPhotoSourceToPreview();
            }
        });

        if (photoInput.files && photoInput.files[0]) {
            const isValidPhoto = validatePhotoFile(photoInput.files[0]);
            if (isValidPhoto) {
                updatePhotoPreview(photoInput.files[0]);
            }
        }
    }

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
