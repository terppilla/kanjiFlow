<x-app-layout>
    <div class="box page-collections-form">
        <h1>Переименовать коллекцию</h1>
        <form action="{{ route('collections.update', $collection) }}" method="post">
            @csrf
            @method('PUT')
            <div>
                <label for="name">Название</label>
                <input type="text" id="name" name="name" value="{{ old('name', $collection->name) }}" required maxlength="120">
                @error('name')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="actions">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('collections.show', $collection) }}" class="btn btn-ghost">Назад</a>
            </div>
        </form>

        <hr class="collections-separator">

        <form action="{{ route('collections.destroy', $collection) }}" method="post" onsubmit="return confirm('Удалить коллекцию «{{ $collection->name }}»? Иероглифы останутся в базе.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Удалить коллекцию</button>
        </form>
    </div>
</x-app-layout>
