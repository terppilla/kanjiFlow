<section class="admin-tools-panel" aria-label="Импорт и озвучка">
    <div class="admin-tools-grid">
        <article class="admin-tool-card admin-tool-card--import">
            <header class="admin-tool-card-header">
                <span class="admin-tool-card-icon" aria-hidden="true">📥</span>
                <div>
                    <h2 class="admin-tool-card-title">Импорт из JSON</h2>
                    <p class="admin-tool-card-desc">Загрузите файл с иероглифами в формате <code>characters.json</code></p>
                </div>
            </header>
            <details class="admin-tool-details">
                <summary>Формат полей</summary>
                <p class="admin-tool-format">
                    <code>character</code>, <code>pinyin</code>, <code>meaning</code>, <code>hsk_level</code> (1–6),
                    <code>example_hanzi</code>, <code>example_pinyin</code>, <code>example_translation</code>, <code>audio</code>.
                </p>
            </details>
            <form action="{{ route('admin.characters.import-json') }}" method="POST" enctype="multipart/form-data" class="admin-tool-form">
                @csrf
                <label class="admin-tool-file-label">
                    <span class="admin-tool-file-label-text">Файл (.json или .txt)</span>
                    <input type="file" name="json_file" accept=".json,.txt,application/json" required class="admin-tool-file-input">
                </label>
                <label class="admin-checkbox-label admin-tool-checkbox">
                    <input type="checkbox" name="generate_audio" value="1">
                    <span>Сгенерировать аудио после импорта</span>
                </label>
                <div class="admin-tool-actions">
                    <button type="submit" class="admin-btn admin-btn--primary">Загрузить и импортировать</button>
                </div>
            </form>
        </article>

        <article class="admin-tool-card admin-tool-card--audio">
            <header class="admin-tool-card-header">
                <span class="admin-tool-card-icon" aria-hidden="true">🔊</span>
                <div>
                    <h2 class="admin-tool-card-title">Генерация аудио</h2>
                    <p class="admin-tool-card-desc">Edge TTS для иероглифов и примеров без озвучки</p>
                </div>
            </header>
            <p class="admin-tool-audio-note">
                Обрабатывается по {{ \App\Services\CharacterAudioService::BULK_BATCH_SIZE }} записей за запуск.
                При большой базе процесс продолжится автоматически.
            </p>
            <div class="admin-tool-actions admin-tool-actions--stack">
                <button type="button" id="bulkAudioBtn" class="admin-btn admin-btn--outline"
                    data-url="{{ route('admin.characters.audio.bulk') }}">
                    Сгенерировать отсутствующее аудио
                </button>
            </div>
            <p id="bulkAudioStatus" class="admin-tool-status" aria-live="polite"></p>
        </article>
    </div>
</section>
