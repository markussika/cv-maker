const initProfilePhotoPreview = () => {
    const input = document.querySelector('[data-profile-photo-input]');
    if (!input) {
        return;
    }

    const previewContainer = document.querySelector('[data-profile-photo-preview]');
    const previewImage = previewContainer?.querySelector('[data-profile-photo-preview-image]') ?? null;
    const placeholder = previewContainer?.querySelector('[data-profile-photo-placeholder]') ?? null;
    const removeCheckbox = document.querySelector('[data-profile-photo-remove]');
    const initialPreviewSrc = previewImage?.getAttribute('src')?.trim() || null;
    let currentObjectUrl = null;

    const revokeCurrentObjectUrl = () => {
        if (currentObjectUrl) {
            URL.revokeObjectURL(currentObjectUrl);
            currentObjectUrl = null;
        }
    };

    const showPlaceholder = () => {
        revokeCurrentObjectUrl();

        if (previewImage) {
            previewImage.classList.add('hidden');
            previewImage.removeAttribute('src');
        }

        if (placeholder) {
            placeholder.classList.remove('hidden');
        }
    };

    const showImage = (url) => {
        if (!url) {
            showPlaceholder();
            return;
        }

        if (previewImage) {
            previewImage.src = url;
            previewImage.classList.remove('hidden');
        }

        if (placeholder) {
            placeholder.classList.add('hidden');
        }
    };

    const resetPreview = () => {
        if (initialPreviewSrc) {
            showImage(initialPreviewSrc);
        } else {
            showPlaceholder();
        }
    };

    const handleFileChange = () => {
        const [file] = input.files || [];

        if (!file) {
            if (removeCheckbox?.checked) {
                showPlaceholder();
            } else {
                resetPreview();
            }
            return;
        }

        const objectUrl = URL.createObjectURL(file);
        revokeCurrentObjectUrl();
        currentObjectUrl = objectUrl;

        if (removeCheckbox) {
            removeCheckbox.checked = false;
        }

        showImage(objectUrl);
    };

    const handleRemoveChange = () => {
        if (!removeCheckbox) {
            return;
        }

        if (removeCheckbox.checked) {
            if (input.value) {
                input.value = '';
            }
            showPlaceholder();
        } else {
            resetPreview();
        }
    };

    input.addEventListener('change', handleFileChange);
    removeCheckbox?.addEventListener('change', handleRemoveChange);

    window.addEventListener('beforeunload', revokeCurrentObjectUrl);
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initProfilePhotoPreview);
} else {
    initProfilePhotoPreview();
}
