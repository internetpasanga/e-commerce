(function () {
    var csrfMeta = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrfMeta ? csrfMeta.content : null;
    var wishlistContainer = document.getElementById('wishlist-items');

    function showToast(message, type) {
        var stack = document.getElementById('toast-stack');
        if (!stack) {
            return;
        }
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

    function updateWishlistCount(count) {
        var badge = document.getElementById('wishlist-count');
        if (!badge) {
            return;
        }
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
        badge.classList.remove('is-bumping');
        void badge.offsetWidth;
        badge.classList.add('is-bumping');
    }

    function reloadWishlist() {
        if (!wishlistContainer) {
            return;
        }
        fetch(window.location.pathname, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
        })
            .then(function (res) {
                return res.text();
            })
            .then(function (html) {
                wishlistContainer.innerHTML = html;
            });
    }

    document.addEventListener('click', function (event) {
        var btn = event.target.closest('[data-action="toggle-wishlist"]');
        if (!btn) {
            return;
        }

        var productId = btn.dataset.productId;
        if (!productId) {
            return;
        }

        btn.disabled = true;

        fetch('/wishlist/' + productId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
            .then(function (res) {
                return res.json();
            })
            .then(function (body) {
                updateWishlistCount(body.count);
                showToast(body.message, 'success');

                btn.classList.toggle('active', body.added);

                var label = btn.querySelector('.wishlist-btn-label');
                if (label) {
                    label.textContent = body.added ? 'Remove from Wishlist' : 'Add to Wishlist';
                }

                if (wishlistContainer) {
                    reloadWishlist();
                }
            })
            .finally(function () {
                btn.disabled = false;
            });
    });
})();
