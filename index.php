<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var lastTimestamp = '';
            var currentUserId = 1; // Replace with the actual current user's ID
            var receiverId = 2;

            function appendMessage(msg) {
                var messageType = (currentUserId == msg.s_id) ? 'sent' : 'received';
                var messageRow = $('<div>').addClass('row');
                var messageCol = $('<div>').addClass(messageType === 'received' ? 'col-md-6' : 'col-md-6 offset-md-6');
                var messageDiv = $('<div>').addClass(messageType === 'received' ? 'r_msg' : 's_msg');
                var messageP = $('<p>').addClass(messageType === 'received' ? 'msg_p_r' : 'msg_p_s').text(msg.msg);
                var timeP = $('<p>').addClass('msg_time').text(msg.time);

                messageDiv.append(messageP).append(timeP);
                messageCol.append(messageDiv);
                messageRow.append(messageCol);
                $('.chat_box').append(messageRow);

                // Scroll to the bottom of the chat box
                $('.chat_box').scrollTop($('.chat_box')[0].scrollHeight);
            }


            function fetchMessages() {
                $.ajax({
                    type: "GET",
                    url: "fetch_messages.php",
                    data: { 
                        user_id: currentUserId,
                        receiver_id: receiverId,
                        lastTimestamp: lastTimestamp
                    },
                    success: function(response) {
                        var messages = JSON.parse(response);
                        if (messages.length > 0) {
                            $.each(messages, function(i, msg) {
                                appendMessage(msg);
                                if (i === messages.length - 1) {
                                    lastTimestamp = msg.timestamp;
                                }
                            });
                        }
                    },
                    error: function() {
                        console.log('Error fetching messages');
                    }
                });
            }


            // Function to send a message
            function sendMessage(sender_id, receiver_id, message) {
                $.ajax({
                    type: "POST",
                    url: "send_message.php", // Replace with the path to your PHP script for sending messages
                    data: {
                        sender_id: sender_id,
                        receiver_id: receiver_id,
                        message: message
                    },
                    success: function(response) {
                        console.log(response);
                        
                    }
                });
            }

            // Function to fetch messages
            // function fetchMessages() {
            //     $.ajax({
            //         type: "GET",
            //         url: "fetch_messages.php", // Replace with the path to your PHP script for fetching messages
            //         success: function(response) {
            //             // Update your chat interface with the fetched messages
            //             console.log(response);
            //         }
            //     });
            // }

            // Event listener for the send button
            $('#sendButton').click(function() {
                var message = $('#messageInput').val().trim(); // Get the trimmed message text

                if (message === '') {
                    $("#messageInput").css('border-color', 'red'); // Error message for empty input
                } else {
                    var sender_id = 1; // Set sender ID
                    var receiver_id = 2; // Set receiver ID
                    $("#messageInput").css('border-color', ''); 
                    $("#messageInput").val(''); 
                    sendMessage(sender_id, receiver_id, message);
                }
            });

            // Initial fetch of messages
            fetchMessages();

            // Fetch new messages every 3 seconds
            setInterval(fetchMessages, 3000);
        });
    </script>
  </head>
  <body>
    <style>
        .chat_box{
            height:600px;
            overflow: hidden;
            overflow-y:scroll;
            width:100%;
        }
        #style-4::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            background-color: #F5F5F5;
        }

        #style-4::-webkit-scrollbar
        {
            width: 10px;
            background-color: #F5F5F5;
        }

        #style-4::-webkit-scrollbar-thumb
        {
            background-color: #000000;
            border: 2px solid #555555;
        }
        .type_messaeg{
            margin-top:20px;
        }
        .r_msg .msg_p_r{
            font-size:14px;
            background: #343a3f;
            padding:10px;
            border-radius:10px;
            color:#fff;
        }
       .s_msg{
        padding-right:15px;
       }
        .s_msg .msg_p_s{
            font-size:14px;
            background: #eee;
            padding:10px;
            border-radius:10px;
            color:#000;
        }
        .chat_box .msg_time{
            font-size:12px;
            text-align:right;
            margin-top:-10px;
            margin-right:10px;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <b>User One</b>
                    </div>
                    <div class="card-body">
                        <div class="chat_box" id="style-4">
                           
                            
                            
                        </div>
                        <div class="type_messaeg">
                            <textarea name="msg_type" id="messageInput" class="form-control" placeholder="Type..." id="" rows="2"></textarea>
                            <button class="btn btn-dark btn-sm mt-2 px-3" id="sendButton">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>