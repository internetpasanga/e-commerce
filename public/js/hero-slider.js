(function () {
    var slider = document.getElementById('hero-slider');
    if (!slider) {
        return;
    }

    var slides = Array.prototype.slice.call(slider.querySelectorAll('.hero-slide'));
    var dots = Array.prototype.slice.call(slider.querySelectorAll('.hero-slider-dot'));
    var prevBtn = slider.querySelector('[data-action="prev-slide"]');
    var nextBtn = slider.querySelector('[data-action="next-slide"]');
    var current = 0;
    var timer = null;

    function showSlide(index) {
        current = (index + slides.length) % slides.length;

        slides.forEach(function (slide, i) {
            slide.classList.toggle('active', i === current);
        });

        dots.forEach(function (dot, i) {
            dot.classList.toggle('active', i === current);
        });
    }

    function startAutoplay() {
        clearInterval(timer);
        timer = setInterval(function () {
            showSlide(current + 1);
        }, 5000);
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            showSlide(current - 1);
            startAutoplay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            showSlide(current + 1);
            startAutoplay();
        });
    }

    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () {
            showSlide(i);
            startAutoplay();
        });
    });

    startAutoplay();
})();
