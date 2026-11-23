document.addEventListener('DOMContentLoaded', function () {
    const track = document.querySelector('.slider-track');
    if (!track) return;

    const slides = track.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.slider-btn.prev');
    const nextBtn = document.querySelector('.slider-btn.next');
    let current = 0;
    let timer = null;

    function goTo(index) {
        current = (index + slides.length) % slides.length;
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAuto() {
        stopAuto();
        timer = setInterval(next, 4000);
    }

    function stopAuto() {
        if (timer) clearInterval(timer);
    }

    if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAuto(); });
    if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAuto(); });

    startAuto();
});