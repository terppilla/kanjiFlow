<x-app-layout>
    <div class="articles-page">
        <div class="articles-shell">
            <div class="articles-header">
                <div class="articles-header-text">
                    <h1 class="articles-title">Избранные статьи</h1>
                    <p class="articles-lead">Список статей, которые вы сохранили для быстрого доступа.</p>
                </div>
                <a href="{{ route('articles.index') }}" class="btn btn-outline">Все статьи</a>
            </div>

            <div class="articles-grid">
                @forelse($articles as $article)
                    <article class="article-card">
                        @if($article->images->first())
                            <a href="{{ route('articles.show', $article) }}">
                                <div class="article-card-image-wrap">
                                    <img src="{{ Storage::url($article->images->first()->image_path) }}" alt="{{ $article->title }}" class="article-card-image">
                                </div>
                            </a>
                        @endif

                        <div class="article-card-body">
                            <h2 class="article-card-title">
                                <a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a>
                            </h2>

                            @if($article->subtitle)
                                <p class="article-card-subtitle">{{ $article->subtitle }}</p>
                            @endif

                            <div class="article-card-actions">
                                <a href="{{ route('articles.show', $article) }}" class="btn btn-ghost">Читать</a>
                                <form method="POST" action="{{ route('articles.favorite.toggle', $article) }}">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="favorite-icon-btn is-active"
                                        aria-label="Убрать из избранного"
                                        title="Убрать из избранного"
                                    >
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12.001 21s-7.2-4.438-9.428-8.125C.75 9.862 1.316 6.054 4.4 4.644 6.495 3.68 8.877 4.16 10.4 5.82L12 7.56l1.6-1.74c1.523-1.66 3.905-2.14 6-1.176 3.084 1.41 3.65 5.218 1.827 8.231C19.201 16.562 12.001 21 12.001 21z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="articles-empty-state">
                        Вы ещё не добавили статьи в избранное.
                    </div>
                @endforelse
            </div>

            <div class="pagination">
                {{ $articles->links('vendor.pagination.my-pagination') }}
            </div>
        </div>
    </div>
</x-app-layout>
