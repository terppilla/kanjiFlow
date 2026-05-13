
<?php
    $characterIdsValue = old('character_ids');
    if ($characterIdsValue === null) {
        $characterIdsValue = json_encode(array_column($initialCharacters ?? [], 'id'));
    }
?>

<div
    class="admin-builtin-glyph-picker collections-shell page-collections-show"
    id="adminBuiltinGlyphPicker"
    data-search-url="<?php echo e(route('admin.builtin-collections.characters.search')); ?>"
    data-import-url="<?php echo e(route('admin.builtin-collections.glyphs-json-import')); ?>"
    data-resolve-url="<?php echo e(route('admin.builtin-collections.characters.resolve')); ?>"
>
    <section class="collections-panel collections-panel--accent">
        <h2 class="collections-panel-title">Добавить иероглиф</h2>
        <p class="collections-subtle">Поиск по значению, пиньиню или символу (как у пользователя в коллекции)</p>
        <div class="search-row">
            <input type="search" id="adminBuiltinCharSearch" autocomplete="off" placeholder="Начните вводить…">
        </div>
        
        <div class="suggest" id="adminBuiltinSearchSuggest" style="display:none"></div>
    </section>

    <section class="collections-panel">
        <h2 class="collections-panel-title">Состав подборки</h2>
        <p class="collections-subtle admin-builtin-glyph-picker-order-hint">Порядок строк сохраняется. Можно менять кнопками вверх / вниз.</p>
        <div id="adminBuiltinSelectedEmpty" class="collections-empty-inline">Пока пусто — найдите иероглифы выше или импортируйте JSON.</div>
        <ul id="adminBuiltinSelectedList" class="admin-builtin-selected-list" hidden></ul>
    </section>

    <section class="collections-panel admin-builtin-json-import-panel">
        <h2 class="collections-panel-title">Импорт списка (JSON)</h2>
        <p class="collections-subtle">
            Файл — массив строк <code>["我","你好"]</code> или массив объектов как в <code>characters.json</code> (берётся поле <code>character</code>).
            Несуществующие в базе записи перечисляются в сообщении; остальные добавляются в конец списка без дубликатов.
        </p>
        <div class="admin-builtin-json-import-row">
            <input type="file" id="adminBuiltinGlyphImportFile" accept=".json,.txt,application/json" class="characters-json-import-file">
            <button type="button" class="btn btn-outline btn-sm admin-builtin-json-import-btn" id="adminBuiltinGlyphImportBtn">Импортировать в список</button>
        </div>
        <div id="adminBuiltinGlyphImportFeedback" class="admin-builtin-import-feedback" hidden></div>
    </section>

    <input type="hidden" name="character_ids" id="builtinGlyphCharacterIds" value="<?php echo e($characterIdsValue); ?>">
</div>

<script>
(function() {
    const root = document.getElementById('adminBuiltinGlyphPicker');
    if (!root) return;

    const searchUrl = root.dataset.searchUrl;
    const importUrl = root.dataset.importUrl;
    const resolveUrl = root.dataset.resolveUrl;
    const token = document.querySelector('meta[name="csrf-token"]');

    const initialRows = <?php echo json_encode($initialCharacters ?? [], 15, 512) ?>;
    const hidden = document.getElementById('builtinGlyphCharacterIds');
    const input = document.getElementById('adminBuiltinCharSearch');
    const box = document.getElementById('adminBuiltinSearchSuggest');
    const listEl = document.getElementById('adminBuiltinSelectedList');
    const emptyEl = document.getElementById('adminBuiltinSelectedEmpty');
    const importBtn = document.getElementById('adminBuiltinGlyphImportBtn');
    const importFile = document.getElementById('adminBuiltinGlyphImportFile');
    const importFb = document.getElementById('adminBuiltinGlyphImportFeedback');

    if (!input || !box || !hidden) {
        return;
    }

    /** @type {{ id: number, character: string, pinyin: string, meaning: string, hsk_level: number }[]} */
    let rows = [];

    function escapeHtml(s) {
        const d = document.createElement('div');
        d.textContent = s;
        return d.innerHTML;
    }

    function syncHidden() {
        hidden.value = JSON.stringify(rows.map(function(r) { return r.id; }));
    }

    function render() {
        if (!rows.length) {
            emptyEl.hidden = false;
            listEl.hidden = true;
            listEl.innerHTML = '';
            syncHidden();
            return;
        }
        emptyEl.hidden = true;
        listEl.hidden = false;
        listEl.innerHTML = '';
        rows.forEach(function(row, idx) {
            const li = document.createElement('li');
            li.className = 'admin-builtin-selected-row';
            li.innerHTML =
                '<span class="admin-builtin-selected-glyph">' + escapeHtml(row.character) + '</span>' +
                '<span class="admin-builtin-selected-meta">' + escapeHtml(row.pinyin) + ' · HSK' + row.hsk_level + '</span>' +
                '<span class="admin-builtin-selected-meaning">' + escapeHtml((row.meaning || '').slice(0, 56)) + '</span>' +
                '<span class="admin-builtin-selected-actions">' +
                    '<button type="button" class="btn btn-xs-inline admin-move-up" title="Выше" aria-label="Выше"' + (idx === 0 ? ' disabled' : '') + '>↑</button>' +
                    '<button type="button" class="btn btn-xs-inline admin-move-down" title="Ниже" aria-label="Ниже"' + (idx === rows.length - 1 ? ' disabled' : '') + '>↓</button>' +
                    '<button type="button" class="btn btn-icon-remove admin-remove-glyph" title="Убрать" aria-label="Убрать">✕</button>' +
                '</span>';
            li.querySelector('.admin-move-up').addEventListener('click', function() {
                if (idx <= 0) return;
                const t = rows[idx - 1];
                rows[idx - 1] = rows[idx];
                rows[idx] = t;
                render();
            });
            li.querySelector('.admin-move-down').addEventListener('click', function() {
                if (idx >= rows.length - 1) return;
                const t = rows[idx + 1];
                rows[idx + 1] = rows[idx];
                rows[idx] = t;
                render();
            });
            li.querySelector('.admin-remove-glyph').addEventListener('click', function() {
                rows.splice(idx, 1);
                render();
            });
            listEl.appendChild(li);
        });
        syncHidden();
    }

    function addCharacter(ch) {
        if (rows.some(function(r) { return r.id === ch.id; })) return;
        rows.push({
            id: ch.id,
            character: ch.character,
            pinyin: ch.pinyin || '',
            meaning: ch.meaning || '',
            hsk_level: ch.hsk_level
        });
        render();
    }

    let searchTimer;
    input.addEventListener('input', function() {
        clearTimeout(searchTimer);
        const q = input.value.trim();
        if (q.length < 1) {
            box.style.display = 'none';
            box.innerHTML = '';
            return;
        }
        searchTimer = setTimeout(async function() {
            try {
                const r = await fetch(searchUrl + '?q=' + encodeURIComponent(q), {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin'
                });
                if (!r.ok) {
                    box.innerHTML = '<div class="collections-empty-search">Ошибка поиска (' + r.status + ')</div>';
                    box.style.display = 'block';
                    return;
                }
                const data = await r.json();
                box.innerHTML = '';
                if (!data.characters || !data.characters.length) {
                    box.innerHTML = '<div class="collections-empty-search">Ничего не найдено</div>';
                    box.style.display = 'block';
                    return;
                }
                data.characters.forEach(function(ch) {
                    const b = document.createElement('button');
                    b.type = 'button';
                    b.innerHTML = '<span class="glyph">' + escapeHtml(ch.character) + '</span> ' +
                        escapeHtml(ch.meaning || '') + ' <small class="collections-hsk-badge">HSK' + ch.hsk_level + '</small>';
                    b.addEventListener('click', function() {
                        addCharacter(ch);
                        input.value = '';
                        box.style.display = 'none';
                        box.innerHTML = '';
                    });
                    box.appendChild(b);
                });
                box.style.display = 'block';
            } catch (e) {
                console.error(e);
            }
        }, 220);
    });

    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !box.contains(e.target)) {
            box.style.display = 'none';
        }
    });

    importBtn.addEventListener('click', async function() {
        importFb.hidden = true;
        const f = importFile.files && importFile.files[0];
        if (!f) {
            importFb.textContent = 'Выберите файл .json или .txt.';
            importFb.className = 'admin-builtin-import-feedback admin-builtin-import-feedback--warn';
            importFb.hidden = false;
            return;
        }
        const fd = new FormData();
        fd.append('json_file', f);
        fd.append('_token', token ? token.content : '');
        try {
            const r = await fetch(importUrl, {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            const raw = await r.text();
            let data = {};
            try {
                data = raw ? JSON.parse(raw) : {};
            } catch (e) {
                importFb.textContent = 'Сервер вернул не JSON.';
                importFb.className = 'admin-builtin-import-feedback admin-builtin-import-feedback--error';
                importFb.hidden = false;
                return;
            }
            if (!r.ok) {
                importFb.textContent = data.message || 'Ошибка импорта.';
                importFb.className = 'admin-builtin-import-feedback admin-builtin-import-feedback--error';
                importFb.hidden = false;
                return;
            }
            let added = 0;
            (data.characters || []).forEach(function(ch) {
                if (rows.some(function(r) { return r.id === ch.id; })) return;
                rows.push({
                    id: ch.id,
                    character: ch.character,
                    pinyin: ch.pinyin || '',
                    meaning: ch.meaning || '',
                    hsk_level: ch.hsk_level
                });
                added++;
            });
            let msg = 'Добавлено новых позиций: ' + added + '.';
            if (data.missing && data.missing.length) {
                msg += ' Не найдены в базе: ' + data.missing.slice(0, 20).join(', ') +
                    (data.missing.length > 20 ? '…' : '') + '.';
            }
            importFb.textContent = msg;
            importFb.className = 'admin-builtin-import-feedback admin-builtin-import-feedback--ok';
            importFb.hidden = false;
            importFile.value = '';
            render();
        } catch (e) {
            console.error(e);
            importFb.textContent = 'Не удалось выполнить запрос.';
            importFb.className = 'admin-builtin-import-feedback admin-builtin-import-feedback--error';
            importFb.hidden = false;
        }
    });

    async function hydrateFromHiddenIfNeeded() {
        if (initialRows.length > 0) {
            rows = initialRows.slice();
            render();
            return;
        }
        let raw = hidden.value;
        if (!raw || raw === '[]') {
            render();
            return;
        }
        let ids;
        try {
            ids = JSON.parse(raw);
        } catch (e) {
            render();
            return;
        }
        if (!Array.isArray(ids) || !ids.length) {
            render();
            return;
        }
        try {
            const r = await fetch(resolveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token ? token.content : ''
                },
                body: JSON.stringify({ ids: ids })
            });
            const data = await r.json();
            if (r.ok && data.characters) {
                rows = data.characters;
            }
        } catch (e) {
            console.error(e);
        }
        render();
    }

    function boot() {
        hydrateFromHiddenIfNeeded();
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
</script>
<?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/admin/builtin_collections/_glyph_picker.blade.php ENDPATH**/ ?>