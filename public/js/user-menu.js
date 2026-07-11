(function () {
    var menu = document.getElementById('user-menu');
    var trigger = document.getElementById('user-menu-trigger');
    var dropdown = document.getElementById('user-menu-dropdown');

    if (!menu || !trigger || !dropdown) {
        return;
    }

    function close() {
        dropdown.classList.remove('open');
    }

    function toggle() {
        dropdown.classList.toggle('open');
    }

    trigger.addEventListener('click', function (event) {
        event.stopPropagation();
        toggle();
    });

    document.addEventListener('click', function (event) {
        if (!menu.contains(event.target)) {
            close();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            close();
        }
    });
})();
