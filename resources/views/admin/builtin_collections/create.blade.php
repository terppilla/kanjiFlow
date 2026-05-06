<x-app-layout>
    <div class="form-container admin-article-form-page">
        <h1 class="form-title">Новый шаблон подборки</h1>
        <p class="admin-form-subtitle">
            Код латиницей (например <code>travel</code>). Состав подберите поиском по базе (как у пользователя в коллекции) или импортируйте список из JSON.
        </p>

        <form action="{{ route('admin.builtin-collections.store') }}" method="POST" class="character-form">
            @csrf

            <div class="form-group">
                <label for="slug">Код (slug)</label>
                <input type="text" id="slug" name="slug" class="form-control @error('slug') error @enderror"
                       value="{{ old('slug') }}" required placeholder="например everyday">
                @error('slug')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="name">Название для пользователя</label>
                <input type="text" id="name" name="name" class="form-control @error('name') error @enderror"
                       value="{{ old('name') }}" required>
                @error('name')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="sort_order" class="optional">Порядок сортировки</label>
                <input type="number" id="sort_order" name="sort_order" min="0" class="form-control @error('sort_order') error @enderror"
                       value="{{ old('sort_order', 0) }}">
                @error('sort_order')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            @include('admin.builtin_collections._glyph_picker', ['initialCharacters' => []])

            @error('character_ids')<div class="error-message admin-builtin-character-ids-error">{{ $message }}</div>@enderror

            <div class="form-actions">
                <button type="submit" class="btn-submit">Создать шаблон</button>
                <a href="{{ route('admin.builtin-collections.index') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>
</x-app-layout>
