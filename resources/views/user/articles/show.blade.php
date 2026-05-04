<x-app-layout>
    <div class="article-show-page">
        <div class="article-show-shell">
            <div class="article-show-nav">
                <a href="{{ route('articles.index') }}" class="btn btn-outline">← Все статьи</a>
                <a href="{{ route('articles.favorites') }}" class="btn btn-ghost">Избранные</a>
            </div>

            <article class="article-show-card">
                <header class="article-show-header">
                    <h1>{{ $article->title }}</h1>
                    @if($article->subtitle)
                        <p>{{ $article->subtitle }}</p>
                    @endif
                    <div class="article-show-meta">
                        <span>Автор: {{ $article->author->name ?? 'Администратор' }}</span>
                        <span>Дата: {{ $article->created_at->format('d.m.Y') }}</span>
                    </div>
                    <form method="POST" action="{{ route('articles.favorite.toggle', $article) }}">
                        @csrf
                        <button
                            type="submit"
                            class="favorite-icon-btn {{ $isFavorite ? 'is-active' : '' }}"
                            aria-label="{{ $isFavorite ? 'Убрать из избранного' : 'Добавить в избранное' }}"
                            title="{{ $isFavorite ? 'Убрать из избранного' : 'Добавить в избранное' }}"
                        >
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.001 21s-7.2-4.438-9.428-8.125C.75 9.862 1.316 6.054 4.4 4.644 6.495 3.68 8.877 4.16 10.4 5.82L12 7.56l1.6-1.74c1.523-1.66 3.905-2.14 6-1.176 3.084 1.41 3.65 5.218 1.827 8.231C19.201 16.562 12.001 21 12.001 21z"/>
                            </svg>
                        </button>
                    </form>
                </header>

                @if($article->images->isNotEmpty())
                    <section class="article-gallery">
                        @foreach($article->images as $image)
                            <figure>
                                <div class="article-gallery-media">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $article->title }}">
                                </div>
                                @if($image->caption)
                                    <figcaption>{{ $image->caption }}</figcaption>
                                @endif
                            </figure>
                        @endforeach
                    </section>
                @endif

                <section class="article-content prose">
                    {!! $article->content !!}
                </section>
            </article>
        </div>
    </div>
</x-app-layout>
