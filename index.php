<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Realtime Chat UI</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .chat-container {
            width: 380px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            height: 520px;
            overflow: hidden;
        }
        .chat-header {
            background: #0084ff;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }
        .chat-box {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
            background: #fdfdfd;
        }
        .message {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 14px;
            word-wrap: break-word;
            line-height: 1.4;
        }
       
        .message.sent {
            background: #0084ff;
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 2px;
        }
       
        .message.received {
            background: #e4e6eb;
            color: #050505;
            align-self: flex-start;
            border-bottom-left-radius: 2px;
        }
        .chat-input-area {
            display: flex;
            padding: 12px;
            background: #fff;
            border-top: 1px solid #ddd;
        }
        .chat-input-area input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
            font-size: 14px;
        }
        .chat-input-area input:focus {
            border-color: #0084ff;
        }
        .chat-input-area button {
            margin-left: 8px;
            padding: 0 16px;
            background: #0084ff;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
        }
        .chat-input-area button:hover {
            background: #006dd9;
        }
    </style>
</head>
<body>

    <div class="chat-container">
        <div class="chat-header">Ruang Chat Sederhana</div>
        
        <div id="chatBox" class="chat-box"></div>

        <div class="chat-input-area">
            <input type="text" id="messageInput" placeholder="Ketik pesan..." onkeypress="handleKeyPress(event)">
            <button onclick="sendMessage()">Kirim</button>
        </div>
    </div>

    <script>
        const ws = new WebSocket('ws://localhost:8080');
        const chatBox = document.getElementById('chatBox');
        
        ws.onmessage = function(event) {
            appendMessage(event.data, 'received');
        };

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            if (!message) return;
            
            ws.send(message);
            
            input.value = '';
        }

        function appendMessage(text, type) {
            const div = document.createElement('div');
            div.classList.add('message', type);
            div.textContent = text;
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
        
        function handleKeyPress(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }
    </script>
</body>
</html>