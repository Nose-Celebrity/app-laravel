function toggleUserMenu() {
    document.getElementById('userMenu').classList.toggle('show');
}

// スクロールで投稿ボタン非表示
let lastScrollY = window.scrollY;
const btns = document.getElementById('floatingButtons');

window.addEventListener('scroll', () => {
    if (window.scrollY > lastScrollY) {
        // 下にスクロール → 非表示
        btns.classList.add('hidden');
    } else {
        // 上にスクロール → 表示
        btns.classList.remove('hidden');
    }
    lastScrollY = window.scrollY;
});
