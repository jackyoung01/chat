function createLeaf() {
    const leaf = document.createElement('div');
    leaf.classList.add('leaf');
    leaf.style.left = `${Math.random() * 100}vw`; // 随机水平位置
    leaf.style.animationDuration = `${Math.random() * 5 + 5}s`; // 随机动画时间
    leaf.style.animationDelay = `${Math.random() * 10}s`; // 随机延迟开始
    document.querySelector('.falling-leaves').appendChild(leaf);

    // 动画结束后移除叶子
    leaf.addEventListener('animationend', () => {
        leaf.remove();
    });
}

// 每隔一定时间生成一个新的叶子
setInterval(createLeaf, 500);
