<!DOCTYPE html>
<html>
     <head>
          <meta name="csrf-token" content="{{  csrf_token() }}" />
     <title>Chat Test</title>
     <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
     
     </head>
     <body>
          <h1>Chat Test</h1>
          <p>
          Try publishing an event to channel <code>my-channel</code>
          with event name <code>my-event</code>.
          </p>

          <div>
               <div id="display">
                    <!-- message will shown in here  -->
               </div>

               <input type="text" id="message" placeholder="Write something...."/>
               <button type="button" id="send">Sent</button>
          </div>

          <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
          <script>

               $(document).ready(function(){
                    // Pusher.logToConsole = true;

                    var pusher = new Pusher('e202c50a573fa42ec8ed', {
                         cluster: 'ap1'
                    });

                    var channel = pusher.subscribe('chat-channel');
                    channel.bind('message-event', function(data) {
                         console.log(data);
                         $("#display").append(`<p>${data.message}</p>`);
                    });

                    $("#send").click(function(){
                         const message = $("#message").val();
                         // console.log(message);

                         $.ajax({
                              url: "/chatmessages",
                              type:"POST",
                              data:{sms:message},
                              headers:{"X-CSRF-TOKEN":$("meta[name='csrf-token']").attr("content")},
                              success: function(response){
                                   console.log(response);
                              }
                         });
                    });
               });  

          // Enable pusher logging - don't include this in production
          
          </script>
     </body>
</html>