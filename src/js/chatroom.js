document.addEventListener('DOMContentLoaded', function () {
    // 获取 DOM 元素
    const emojiButton = document.getElementById('emojiButton');
    const emojiPickerContainer = document.getElementById('emojiPicker');
    const messageInput = document.getElementById('messageInput');
    const imageInput = document.getElementById('imageInput');
    const messageForm = document.getElementById('messageForm');
    const chatbox = document.getElementById('chatbox');

    // AI 相关配置
    const apiKey = "56bb819254e025346a500068f2f8dddf.rJLyLghELuGTVH9S";
    const apiUrl = "https://open.bigmodel.cn/api/paas/v4/chat/completions";
    const model = "glm-4-flash";

    // 初始化对话消息
    let messages = [
        {
            "role": "system",
            "content": "你现在是@聊天搭子，请作为一个聊天搭子尽情的与用户进行聊天吧！。"
        }
    ];

    // 记录是否是首次加载
    let isFirstLoad = true;
    // 记录最后消息的ID或时间戳
    let lastMessageId = null;

    // 滚动到底部的函数
    function scrollToBottom(force = false) {
        if (force || isFirstLoad) {
            chatbox.scrollTop = chatbox.scrollHeight;
            if (isFirstLoad) {
                isFirstLoad = false;
            }
        }
    }

    // 点击 Emoji 按钮时动态加载 emoji.html
    emojiButton.addEventListener('click', () => {
        if (emojiPickerContainer.innerHTML === '') {
            fetch('src/emoji.html')
                .then(response => response.text())
                .then(data => {
                    emojiPickerContainer.innerHTML = data;
                    bindEmojiClickEvent();
                    emojiPickerContainer.style.display = 'block';
                })
                .catch(error => console.error('Error loading emojis:', error));
        } else {
            emojiPickerContainer.style.display = emojiPickerContainer.style.display === 'none' ? 'block' : 'none';
        }
    });

    // 绑定点击 Emoji 事件
    function bindEmojiClickEvent() {
        const emojis = emojiPickerContainer.querySelectorAll('.emoji');
        emojis.forEach(emoji => {
            emoji.addEventListener('click', function () {
                messageInput.value += this.textContent;
                emojiPickerContainer.style.display = 'none';
                messageInput.focus();
            });
        });
    }

    // 处理发送消息
    messageForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const message = messageInput.value.trim();
        const imageFile = imageInput.files[0];

        if (!message && !imageFile) {
            return;
        }

        // 创建 FormData
        const formData = new FormData();
        formData.append('message', message);
        formData.append('room_id', roomId);
        if (imageFile) {
            formData.append('image', imageFile);
        }

        try {
            const response = await fetch('send_message.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            messageInput.value = '';
            imageInput.value = '';

            // 发送成功后强制滚动到底部
            scrollToBottom(true);

            if (data.status === 'success') {
                if (data.ai_triggered) {
                    const aiResponse = await callGLMAPI(message);
                    const assistantReply = aiResponse.choices[0]?.message?.content || "AI没有回复，请稍后再试。";
                    await saveAIMessage(assistantReply);
                }
            }
        } catch (error) {
            console.error('发送消息时出错:', error);
        }
    });

    // 将消息添加到聊天框
    function addMessageToChatbox(sender, message) {
        const messageElement = document.createElement('p');
        messageElement.classList.add('message-item');
        messageElement.innerHTML = `<strong>${sender}：</strong>${message}`;
        messageElement.style.opacity = '0';
        
        // 保存当前滚动位置
        const scrollPos = chatbox.scrollTop;
        const wasAtBottom = (chatbox.scrollHeight - chatbox.scrollTop) === chatbox.clientHeight;
        
        chatbox.appendChild(messageElement);
        
        // 如果之前在底部，则保持在底部
        if (wasAtBottom) {
            chatbox.scrollTop = chatbox.scrollHeight;
        } else {
            chatbox.scrollTop = scrollPos;
        }
        
        requestAnimationFrame(() => {
            messageElement.style.transition = 'opacity 0.3s ease-in';
            messageElement.style.opacity = '1';
        });
    }

    // 调用GLM-4-Flash模型的API
    async function callGLMAPI(userMessage) {
        try {
            const response = await fetch(apiUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${apiKey}`
                },
                body: JSON.stringify({
                    model: model,
                    messages: [
                        ...messages,
                        { "role": "user", "content": userMessage }
                    ],
                    max_tokens: 500,
                    temperature: 0.7
                })
            });
            return await response.json();
        } catch (error) {
            console.error('调用AI接口时出错:', error);
            return { choices: [{ message: { content: "调用AI接口时出错，请稍后再试。" } }] };
        }
    }

    // 保存 AI 消息
    async function saveAIMessage(message) {
        try {
            const response = await fetch('send_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `message=${encodeURIComponent(message)}&room_id=${encodeURIComponent(roomId)}&is_ai=1`
            });

            const data = await response.json();
            if (data.status !== 'success') {
                console.error('保存AI消息时出错:', data.message);
            }
        } catch (error) {
            console.error('保存AI消息时出错:', error);
        }
    }

    // 更新消息而不改变滚动位置
   // 更新消息而不改变滚动位置
async function updateMessages() {
    try {
        const response = await fetch(`fetch_messages.php?room_id=${encodeURIComponent(roomId)}&last_id=${lastMessageId || ''}`);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        // 检查是否在底部，或者是首次加载
        const atBottom = chatbox.scrollHeight - chatbox.scrollTop === chatbox.clientHeight || isFirstLoad;

        // 如果有新消息，则追加到聊天框
        data.forEach(message => {
            const sender = message.is_ai === 1 ? 'AI' : message.username;
            addMessageToChatbox(sender, message.message);
            lastMessageId = message.id;
        });

        // 如果是首次加载或用户在底部，则自动滚动到底部
        if (atBottom) {
            scrollToBottom(true);
        }

        // 更新首次加载标志
        if (isFirstLoad) isFirstLoad = false;

    } catch (error) {
        console.error('Error fetching messages:', error);
    }
}


    // 定期更新消息
    setInterval(updateMessages, 2000);

    // 初始加载消息
    updateMessages();

    // 点击页面其他区域时隐藏emoji选择器
    document.addEventListener('click', function(event) {
        if (!emojiButton.contains(event.target) && !emojiPickerContainer.contains(event.target)) {
            emojiPickerContainer.style.display = 'none';
        }
    });
});
