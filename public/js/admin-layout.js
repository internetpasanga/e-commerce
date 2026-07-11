(function () {
    var sidebar = document.getElementById('sidebar');
    var backdrop = document.getElementById('sidebar-backdrop');
    var toggle = document.getElementById('sidebar-toggle');

    if (sidebar && backdrop && toggle) {
        var openSidebar = function () {
            sidebar.classList.add('open');
            backdrop.classList.add('show');
            document.body.classList.add('no-scroll');
        };

        var closeSidebar = function () {
            sidebar.classList.remove('open');
            backdrop.classList.remove('show');
            document.body.classList.remove('no-scroll');
        };

        toggle.addEventListener('click', function () {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        backdrop.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        });
    }

    var flashStatus = document.getElementById('flash-status');
    var toastStack = document.getElementById('toast-stack');

    if (flashStatus && toastStack) {
        var toast = document.createElement('div');
        toast.className = 'toast toast-success';
        toast.textContent = flashStatus.dataset.message;
        toastStack.appendChild(toast);
        setTimeout(function () {
            toast.classList.add('is-leaving');
            setTimeout(function () {
                toast.remove();
            }, 200);
        }, 3000);
    }
})();
