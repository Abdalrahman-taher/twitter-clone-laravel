

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('mediaComposer', (imageInputId, videoInputId) => ({
    previews: [],

    syncMedia(event) {
        if (!event.target.matches('input[type="file"]')) {
            return;
        }

        this.rebuildPreviews();
    },

    rebuildPreviews() {
        this.previews.forEach((preview) => URL.revokeObjectURL(preview.url));
        this.previews = [];

        this.addFilesFromInput(imageInputId, 'image');
        this.addFilesFromInput(videoInputId, 'video');
    },

    addFilesFromInput(inputId, type) {
        const input = document.getElementById(inputId);

        if (!input || !input.files) {
            return;
        }

        Array.from(input.files).forEach((file, index) => {
            this.previews.push({
                id: `${inputId}-${index}-${file.name}-${file.lastModified}`,
                inputId,
                index,
                type,
                url: URL.createObjectURL(file),
            });
        });
    },

    removeMedia(preview) {
        const input = document.getElementById(preview.inputId);

        if (!input || !input.files) {
            return;
        }

        const transfer = new DataTransfer();

        Array.from(input.files).forEach((file, index) => {
            if (index !== preview.index) {
                transfer.items.add(file);
            }
        });

        input.files = transfer.files;
        this.rebuildPreviews();
    },

    destroy() {
        this.previews.forEach((preview) => URL.revokeObjectURL(preview.url));
    },
}));

Alpine.data('mediaGallery', (images) => ({
    images,
    open: false,
    activeIndex: 0,

    openAt(index) {
        this.activeIndex = index;
        this.open = true;
        document.body.classList.add('overflow-hidden');
    },

    close() {
        this.open = false;
        document.body.classList.remove('overflow-hidden');
    },

    next() {
        this.activeIndex = (this.activeIndex + 1) % this.images.length;
    },

    previous() {
        this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length;
    },
}));

Alpine.data('tweetShare', (title, url) => ({
    copied: false,

    async share() {
        if (navigator.share) {
            try {
                await navigator.share({ title, url });
                return;
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }
            }
        }

        if (navigator.clipboard) {
            await navigator.clipboard.writeText(url);
        } else {
            const textarea = document.createElement('textarea');
            textarea.value = url;
            textarea.setAttribute('readonly', '');
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        }

        this.copied = true;
        setTimeout(() => {
            this.copied = false;
        }, 1600);
    },
}));

Alpine.start();
