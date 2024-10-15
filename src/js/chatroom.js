document.addEventListener('DOMContentLoaded', function() {
    // 获取 DOM 元素
    const emojiButton = document.getElementById('emojiButton');
    const emojiPickerContainer = document.getElementById('emojiPicker');
    const messageInput = document.getElementById('messageInput');
    const messageForm = document.getElementById('messageForm');
    const chatbox = document.getElementById('chatbox');

    // 点击 Emoji 按钮时动态加载 emoji.html 并显示/隐藏 emoji 选择器
    emojiButton.addEventListener('click', () => {
        // 如果 emojiPickerContainer 为空，则动态加载表情包
        if (emojiPickerContainer.innerHTML === '') {
            console.log("Loading emoji picker..."); // 添加日志检查加载状态
            // 使用 fetch 动态加载 emoji.html
            fetch('src/emoji.html')  // 确保路径正确
                .then(response => response.text())
                .then(data => {
                    emojiPickerContainer.innerHTML = data;
                    bindEmojiClickEvent();  // 绑定表情点击事件
                    emojiPickerContainer.style.display = 'block';  // 显示选择器
                    console.log("Emoji picker loaded and displayed.");
                })
                .catch(error => console.error('Error loading emojis:', error));
        } else {
            // 切换显示/隐藏
            console.log("Toggling emoji picker visibility.");
            emojiPickerContainer.style.display = emojiPickerContainer.style.display === 'none' ? 'block' : 'none';
        }
    });

    // 绑定点击 Emoji 时的事件
    function bindEmojiClickEvent() {
        const emojis = document.querySelectorAll('#emojiPicker .emoji');
        console.log(`Found ${emojis.length} emojis.`); // 检查找到的表情数量
        emojis.forEach(emoji => {
            emoji.addEventListener('click', function() {
                const emoji = this.textContent;
                messageInput.value += emoji;  // 将表情插入到输入框中
                console.log(`Emoji clicked: ${emoji}`);  // 输出被点击的表情
                emojiPickerContainer.style.display = 'none';  // 选择完表情后隐藏选择器
            });
        });
    }

    // 表单提交事件处理，使用 AJAX 发送消息
    messageForm.addEventListener('submit', function(event) {
        event.preventDefault();  // 阻止表单默认提交行为

        const message = messageInput.value.trim();  // 获取输入的消息并去除空格

        // 检查消息内容是否为空
        if (!message) {
            console.error("不能发送空消息！");
            return;
        }

        // 使用 AJAX 发送消息到 send_message.php
        fetch('send_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `message=${encodeURIComponent(message)}&room_id=${encodeURIComponent(roomId)}`  // 使用 roomId
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // 清空输入框
                messageInput.value = '';

                // 手动刷新消息列表
                fetchMessages();
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    });

    // 自动加载最新消息
    function fetchMessages() {
        fetch(`fetch_messages.php?room_id=${encodeURIComponent(roomId)}`)  // 确保 roomId 传递正确
            .then(response => response.json())
            .then(data => {
                chatbox.innerHTML = '';  // 清空现有消息

                // 循环遍历每条消息并插入到 chatbox 中
                data.forEach(message => {
                    const p = document.createElement('p');
                    p.innerHTML = `<strong>${message.username}:</strong> ${message.message} <em>(${message.created_at})</em>`;
                    chatbox.appendChild(p);
                });

                // 自动滚动到底部
                chatbox.scrollTop = chatbox.scrollHeight;  // 滚动到底部
            })
            .catch(error => console.error('Error fetching messages:', error));
    }

    // 定时每2秒获取一次新消息
    setInterval(fetchMessages, 2000);

    // 初始加载消息
    fetchMessages();
});
