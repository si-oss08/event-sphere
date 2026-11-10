// Mobile navigation and small progressive enhancements.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-mobile-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const target = document.querySelector(button.dataset.mobileToggle);

            if (target) {
                target.classList.toggle('hidden');
            }
        });
    });

    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.querySelector(button.dataset.passwordToggle);

            if (input) {
                input.type = input.type === 'password' ? 'text' : 'password';
                button.textContent = input.type === 'password' ? 'Lihat' : 'Sembunyikan';
            }
        });
    });

    document.querySelectorAll('details[data-user-menu]').forEach((details) => {
        document.addEventListener('click', (event) => {
            if (details.open && !details.contains(event.target)) {
                details.open = false;
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                details.open = false;
            }
        });
    });
});
