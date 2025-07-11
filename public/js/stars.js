const stars = document.querySelectorAll('.star');
const ratingValueInput = document.getElementById('rating-value');
const starRatingContainer = document.querySelector('.star-rating');

/**
 * Главная функция: "красит" звезды.
 * Она принимает число и закрашивает все звезды до этого числа.
 * @param {number} value - до какой звезды красить (1-5).
 */
function paintStars(value) {
    stars.forEach((star, index) => {
        if (index < value) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}


stars.forEach(star => {
    star.addEventListener('mouseover', function () {
        paintStars(this.dataset.value);
    });

    // Записываем значение оценки
    star.addEventListener('click', function () {
        ratingValueInput.value = this.dataset.value;
        paintStars(ratingValueInput.value);
    });
});

// ↓ Закрасить столько звезд, сколько хранится в ratingValue
starRatingContainer.addEventListener('mouseleave', function () {
    paintStars(ratingValueInput.value);
});

paintStars(ratingValueInput.value);