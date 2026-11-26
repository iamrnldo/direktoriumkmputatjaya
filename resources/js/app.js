

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

// Immediate local previews for all image upload forms; previews do not upload files by themselves.
function bindImagePreviews() {
    document.querySelectorAll('input[type="file"][data-image-preview]').forEach((input) => {
        const target = document.getElementById(input.dataset.imagePreview);
        if (!target || input.dataset.previewBound === '1') return;
        input.dataset.previewBound = '1';

        input.addEventListener('change', () => {
            target.replaceChildren();
            const files = Array.from(input.files || []).filter((file) => file.type.startsWith('image/'));
            target.classList.toggle('hidden', files.length === 0);

            files.forEach((file) => {
                const card = document.createElement('div');
                card.className = 'overflow-hidden rounded-xl border border-slate-200 bg-white';
                const image = document.createElement('img');
                image.className = 'h-28 w-full object-cover';
                image.alt = file.name;
                const url = URL.createObjectURL(file);
                image.src = url;
                image.onload = () => URL.revokeObjectURL(url);
                const name = document.createElement('p');
                name.className = 'truncate px-2 py-1.5 text-xs text-slate-600';
                name.textContent = file.name;
                card.append(image, name);
                target.append(card);
            });
        });
    });
}
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bindImagePreviews, { once: true });
} else {
    bindImagePreviews();
}

Alpine.plugin(intersect);

// Accessibility Store
Alpine.store('a11y', {
    dark: localStorage.getItem('darkMode') === 'true',
    fontSize: localStorage.getItem('fontSize') || 'normal',
    highContrast: localStorage.getItem('highContrast') === 'true',

    init() {
        this.applyClasses();
    },

    toggleDark() {
        this.dark = !this.dark;
        localStorage.setItem('darkMode', this.dark);
        this.applyClasses();
    },

    setFontSize(size) {
        this.fontSize = size;
        localStorage.setItem('fontSize', size);
        this.applyClasses();
    },

    toggleHighContrast() {
        this.highContrast = !this.highContrast;
        localStorage.setItem('highContrast', this.highContrast);
        this.applyClasses();
    },

    applyClasses() {
        const html = document.documentElement;
        html.classList.toggle('dark', this.dark);
        html.classList.toggle('font-large', this.fontSize === 'large');
        html.classList.toggle('font-xlarge', this.fontSize === 'xlarge');
        html.classList.toggle('high-contrast', this.highContrast);
    }
});

window.Alpine = Alpine;

Alpine.start();
