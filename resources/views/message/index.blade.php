<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="chat">
        <div class="top">
            <img src="/Pictures/Passport.png" alt="Avatar">
            <div>
                <p>Ross Edlin</p>
                <small>Online</small>
            </div>
        </div>

        <div class="messages">
            @include('message.receive', ['message' => "HEY! What's up! &nbsp;"])
        </div>

        <div class="bottom">
            <form action="">
                <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
                <button type="submit"></button>
            </form>
        </div>

    </div>
    <script>
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', { cluster: 'eu' });
        const channel = pusher.subscribe('public');

        // Received message
        channel.bind('chat', function(data) {
            console.log("Received message:", data); // Debugging
            $.post("/received", {
                _token: '{{ csrf_token() }}',
                message: data.message,
            })
            .done(function(res) {
                $(".messages > message").last()after(res);
                $(document).scrollTop($(document).height());
            });
        });

        // Broadcast messages
        $("form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "/broadcast",
                method: 'POST',
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id,
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    message: $("#message").val(),
                }
            }).done(function(res) {
                console.log("Broadcast response:", res); // Debugging
                $(".messages > message").last()after(res);
                $("form #message").val('');
                $(document).scrollTop($(document).height());
            });
        });
    </script>
</body>
</html>
