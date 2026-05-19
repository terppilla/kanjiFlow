(function () {
    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    function fieldValue(id) {
        var el = document.getElementById(id);
        return el ? el.value.trim() : '';
    }

    function speechTextForButton(btn) {
        var input = document.getElementById(btn.dataset.input);
        if (!input) return '';

        var primaryId = input.dataset.textSource;
        var text = primaryId ? fieldValue(primaryId) : '';
        if (!text && input.dataset.textFallback) {
            text = fieldValue(input.dataset.textFallback);
        }
        return text;
    }

    function glyphForButton(btn) {
        var input = document.getElementById(btn.dataset.input);
        if (!input || !input.dataset.glyphSource) return '';
        return fieldValue(input.dataset.glyphSource);
    }

    function setStatus(inputId, message, isError) {
        var status = document.getElementById(inputId + '_status');
        if (!status) return;
        status.textContent = message || '';
        status.className = 'admin-audio-status' + (isError ? ' admin-audio-status--error' : ' admin-audio-status--ok');
    }

    function updatePreview(inputId, path) {
        var wrap = document.getElementById(inputId + '_preview_wrap');
        var audio = document.getElementById(inputId + '_preview');
        var input = document.getElementById(inputId);
        if (!audio || !input) return;

        input.value = path || '';
        if (path) {
            audio.src = path;
            if (wrap) wrap.hidden = false;
            audio.load();
        } else if (wrap) {
            wrap.hidden = true;
            audio.removeAttribute('src');
        }
    }

    async function postJson(url, body) {
        var res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(body),
        });
        var data = await res.json().catch(function () { return {}; });
        if (!res.ok) {
            throw new Error(data.message || 'Ошибка генерации аудио');
        }
        return data;
    }

    document.addEventListener('click', async function (e) {
        var btn = e.target.closest('.btn-admin-audio-generate');
        if (!btn) return;

        e.preventDefault();
        var inputId = btn.dataset.input;
        var kind = btn.dataset.kind || 'character';
        var text = speechTextForButton(btn);
        var glyph = glyphForButton(btn);

        btn.disabled = true;
        setStatus(inputId, 'Генерация…', false);

        try {
            var data;
            if (btn.dataset.characterId) {
                var url = kind === 'example' ? btn.dataset.urlExample : btn.dataset.urlCharacter;
                data = await postJson(url, {});
            } else {
                if (!text) {
                    throw new Error('Заполните поля для озвучки (пиньинь или пример).');
                }
                if (!glyph) {
                    throw new Error('Сначала укажите иероглиф.');
                }
                data = await postJson(btn.dataset.urlPreview, {
                    text: text,
                    glyph: glyph,
                    kind: kind,
                });
            }

            if (data.path) {
                updatePreview(inputId, data.path);
            }
            setStatus(inputId, data.message || 'Готово', false);
        } catch (err) {
            setStatus(inputId, err.message || 'Ошибка', true);
        } finally {
            btn.disabled = false;
        }
    });
})();
