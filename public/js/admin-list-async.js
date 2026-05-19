(function () {
    var page = document.querySelector('[data-admin-list-page]');
    if (!page) return;

    var asyncRoot = document.getElementById('admin-list-async');
    var filterForm = page.querySelector('form.admin-list-filters');
    var totalBadge = page.querySelector('[data-admin-list-header-total]');

    function loadUrl(url, pushState) {
        if (!asyncRoot) return;

        asyncRoot.classList.add('is-loading');

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html',
            },
            credentials: 'same-origin',
        })
            .then(function (r) {
                if (!r.ok) throw new Error('Network error');
                return r.text();
            })
            .then(function (html) {
                asyncRoot.innerHTML = html;
                if (pushState && window.history && window.history.pushState) {
                    window.history.pushState({ adminList: true }, '', url);
                }
                var total = asyncRoot.querySelector('[data-admin-list-total]');
                if (totalBadge && total) {
                    totalBadge.textContent = total.textContent;
                }
                var tableWrap = asyncRoot.querySelector('.characters-index-table-wrap');
                if (tableWrap) {
                    tableWrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            })
            .catch(function () {
                window.location.href = url;
            })
            .finally(function () {
                asyncRoot.classList.remove('is-loading');
            });
    }

    page.addEventListener('click', function (e) {
        var link = e.target.closest('#admin-list-async a.pagination-btn');
        if (!link || link.classList.contains('disabled') || link.classList.contains('active')) return;
        var url = link.getAttribute('href');
        if (!url || url === '#') return;
        e.preventDefault();
        loadUrl(url, true);
    });

    if (filterForm) {
        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            var params = new URLSearchParams(new FormData(filterForm));
            var base = filterForm.getAttribute('action') || window.location.pathname;
            var url = base + (params.toString() ? '?' + params.toString() : '');
            loadUrl(url, true);
        });
    }

    var listPath = page.getAttribute('data-admin-list-page');

    window.addEventListener('popstate', function () {
        if (listPath && window.location.pathname === listPath) {
            loadUrl(window.location.href, false);
        }
    });
})();
