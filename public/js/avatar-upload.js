(function () {
    var avatarInput = document.getElementById('avatar');
    var avatarForm = document.getElementById('avatar-form');

    if (avatarInput && avatarForm) {
        avatarInput.addEventListener('change', function () {
            if (avatarInput.files[0]) {
                avatarForm.submit();
            }
        });
    }
})();
