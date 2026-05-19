<x-app-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @endpush


    <div class="dashboard-container">

        <!-- Основной контент -->
        <main class="dashboard-main">
            <!-- Левая колонка: Быстрые действия -->
            <aside class="sidebar">
                <div class="quick-actions">
                    <h3>Быстрые действия</h3>
                    <a href="{{ route('learning.review.due') }}" class="btn action-btn primary">
                        <span class="action-icon">⏱</span>
                        <span class="action-text">Повторить иероглифы ({{ $dueCardsTotal }})</span>
                    </a>
                    <a href="{{ route('learning.select-level') }}" class="action-btn">
                        <span class="action-text">Изучать новые</span>
                    </a>
                    <a href="{{ route('collections.index') }}" class="action-btn">
                        <span class="action-text">Мои коллекции</span>
                    </a>
                    <a href="{{ route('articles.index') }}" class="action-btn">
                        <span class="action-text">Читать статьи</span>
                    </a>
                </div>

                <!-- Статистика -->
                <div class="sidebar-stats">
                    <h3>Общая статистика</h3>
                    <div class="stat-item">
                        <span class="stat-label">Выучено всего:</span>
                        <span class="stat-value">{{ $reviewStats['total_learned'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Повторений:</span>
                        <span class="stat-value">{{ $reviewStats['total_reviews'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Точность:</span>
                        <span class="stat-value">{{ round($reviewStats['average_success_rate'] ?? 0) }}%</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Серия дней:</span>
                        <span class="stat-value">{{ (int) (Auth::user()->study_streak ?? 0) }}</span>
                    </div>
                </div>

                <div class="achievements-section">
                    <div class="achievements-section-head">
                        <h3>
                            Достижения
                            <span class="achievements-counter">({{ $earnedCount }}/{{ $totalAchievementsCount }})</span>
                        </h3>
                        <a href="{{ route('achievements.index') }}" class="achievements-all-link">Все</a>
                    </div>

                    @if($sidebarAchievements->isNotEmpty())
                        <ul class="achievements-grid" role="list">
                            @foreach($sidebarAchievements as $achievement)
                                <li class="achievements-grid__item" role="listitem">
                                    @include('user.achievements.partials.card', [
                                        'achievement' => $achievement,
                                        'earnedAtByAchievementId' => $earnedAtByAchievementId,
                                    ])
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="achievements-empty-inline">
                            Пока нет полученных достижений.
                            <a href="{{ route('achievements.index') }}">Открыть список</a>
                        </p>
                    @endif
                </div>

            </aside>

            <!-- Центральная колонка: Основная информация -->
            <section class="main-content">
                <!-- Приветствие -->
                <div class="welcome-section">
                    <h2>Добро пожаловать, {{ Auth::user()->name }}!</h2>
                    <p>Сегодня у вас <strong>{{ $dueCardsTotal }}</strong> иероглифов для повторения</p>
                </div>

                <!-- Прогресс по уровням HSK -->
                <div class="hsk-progress-section">
                    <h3>Прогресс по уровням HSK</h3>
                    <div class="hsk-levels">
                        @for($level = 1; $level <= 6; $level++)
                            <div class="hsk-level-card">
                                <div class="hsk-header">
                                    <h4>HSK {{ $level }}</h4>
                                    <span class="hsk-count">
                                        {{ $hskStats[$level]['learned'] ?? 0 }}/{{ $hskStats[$level]['total'] ?? 0 }}
                                    </span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" 
                                         style="width: {{ $hskStats[$level]['progress'] ?? 0 }}%">
                                    </div>
                                </div>
                                <div class="hsk-progress-text">
                                    {{ $hskStats[$level]['progress'] ?? 0 }}%
                                </div>
                                <a href="{{ route('learning.level', $level) }}" class="hsk-action-btn">
                                    Изучать
                                </a>
                            </div>
                        @endfor
                    </div>
                </div>

              

                <!-- Иероглифы для повторения сегодня -->
                <div class="due-cards-section">
                    <h3>Иероглифы для повторения сегодня</h3>
                    @if($dueCards->count() > 0)
                        <div class="due-cards-grid">
                            @foreach($dueCards as $card)
                                <div class="due-card">
                                    <div class="due-card-character">
                                        {{ $card->character->character }}
                                    </div>
                                    <div class="due-card-info">
                                        <div class="due-card-pinyin">{{ $card->character->pinyin }}</div>
                                        <div class="due-card-meaning">{{ $card->character->meaning }}</div>
                                        <div class="due-card-meta">
                                            <span class="due-card-level">HSK {{ $card->character->hsk_level }}</span>
                                            <span class="due-card-time">
                                                {{ $card->next_review_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="pagination">
                            {{ $dueCards->links('vendor.pagination.my-pagination') }}
                        </div>
                        
                        <a href="{{ route('learning.review.due') }}" class="btn action-btn primary">
                            <span class="action-icon">⏱</span>
                            <span class="action-text">Повторить иероглифы ({{ $dueCardsTotal }})</span>
                        </a>
                
                    @else
                        <div class="no-cards-message">
                            Отличная работа! Сегодня нет иероглифов для повторения.
                            <a href="{{ route('learning.select-level') }}">Изучите новые иероглифы</a>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Правая колонка: Коллекции и активность -->
            <aside class="right-sidebar">
                <!-- Мои коллекции -->
                <div class="collections-section">
                    <div class="section-header">
                        <h3>Мои коллекции</h3>
                        <a href="{{ route('collections.create') }}" class="add-collection-btn">+</a>
                    </div>
                    @if(isset($collections) && $collections->count() > 0)
                        <div class="collections-list">
                            @foreach($collections->take(5) as $collection)
                                <div class="collection-item">
                                    <div class="collection-info">
                                        <h4 class="collection-name">{{ $collection->name }}</h4>
                                        <span class="collection-count">
                                            {{ $collection->characters_count ?? 0 }} иероглифов
                                        </span>
                                    </div>
                                    <div class="collection-actions">
                                        <a href="{{ route('collections.show', $collection) }}" 
                                           class="collection-view-btn">Открыть</a>
                                        <a href="{{ route('collections.review', $collection) }}" 
                                           class="action-btn primary">Повторить</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="collections-section-footer">
                            <a href="{{ route('collections.index') }}" class="collections-all-btn">Все коллекции</a>
                        </div>
                    @else
                        <div class="no-collections">
                            <p>У вас пока нет коллекций</p>
                            <a href="{{ route('collections.create') }}" class="create-collection-btn">
                                Создать первую коллекцию
                            </a>
                        </div>
                    @endif
                </div>


            </aside>
        </main>

        <!-- Подвал -->
        <footer class="dashboard-footer">
            <div class="footer-content">
                <p>KanjiFlow © 2026 - Система изучения китайских иероглифов</p>
                <div class="footer-links">
                    <a href="#">Помощь</a>
                    <a href="#">О проекте</a>
                    <a href="#">Контакты</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Простая анимация для прогресс-баров
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.hsk-level-card .progress-fill').forEach(function(bar) {
                var width = bar.style && bar.style.width;
                if (!width && bar.getAttribute('style')) {
                    var m = bar.getAttribute('style').match(/width\s*:\s*([^;]+)/i);
                    if (m) {
                        width = m[1].trim();
                    }
                }
                if (!width) {
                    return;
                }
                bar.style.width = '0';
                setTimeout(function() {
                    bar.style.transition = 'width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1)';
                    bar.style.width = width;
                }, 80);
            });
        });

        // Уведомления
        @if(session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
            notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()">×</button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

document.addEventListener('DOMContentLoaded', function() {
    // Находим все ссылки пагинации
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            let url = this.getAttribute('href');
            
            // Показываем загрузку
            document.querySelector('.due-cards-grid').style.opacity = '0.5';
            
            // Загружаем новую страницу
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                // Обновляем весь блок
                let temp = document.createElement('div');
                temp.innerHTML = html;
                
                let newGrid = temp.querySelector('.due-cards-grid');
                let newPagination = temp.querySelector('.pagination');
                
                if (newGrid) document.querySelector('.due-cards-grid').innerHTML = newGrid.innerHTML;
                if (newPagination) document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
                
                document.querySelector('.due-cards-grid').style.opacity = '1';
                
                // Обновляем обработчики
                attachHandlers();
            });
        });
    });
    
    function attachHandlers() {
        document.querySelectorAll('.pagination a').forEach(link => {
            link.removeEventListener('click', clickHandler);
            link.addEventListener('click', clickHandler);
        });
    }
    
    function clickHandler(e) {
        e.preventDefault();
        let url = this.getAttribute('href');
        
        document.querySelector('.due-cards-grid').style.opacity = '0.5';
        
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                let temp = document.createElement('div');
                temp.innerHTML = html;
                
                let newGrid = temp.querySelector('.due-cards-grid');
                let newPagination = temp.querySelector('.pagination');
                
                if (newGrid) document.querySelector('.due-cards-grid').innerHTML = newGrid.innerHTML;
                if (newPagination) document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
                
                document.querySelector('.due-cards-grid').style.opacity = '1';
                attachHandlers();
            });
    }
    
    attachHandlers();
});
        
    </script>
</x-app-layout>
