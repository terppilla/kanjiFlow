<x-app-layout>
    <div class="form-container admin-article-form-page">
        <h1 class="form-title">Шаблон: {{ $template->name }}</h1>
        <p class="admin-form-subtitle">
            Код <code>{{ $template->slug }}</code> менять нельзя (привязка к коллекциям пользователей). Измените название, порядок и состав иероглифов — через поиск или импорт JSON.
        </p>

        <form action="{{ route('admin.builtin-collections.update', $template) }}" method="POST" class="character-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="slug_readonly">Код (slug)</label>
                <input type="text" id="slug_readonly" class="form-control" value="{{ $template->slug }}" disabled>
            </div>

            <div class="form-group">
                <label for="name">Название для пользователя</label>
                <input type="text" id="name" name="name" class="form-control @error('name') error @enderror"
                       value="{{ old('name', $template->name) }}" required>
                @error('name')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="sort_order" class="optional">Порядок сортировки</label>
                <input type="number" id="sort_order" name="sort_order" min="0" class="form-control @error('sort_order') error @enderror"
                       value="{{ old('sort_order', $template->sort_order) }}">
                @error('sort_order')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            @include('admin.builtin_collections._glyph_picker', [
                'initialCharacters' => $errors->any() ? [] : $initialCharacters,
            ])

            @error('character_ids')<div class="error-message admin-builtin-character-ids-error">{{ $message }}</div>@enderror

            <div class="form-actions">
                <button type="submit" class="btn-submit">Сохранить</button>
                <a href="{{ route('admin.builtin-collections.index') }}" class="btn-cancel">К списку</a>
            </div>
        </form>
    </div>
</x-app-layout>
