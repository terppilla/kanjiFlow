<x-app-layout>
    <div class="collections-page">
        <div class="collections-shell page-collections-form">
            <div class="collections-form-card">
                <h1 class="collections-title">Переименовать коллекцию</h1>
                <form action="{{ route('collections.update', $collection) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="collections-field">
                        <label for="name">Название</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $collection->name) }}" required maxlength="120">
                        @error('name')<div class="err">{{ $message }}</div>@enderror
                    </div>
                    <div class="collections-form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="{{ route('collections.show', $collection) }}" class="btn btn-ghost">Назад к коллекции</a>
                    </div>
                </form>

                <div class="collections-danger-zone collections-danger-zone--inline">
                    <h2 class="collections-danger-title">Удалить коллекцию</h2>
                    <p class="collections-danger-text">Иероглифы останутся в базе; удаляется только этот набор.</p>
                    <form action="{{ route('collections.destroy', $collection) }}" method="post"
                        onsubmit="return confirm('Удалить коллекцию «{{ addslashes($collection->name) }}»?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-solid">Удалить коллекцию</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
