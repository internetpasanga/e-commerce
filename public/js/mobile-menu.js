(function () {
    var toggle = document.getElementById('mobile-menu-toggle');
    var nav = document.getElementById('site-nav');

    if (!toggle || !nav) {
        return;
    }

    function close() {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
    }

    function open() {
        nav.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
    }

    function isOpen() {
        return nav.classList.contains('is-open');
    }

    toggle.addEventListener('click', function (event) {
        event.stopPropagation();
        isOpen() ? close() : open();
    });

    nav.addEventListener('click', function (event) {
        if (event.target.closest('a')) {
            close();
        }
    });

    document.addEventListener('click', function (event) {
        if (isOpen() && !nav.contains(event.target) && !toggle.contains(event.target)) {
            close();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            close();
        }
    });
})();
