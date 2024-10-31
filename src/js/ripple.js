document.addEventListener("click", function(e) {
    const rippleContainer = document.querySelector(".ripple-container");

    // 创建水波元素
    const ripple = document.createElement("div");
    ripple.classList.add("ripple");

    // 设置水波的位置，使其出现在点击的位置
    ripple.style.left = `${e.clientX - 10}px`; // 调整位置，使水波居中
    ripple.style.top = `${e.clientY - 10}px`;

    // 将水波元素添加到容器中
    rippleContainer.appendChild(ripple);

    // 动画结束后移除水波元素
    ripple.addEventListener("animationend", () => {
        ripple.remove();
    });
});
