<x-app-layout>
    <div class="collections-page">
        <div class="collections-shell page-collections-form">
            <div class="collections-form-card">
                <h1 class="collections-title">Новая коллекция</h1>
                <p class="collections-lead collections-lead--compact">Задайте название — позже добавите иероглифы через поиск.</p>
                <form action="{{ route('collections.store') }}" method="post">
                    @csrf
                    <div class="collections-field">
                        <label for="name">Название</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="120" placeholder="Например: Глаголы на неделю">
                        @error('name')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="collections-form-actions">
                        <button type="submit" class="btn btn-primary">Создать</button>
                        <a href="{{ route('collections.index') }}" class="btn btn-ghost">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
