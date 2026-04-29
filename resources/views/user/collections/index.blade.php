<x-app-layout>
    <div class="collections-page">
        <div class="collections-shell page-collections-index">
            <header class="collections-header">
                <div class="collections-header-text">
                    <h1 class="collections-title">Мои коллекции</h1>
                    <p class="collections-lead">Собирайте иероглифы в наборы и учите их отдельно от уровней HSK.</p>
                </div>
                <a href="{{ route('collections.create') }}" class="btn btn-primary collections-header-cta">
                    <span aria-hidden="true">+</span> Новая коллекция
                </a>
            </header>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif

            @if($collections->isEmpty())
                <div class="collections-empty-state">
                    <p>Пока нет коллекций. Создайте первую и добавьте в неё иероглифы.</p>
                    <a href="{{ route('collections.create') }}" class="btn btn-primary">Создать коллекцию</a>
                </div>
            @else
                <ul class="coll-list" role="list">
                    @foreach($collections as $collection)
                        <li class="coll-card">
                            <div class="coll-card-main">
                                <h2 class="coll-card-title">{{ $collection->name }}</h2>
                                <div class="coll-meta">Иероглифов: <span class="coll-meta-count">{{ $collection->characters_count }}</span></div>
                            </div>
                            <div class="coll-actions">
                                <a href="{{ route('learning.collection.level', $collection) }}" class="btn btn-primary btn-sm">Учить</a>
                                <a href="{{ route('collections.show', $collection) }}" class="btn btn-outline btn-sm">Открыть</a>
                                <a href="{{ route('collections.edit', $collection) }}" class="btn btn-ghost btn-sm">Переименовать</a>
                                <form action="{{ route('collections.destroy', $collection) }}" method="post" class="coll-delete-form"
                                    onsubmit="return confirm('Удалить коллекцию «{{ addslashes($collection->name) }}»? Связи с иероглифами будут сняты.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger-outline btn-sm">Удалить</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <p class="collections-footer-nav">
                <a href="{{ route('learning.select-level') }}" class="btn btn-ghost">← К выбору HSK</a>
            </p>
        </div>
    </div>
</x-app-layout>
