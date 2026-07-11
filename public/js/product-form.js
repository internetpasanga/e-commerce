(function () {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    var thumbnailInput = document.getElementById('thumbnail');
    var thumbnailPreview = document.getElementById('thumbnail-preview');
    var thumbnailDrop = document.getElementById('thumbnail-drop');
    var thumbnailDropText = document.getElementById('thumbnail-drop-text');

    var imagesInput = document.getElementById('images');
    var imagesDrop = document.getElementById('images-drop');
    var imagesDropText = document.getElementById('images-drop-text');
    var imagesDropDefaultText = imagesDropText.textContent;
    var newImagesPreview = document.getElementById('new-images-preview');
    var existingImagesContainer = document.getElementById('existing-images');

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

    thumbnailInput.addEventListener('change', function () {
        var file = thumbnailInput.files[0];
        if (file) {
            thumbnailPreview.src = URL.createObjectURL(file);
            thumbnailPreview.style.display = 'block';
            thumbnailDrop.classList.add('has-file');
            thumbnailDropText.textContent = file.name;
        }
    });

    imagesInput.addEventListener('change', function () {
        var files = Array.prototype.slice.call(imagesInput.files);
        newImagesPreview.innerHTML = '';

        if (files.length === 0) {
            imagesDrop.classList.remove('has-file');
            imagesDropText.textContent = imagesDropDefaultText;
            return;
        }

        imagesDrop.classList.add('has-file');
        imagesDropText.textContent = files.length + ' image(s) selected';

        files.forEach(function (file) {
            var item = document.createElement('div');
            item.className = 'gallery-item';
            item.innerHTML = '<img src="' + URL.createObjectURL(file) + '" alt="">';
            newImagesPreview.appendChild(item);
        });
    });

    if (existingImagesContainer) {
        existingImagesContainer.addEventListener('click', function (event) {
            var removeBtn = event.target.closest('.gallery-item-remove');
            if (!removeBtn) {
                return;
            }

            fetch(removeBtn.dataset.url, {
                method: 'DELETE',
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
                    removeBtn.closest('.gallery-item').remove();
                    showToast(body.message, 'success');
                });
        });
    }
})();
