import Echo from './echo';

const scrollConversationToBottom = () => {
    const messagesContainer = document.getElementById('conversation-messages');

    if (!messagesContainer) {
        return;
    }

    messagesContainer.scrollTop = messagesContainer.scrollHeight;
};

const isMessageComposerForm = (form) => {
    if (!form) {
        return false;
    }

    const action = form.getAttribute('action');

    if (!action) {
        return false;
    }

    const path = new URL(action, window.location.origin).pathname;

    return /^\/conversations\/[^/]+\/messages$/.test(path);
};

const resetMessageComposer = (form) => {
    const textarea = form.querySelector('textarea[name="body"]');
    const fileInputs = form.querySelectorAll('input[type="file"]');

    form.reset();

    if (textarea) {
        textarea.value = '';
        textarea.style.height = '';
        textarea.dispatchEvent(new Event('input', {bubbles: true}));
    }

    fileInputs.forEach((input) => {
        input.value = '';
        input.dispatchEvent(new Event('change', {bubbles: true}));
    });
};

const hasMessageComposerContent = (form) => {
    const body = form.querySelector('textarea[name="body"]')?.value.trim();
    const fileInputs = form.querySelectorAll('input[type="file"]');
    const hasFiles = Array.from(fileInputs).some((input) => input.files.length > 0);

    return Boolean(body) || hasFiles;
};

const handleMessageComposerSubmit = (event) => {
    const form = event.target;

    if (!isMessageComposerForm(form)) {
        return;
    }

    event.preventDefault();

    if (!hasMessageComposerContent(form)) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            ...(csrfToken ? {'X-CSRF-TOKEN': csrfToken} : {}),
        },
    }).then((response) => {
        if (!response.ok) {
            return;
        }

        resetMessageComposer(form);
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        scrollConversationToBottom();
        document.addEventListener('submit', handleMessageComposerSubmit);
    });
} else {
    scrollConversationToBottom();
    document.addEventListener('submit', handleMessageComposerSubmit);
}

window.startConversationListener = (conversationId) => {

    console.log('Listening to conversation:', conversationId);

    Echo.private(`conversation.${conversationId}`)
        .listen('.message.sent', (event) => {
            console.log('Realtime Message:', event);

            const messageId = event.message.id;
            const messagesContainer = document.getElementById('conversation-messages');

            if (!messagesContainer) {
                return;
            }

            const existingMessage = messagesContainer.querySelector(`[data-message-id="${messageId}"]`);

            if (existingMessage) {
                return;
            }

            fetch(`/messages/${messageId}/html`)
                .then((response) => {
                    if (!response.ok) {
                        return;
                    }

                    return response.text();
                })
                .then((html) => {
                    if (!html) {
                        return;
                    }

                    messagesContainer.insertAdjacentHTML('beforeend', html);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
        });

};
