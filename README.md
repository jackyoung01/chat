# 聊天应用程序

这是一个使用PHP构建的简单聊天应用程序。它允许用户注册、登录并在聊天室中交流，以及与ai进行互动。该应用程序旨在演示基本的Web开发概念，包括用户身份验证和实时消息传递。
- 演示网站[点击这里](http://120.55.57.217:11111/)
- 欢迎各位一起参与不断完善！共创联系QQ908756682
- 当前计划：新增热门聊天室列表,用户通过分享链接进入聊天室
- 已完成计划：允许用户发送自主图片，接入ai系统，在线用户数及列表

## 功能
### 2024.10.13 版本1.0
- 用户注册和登录
- 多个聊天室
- 实时获取消息
- 用户管理
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241013222619125-543346096.png)
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241013222624022-1599108943.png)
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241013222625791-143968807.png)
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241013222628864-1906667558.png)
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241013222631752-445096669.png)
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241013222633596-381259984.png)
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241013222635662-2111792512.png)

### 2024.10.14 版本1.1
- 支持发送emoji表情包
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241015130136243-122483043.png)

### 2024.10.27 版本1.2
- 接入ai陪聊系统，优化emoji表情包选择框
- 在与ai进行互动时，需手动@ai 并在空格后输入你要交流的消息
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241028002619888-1361445853.png)

### 2024.10.28 版本1.3
- 允许用户自由上传图片
![](https://img2024.cnblogs.com/blog/3512200/202410/3512200-20241028215512578-1048710273.png)

### 2024.10.29 版本1.4
- 可以查看聊天室在线用户数及列表
![b89f09b115bb93e74fcf7a6328072af9](https://github.com/user-attachments/assets/e03819be-73e3-49f5-9889-e8a08cabc961)

### 2024.10.31 版本1.5
- 美化网站前台首页，把登录和注册集成在一起
![149f12999cf46d06d6d35986e49d25dd](https://github.com/user-attachments/assets/e4f68bac-a347-4201-a47a-7f1dff01d4a4)

### 2024.11.7 版本1.6
- 美化用户中心面板
- 美化聊天室界面布局
![32b29a9fe5e32d26bebc6774ac6120b4](https://github.com/user-attachments/assets/389a3456-80ff-4652-a30f-debdfe43ed71)
![bbf0feed8f8bd1c87711f1121f115b1d](https://github.com/user-attachments/assets/531166ff-59e4-47ab-906a-44acf0e2fb5a)
![0b97c91eb71ee7c35281a61d710055dd](https://github.com/user-attachments/assets/e12f4cb0-913f-4227-b1a2-8d7c8a4517bf)
![94834d1799fc977ecd3426b05087769b](https://github.com/user-attachments/assets/473259d1-3156-44f8-99f6-c41e96a49151)

## 技术栈

- PHP
- MySQL
- HTML/CSS
- JavaScript

## 安装步骤

1. 克隆该仓库：
   ```bash
   git clone https://github.com/jackyoung01/open-chatroom.git

2.配置数据库文件
  db.php
  
3.导入数据库文件
  open-chatroom.sql
  
4.配置相关的api密钥
  chatroom.js

## 特别鸣谢
- 在此感谢chatgpt-4o的提供代码修正与贡献
- 感谢智谱清言ai大模型的免费开源，为本作者在ai接口调用方面的学习降低成本
