(function () {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var tableContainer = document.getElementById('products-table');
    var deleteModal = document.getElementById('delete-modal');
    var confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    var deleteProductName = document.getElementById('delete-product-name');

    var filterSearch = document.getElementById('filter-search');
    var filterCategory = document.getElementById('filter-category');
    var filterStatus = document.getElementById('filter-status');
    var filterReset = document.getElementById('filter-reset');

    var deletingId = null;
    var searchDebounce = null;

    function productsIndexUrl() {
        return window.location.pathname;
    }

    function buildFilterUrl() {
        var params = new URLSearchParams();

        if (filterSearch.value.trim()) {
            params.set('search', filterSearch.value.trim());
        }
        if (filterCategory.value) {
            params.set('category_id', filterCategory.value);
        }
        if (filterStatus.value !== '') {
            params.set('status', filterStatus.value);
        }

        var query = params.toString();

        return productsIndexUrl() + (query ? '?' + query : '');
    }

    var currentTableUrl = productsIndexUrl();

    function showToast(message, type) {
        var stack = document.getElementById('toast-stack');
        var toast = document.createElement('div');
        toast.className = 'toast toast-' + (type || 'success');
        toast.textContent = message;
        stack.appendChild(toast);
        setTimeout(function () {
            toast.classList.add('is-leaving');
            setTimeout(function () {
                toast.remove();
            }, 200);
        }, 3000);
    }

    function openModal(modal) {
        modal.classList.add('open');
    }

    function closeModal(modal) {
        modal.classList.remove('open');
    }

    function loadTable(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
        })
            .then(function (res) {
                return res.text();
            })
            .then(function (html) {
                tableContainer.innerHTML = html;
                currentTableUrl = url;
            });
    }

    filterSearch.addEventListener('input', function () {
        clearTimeout(searchDebounce);
        searchDebounce = setTimeout(function () {
            loadTable(buildFilterUrl());
        }, 400);
    });

    filterCategory.addEventListener('change', function () {
        loadTable(buildFilterUrl());
    });

    filterStatus.addEventListener('change', function () {
        loadTable(buildFilterUrl());
    });

    filterReset.addEventListener('click', function () {
        filterSearch.value = '';
        filterCategory.value = '';
        filterStatus.value = '';
        loadTable(productsIndexUrl());
    });

    document.querySelectorAll('[data-action="close-delete-modal"]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            closeModal(deleteModal);
        });
    });

    tableContainer.addEventListener('click', function (event) {
        var deleteBtn = event.target.closest('[data-action="delete-product"]');
        var pageLink = event.target.closest('.pagination a, nav[role="navigation"] a');

        if (deleteBtn) {
            deletingId = deleteBtn.dataset.id;
            deleteProductName.textContent = deleteBtn.dataset.name;
            openModal(deleteModal);
            return;
        }

        if (pageLink) {
            event.preventDefault();
            loadTable(pageLink.href);
        }
    });

    confirmDeleteBtn.addEventListener('click', function () {
        confirmDeleteBtn.disabled = true;

        fetch(productsIndexUrl() + '/' + deletingId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
            .then(function (res) {
                return res.json().then(function (body) {
                    return { ok: res.ok, body: body };
                });
            })
            .then(function (result) {
                closeModal(deleteModal);
                confirmDeleteBtn.disabled = false;

                if (result.ok) {
                    showToast(result.body.message, 'success');
                    loadTable(currentTableUrl);
                } else {
                    showToast(result.body.message || 'Something went wrong.', 'error');
                }
            });
    });
})();
