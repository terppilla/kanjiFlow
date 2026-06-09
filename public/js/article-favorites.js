(function () {
    function getCsrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function updateFavoriteButton(button, isFavorite) {
        button.classList.toggle('is-active', isFavorite);
        var label = isFavorite ? 'Убрать из избранного' : 'Добавить в избранное';
        button.setAttribute('aria-label', label);
        button.setAttribute('title', label);
    }

    function showFavoritesEmptyState(grid) {
        if (!grid || grid.querySelector('[data-article-favorite-card]')) {
            return;
        }

        if (grid.querySelector('[data-articles-favorites-empty]')) {
            return;
        }

        var empty = document.createElement('div');
        empty.className = 'articles-empty-state';
        empty.setAttribute('data-articles-favorites-empty', '');
        empty.textContent = 'Вы ещё не добавили статьи в избранное.';
        grid.appendChild(empty);
    }

    document.addEventListener('submit', function (event) {
        var form = event.target.closest('[data-article-favorite-form]');
        if (!form) {
            return;
        }

        event.preventDefault();

        var button = form.querySelector('.favorite-icon-btn');
        if (!button || button.disabled) {
            return;
        }

        button.disabled = true;

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: new URLSearchParams(new FormData(form)),
            credentials: 'same-origin',
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Request failed');
                }

                return response.json();
            })
            .then(function (data) {
                updateFavoriteButton(button, data.is_favorite);

                if (!data.is_favorite) {
                    var card = form.closest('[data-article-favorite-card]');
                    if (card) {
                        var grid = card.parentElement;
                        card.remove();
                        showFavoritesEmptyState(grid);
                    }
                }
            })
            .catch(function () {
                window.alert('Не удалось обновить избранное. Попробуйте ещё раз.');
            })
            .finally(function () {
                button.disabled = false;
            });
    });
})();
