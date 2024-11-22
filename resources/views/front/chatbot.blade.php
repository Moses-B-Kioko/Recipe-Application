@extends('front.layouts.app')
@section('content')
<div id="chat-box" style="border: 1px solid #ddd; padding: 10px; width: 300px;">
    <div id="chat-log" style="height: 200px; overflow-y: auto; padding: 5px;"></div>
    <input type="text" id="user-message" placeholder="Ask a question..." style="width: 100%; margin-top: 5px; padding: 5px; box-sizing: border-box;" />
    <button id="send-message" style="margin-top: 5px; padding: 5px 10px; background-color: #007bff; color: white; border: none; cursor: pointer;">
        Send
    </button>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('send-message').addEventListener('click', async () => {
    const userMessage = document.getElementById('user-message').value;
    if (!userMessage) return;

    // Display the user's message
    const chatLog = document.getElementById('chat-log');
    chatLog.innerHTML += `<p><strong>You:</strong> ${userMessage}</p>`;

    // Clear input
    document.getElementById('user-message').value = '';

    // Send message to Laravel backend
    const response = await fetch('/chatbot', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ message: userMessage })
    });
    
    const data = await response.json();
    const botReply = data.reply;

    // Display the bot's response
    chatLog.innerHTML += `<p><strong>Bot:</strong> ${botReply}</p>`;
    chatLog.scrollTop = chatLog.scrollHeight; // Auto-scroll to the latest message
});

</script>
@endsection