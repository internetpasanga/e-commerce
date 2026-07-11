(function () {
    function createSingleSelect(select, wrapper) {
        var control = document.createElement('button');
        control.type = 'button';
        control.className = 'ss-control';
        control.innerHTML = '<span class="ss-control-label"></span>' +
            '<svg class="ss-control-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>';
        wrapper.appendChild(control);

        var controlLabel = control.querySelector('.ss-control-label');

        var dropdown = document.createElement('div');
        dropdown.className = 'ss-dropdown';
        dropdown.innerHTML = '<input type="text" class="ss-search" placeholder="Search...">' +
            '<div class="ss-options"></div>';
        wrapper.appendChild(dropdown);

        var searchInput = dropdown.querySelector('.ss-search');
        var optionsList = dropdown.querySelector('.ss-options');

        function getOptions() {
            return Array.prototype.slice.call(select.options);
        }

        function updateControlLabel() {
            var selected = select.options[select.selectedIndex];
            controlLabel.textContent = selected ? selected.textContent : '';
        }

        function renderOptions(filter) {
            optionsList.innerHTML = '';
            var term = (filter || '').toLowerCase();
            var hasResults = false;

            getOptions().forEach(function (opt) {
                if (opt.disabled) {
                    return;
                }
                if (term && opt.textContent.toLowerCase().indexOf(term) === -1) {
                    return;
                }
                hasResults = true;

                var item = document.createElement('div');
                item.className = 'ss-option' + (opt.value === select.value ? ' selected' : '');
                item.textContent = opt.textContent;

                item.addEventListener('click', function () {
                    select.value = opt.value;
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                    updateControlLabel();
                    closeDropdown();
                });

                optionsList.appendChild(item);
            });

            if (!hasResults) {
                var empty = document.createElement('div');
                empty.className = 'ss-no-results';
                empty.textContent = 'No results found';
                optionsList.appendChild(empty);
            }
        }

        function openDropdown() {
            wrapper.classList.add('open');
            searchInput.value = '';
            renderOptions('');
            searchInput.focus();
        }

        function closeDropdown() {
            wrapper.classList.remove('open');
        }

        control.addEventListener('click', function () {
            if (wrapper.classList.contains('open')) {
                closeDropdown();
            } else {
                openDropdown();
            }
        });

        searchInput.addEventListener('input', function () {
            renderOptions(searchInput.value);
        });

        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeDropdown();
                control.focus();
            }
        });

        document.addEventListener('click', function (event) {
            if (!wrapper.contains(event.target)) {
                closeDropdown();
            }
        });

        updateControlLabel();

        select.refreshSearchableSelect = updateControlLabel;
    }

    function createMultiSelect(select, wrapper) {
        wrapper.classList.add('ss-multi');

        var control = document.createElement('div');
        control.className = 'ss-control ss-multi-control';
        wrapper.appendChild(control);

        var chipsContainer = document.createElement('div');
        chipsContainer.className = 'ss-chips';
        control.appendChild(chipsContainer);

        var searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.className = 'ss-multi-input';
        searchInput.placeholder = 'Type to search...';
        control.appendChild(searchInput);

        var dropdown = document.createElement('div');
        dropdown.className = 'ss-dropdown';
        dropdown.innerHTML = '<div class="ss-options"></div>';
        wrapper.appendChild(dropdown);

        var optionsList = dropdown.querySelector('.ss-options');

        function getOptions() {
            return Array.prototype.slice.call(select.options);
        }

        function renderChips() {
            chipsContainer.innerHTML = '';

            getOptions().filter(function (opt) {
                return opt.selected;
            }).forEach(function (opt) {
                var chip = document.createElement('span');
                chip.className = 'ss-chip';
                chip.textContent = opt.textContent;

                var remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'ss-chip-remove';
                remove.innerHTML = '&times;';
                remove.addEventListener('click', function (event) {
                    event.stopPropagation();
                    opt.selected = false;
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                    renderChips();
                    renderOptions(searchInput.value);
                });

                chip.appendChild(remove);
                chipsContainer.appendChild(chip);
            });
        }

        function renderOptions(filter) {
            optionsList.innerHTML = '';
            var term = (filter || '').toLowerCase();
            var hasResults = false;

            getOptions().forEach(function (opt) {
                if (opt.selected || opt.disabled) {
                    return;
                }
                if (term && opt.textContent.toLowerCase().indexOf(term) === -1) {
                    return;
                }
                hasResults = true;

                var item = document.createElement('div');
                item.className = 'ss-option';
                item.textContent = opt.textContent;

                item.addEventListener('click', function () {
                    opt.selected = true;
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                    renderChips();
                    searchInput.value = '';
                    renderOptions('');
                    searchInput.focus();
                });

                optionsList.appendChild(item);
            });

            if (!hasResults) {
                var empty = document.createElement('div');
                empty.className = 'ss-no-results';
                empty.textContent = 'No results found';
                optionsList.appendChild(empty);
            }
        }

        function openDropdown() {
            wrapper.classList.add('open');
            renderOptions(searchInput.value);
        }

        function closeDropdown() {
            wrapper.classList.remove('open');
        }

        control.addEventListener('click', function () {
            searchInput.focus();
            openDropdown();
        });

        searchInput.addEventListener('focus', openDropdown);

        searchInput.addEventListener('input', function () {
            openDropdown();
        });

        searchInput.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeDropdown();
            }
        });

        document.addEventListener('click', function (event) {
            if (!wrapper.contains(event.target)) {
                closeDropdown();
            }
        });

        renderChips();

        select.refreshSearchableSelect = function () {
            renderChips();
            renderOptions(searchInput.value);
        };
    }

    function createSearchableSelect(select) {
        if (select.dataset.ssInitialized) {
            return;
        }
        select.dataset.ssInitialized = 'true';

        var wrapper = document.createElement('div');
        wrapper.className = 'ss-wrapper';
        select.parentNode.insertBefore(wrapper, select);
        wrapper.appendChild(select);
        select.classList.add('ss-native');

        if (select.multiple) {
            createMultiSelect(select, wrapper);
        } else {
            createSingleSelect(select, wrapper);
        }
    }

    function init() {
        document.querySelectorAll('[data-searchable-select]').forEach(createSearchableSelect);
    }

    window.SearchableSelect = { init: init };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
