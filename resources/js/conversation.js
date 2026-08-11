import Echo from './echo';

const scrollConversationToBottom = () => {
    const messagesContainer = document.getElementById('conversation-messages');

    if (!messagesContainer) {
        return;
    }

    messagesContainer.scrollTop = messagesContainer.scrollHeight;
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', scrollConversationToBottom);
} else {
    scrollConversationToBottom();
}

window.startConversationListener = (conversationId) => {

    console.log('Listening to conversation:', conversationId);

    Echo.private(`conversation.${conversationId}`)
        .listen('.message.sent', (event) => {
            console.log('Realtime Message:', event);
        });

};
