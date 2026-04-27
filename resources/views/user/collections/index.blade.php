<x-app-layout>
    <div class="coll-wrap page-collections-index">
        <div class="coll-head">
            <div>
                <h1>Мои коллекции</h1>
                <p>Собирайте иероглифы в наборы и учите их отдельно от уровней HSK.</p>
            </div>
            <a href="{{ route('collections.create') }}" class="btn btn-primary">+ Новая коллекция</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        @if($collections->isEmpty())
            <div class="empty">
                Пока нет коллекций. Создайте первую и добавьте в неё иероглифы.
            </div>
        @else
            <div class="coll-list">
                @foreach($collections as $collection)
                    <div class="coll-card">
                        <div>
                            <h2>{{ $collection->name }}</h2>
                            <div class="coll-meta">Иероглифов: {{ $collection->characters_count }}</div>
                        </div>
                        <div class="coll-actions">
                            <a href="{{ route('learning.collection.level', $collection) }}" class="btn btn-primary btn-sm">Учить</a>
                            <a href="{{ route('collections.show', $collection) }}" class="btn btn-ghost btn-sm">Открыть</a>
                            <a href="{{ route('collections.edit', $collection) }}" class="btn btn-ghost btn-sm">Переименовать</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <p class="collections-back-row"><a href="{{ route('learning.select-level') }}" class="btn btn-ghost">← К выбору HSK</a></p>
    </div>
</x-app-layout>
