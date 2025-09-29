const initTemplateModals = () => {
    const dialogs = new Map();

    document.querySelectorAll('.createit-modal').forEach((dialog) => {
        dialogs.set(dialog.id, dialog);

        dialog.addEventListener('click', (event) => {
            const rect = dialog.getBoundingClientRect();
            const clickedOutside =
                event.clientX < rect.left ||
                event.clientX > rect.right ||
                event.clientY < rect.top ||
                event.clientY > rect.bottom;

            if (clickedOutside) {
                dialog.close();
            }
        });
    });

    document.querySelectorAll('[data-preview-trigger]').forEach((button) => {
        button.addEventListener('click', (event) => {
            const targetId = button.getAttribute('data-preview-trigger');
            const dialog = targetId ? dialogs.get(targetId) : null;

            if (dialog && typeof dialog.showModal === 'function') {
                event.preventDefault();
                dialog.showModal();
                return;
            }

            if (dialog) {
                event.preventDefault();
                dialog.setAttribute('open', 'open');
            }
        });
    });

    document.querySelectorAll('[data-preview-close]').forEach((button) => {
        button.addEventListener('click', () => {
            const dialog = button.closest('.createit-modal');
            if (dialog && typeof dialog.close === 'function') {
                dialog.close();
            } else if (dialog) {
                dialog.removeAttribute('open');
            }
        });
    });
};

document.addEventListener('DOMContentLoaded', initTemplateModals);
