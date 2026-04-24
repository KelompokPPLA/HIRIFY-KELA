<style>
    .toast-stack {
        position: fixed;
        top: 20px;
        right: 20px;
        width: min(360px, calc(100vw - 32px));
        display: grid;
        gap: 10px;
        z-index: 9999;
    }

    .toast {
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, 0.1);
        background: #fff;
        box-shadow: 0 18px 44px rgba(15, 23, 42, 0.14);
        padding: 12px 14px;
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 10px;
        align-items: start;
        opacity: 0;
        transform: translateX(28px) scale(.98);
    }

    .toast.show { animation: toastIn .28s ease forwards; }
    .toast.hide { animation: toastOut .2s ease forwards; }

    .toast-badge {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .02em;
        color: #fff;
    }

    .toast-title {
        margin: 0;
        font-size: 13px;
        font-weight: 800;
        color: #0f172a;
    }

    .toast-message {
        margin: 2px 0 0;
        font-size: 13px;
        color: #5b6b82;
        line-height: 1.45;
    }

    .toast-close {
        border: 0;
        background: transparent;
        cursor: pointer;
        color: #7b8aa2;
        font-size: 16px;
        line-height: 1;
        padding: 2px;
    }

    .toast--success { border-left: 4px solid #0f7a41; }
    .toast--success .toast-badge { background: #0f7a41; }
    .toast--error { border-left: 4px solid #b42318; }
    .toast--error .toast-badge { background: #b42318; }
    .toast--info { border-left: 4px solid #1aa8c0; }
    .toast--info .toast-badge { background: #1aa8c0; }

    @keyframes toastIn {
        from { opacity: 0; transform: translateX(28px) scale(.98); }
        to { opacity: 1; transform: translateX(0) scale(1); }
    }

    @keyframes toastOut {
        from { opacity: 1; transform: translateX(0) scale(1); }
        to { opacity: 0; transform: translateX(18px) scale(.98); }
    }
</style>

<div id="toastStack" class="toast-stack" aria-live="polite" aria-atomic="true"></div>

<script>
    window.hirifyShowToast = (message, type = 'info', duration = 3200) => {
        const titleMap = {
            success: 'Berhasil',
            error: 'Terjadi Kendala',
            info: 'Informasi',
        };

        const badgeMap = {
            success: 'OK',
            error: 'ER',
            info: 'IN',
        };

        const toastStack = document.getElementById('toastStack');
        if (!toastStack) {
            return;
        }

        const toast = document.createElement('div');
        toast.className = `toast toast--${type}`;
        toast.innerHTML = `
            <div class="toast-badge">${badgeMap[type] || 'IN'}</div>
            <div>
                <p class="toast-title">${titleMap[type] || titleMap.info}</p>
                <p class="toast-message"></p>
            </div>
            <button type="button" class="toast-close" aria-label="Tutup">x</button>
        `;

        toast.querySelector('.toast-message').textContent = message;
        toastStack.appendChild(toast);
        requestAnimationFrame(() => toast.classList.add('show'));

        const dismiss = () => {
            toast.classList.remove('show');
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 220);
        };

        toast.querySelector('.toast-close').addEventListener('click', dismiss);
        setTimeout(dismiss, duration);
    };
</script>
