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
        var trigger = event.target.closest('[data-action="toggle-wishlist"]');
        if (!trigger) {
            return;
        }

        var productId = trigger.dataset.productId;
        if (!productId) {
            return;
        }

        // A product can have more than one toggle button on the same page
        // (e.g. the heart overlay on the card image and the labeled button
        // in the card actions) - keep them all in sync.
        var buttons = document.querySelectorAll('[data-action="toggle-wishlist"][data-product-id="' + productId + '"]');
        buttons.forEach(function (b) {
            b.disabled = true;
        });

        fetch('/wishlist/' + productId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
            .then(function (res) {
                if (!res.ok) {
                    throw new Error('Request failed');
                }
                return res.json();
            })
            .then(function (body) {
                updateWishlistCount(body.count);
                showToast(body.message, 'success');

                buttons.forEach(function (b) {
                    b.classList.toggle('active', body.added);
                    b.setAttribute('aria-pressed', body.added ? 'true' : 'false');

                    var label = b.querySelector('.wishlist-btn-label');
                    if (label) {
                        label.textContent = body.added
                            ? (b.classList.contains('wishlist-btn-card') ? 'In Wishlist' : 'Remove from Wishlist')
                            : 'Add to Wishlist';
                    } else {
                        b.setAttribute('aria-label', body.added ? 'Remove from wishlist' : 'Add to wishlist');
                    }

                    b.classList.remove('is-animating');
                    void b.offsetWidth;
                    b.classList.add('is-animating');
                });

                if (wishlistContainer) {
                    reloadWishlist();
                }
            })
            .catch(function () {
                showToast('Something went wrong. Please try again.', 'error');
            })
            .finally(function () {
                buttons.forEach(function (b) {
                    b.disabled = false;
                });
            });
    });
})();
