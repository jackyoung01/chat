function registerUser() {
    const form = document.getElementById('registerFormInner');
    const formData = new FormData(form);

    fetch('', { // 发送到同一页面
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const messageElement = document.getElementById('registerMessage');
        if (data.status === 'success') {
            messageElement.style.color = 'green';
            messageElement.textContent = data.message;
            form.reset(); // 清空表单
        } else {
            messageElement.style.color = 'red';
            messageElement.textContent = data.message;
        }
    })
    .catch(error => {
        console.error('注册请求失败:', error);
        document.getElementById('registerMessage').textContent = '注册失败，请稍后重试。';
    });
}
