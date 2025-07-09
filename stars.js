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
        // Условие простое: если индекс звезды (0-4) меньше переданного значения,
        // то добавляем ей класс "active", иначе — убираем.
        if (index < value) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}


stars.forEach(star => {
    // Мышка НАВЕЛАСЬ на звезду
    star.addEventListener('mouseover', function() {
        paintStars(this.dataset.value);
    });

    // КЛИК по звезде
    star.addEventListener('click', function() {
        ratingValueInput.value = this.dataset.value;
        paintStars(ratingValueInput.value);
    });
});

// Мышка УШЛА с области звезд
starRatingContainer.addEventListener('mouseleave', function() {
    // ВОЗВРАЩАЕМ, как было
    paintStars(ratingValueInput.value);
});

paintStars(ratingValueInput.value);