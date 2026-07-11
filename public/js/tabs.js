(function () {
    document.querySelectorAll('[data-tabs]').forEach(function (nav) {
        var group = nav.getAttribute('data-tabs');
        var btns = nav.querySelectorAll('[data-tab-btn]');
        var panels = document.querySelectorAll('[data-tab-group="' + group + '"]');

        btns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var target = btn.getAttribute('data-tab-btn');

                btns.forEach(function (b) {
                    b.classList.toggle('active', b === btn);
                });

                panels.forEach(function (panel) {
                    panel.classList.toggle('active', panel.getAttribute('data-tab-panel') === target);
                });

                if (history.replaceState) {
                    history.replaceState(null, '', '#' + target);
                }
            });
        });

        if (btns.length) {
            var hash = window.location.hash.replace('#', '');
            var matched = Array.prototype.find.call(btns, function (b) {
                return b.getAttribute('data-tab-btn') === hash;
            });

            if (matched) {
                matched.click();
            }
        }
    });
})();
