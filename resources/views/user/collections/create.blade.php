<x-app-layout>
    <div class="box page-collections-form">
        <h1>Новая коллекция</h1>
        <form action="{{ route('collections.store') }}" method="post">
            @csrf
            <div>
                <label for="name">Название</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="120" placeholder="Например: Глаголы на неделю">
                @error('name')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Создать</button>
                <a href="{{ route('collections.index') }}" class="btn btn-ghost">Отмена</a>
            </div>
        </form>
    </div>
</x-app-layout>
