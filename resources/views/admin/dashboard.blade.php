<x-app-layout>

    <body class="admin-layout">
        <x-slot name="header">
            <h2 class="header admin">
                {{ __('Админ панель') }}
            </h2>
        </x-slot>
        
        <div class="admin-container">
            <!-- Навигация -->
            <nav class="admin-nav">
                <ul>
                    <li><a href="{{ route('admin.characters.index') }}">Иероглифы</a></li>
                    <li><a href="#">Пользователи</a></li>
                    <li><a href="#">Статистика</a></li>
                    <li><a href="#">Настройки</a></li>
                </ul>
            </nav>
            
            <!-- Статистика -->
            <div class="admin-stats">
                <div class="stat-card">
                    {{-- <div class="stat-icon">👥</div> --}}
                    <div class="stat-value">1,254</div>
                    <div class="stat-label">Всего пользователей</div>
                    <div class="stat-change">↑ +12.5% за месяц</div>
                </div>
                
                <div class="stat-card">
                    {{-- <div class="stat-icon">🎯</div> --}}
                    <div class="stat-value">342</div>
                    <div class="stat-label">Активных сегодня</div>
                    <div class="stat-change">↑ +8.2% за неделю</div>
                </div>
                
                <div class="stat-card">
                    {{-- <div class="stat-icon">📚</div> --}}
                    <div class="stat-value">2,847</div>
                    <div class="stat-label">Изучено иероглифов</div>
                    <div class="stat-change">↑ +15.3% за месяц</div>
                </div>
                
                <div class="stat-card">
                    {{-- <div class="stat-icon">⏱️</div> --}}
                    <div class="stat-value">4.2ч</div>
                    <div class="stat-label">Среднее время обучения</div>
                    <div class="stat-change negative">↓ -2.1% за неделю</div>
                </div>
            </div>
            
            <!-- Графики -->
            <div class="admin-charts">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Активность пользователей</h3>
                        <div class="chart-period">
                            <select>
                                <option>За неделю</option>
                                <option>За месяц</option>
                                <option>За год</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-placeholder">
                        График активности
                        <small>Здесь будет график активности пользователей</small>
                    </div>
                </div>
                
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>Распределение по уровням HSK</h3>
                        <div class="chart-period">
                            <select>
                                <option>Текущий месяц</option>
                                <option>Прошлый месяц</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-placeholder">
                        Диаграмма уровней
                        <small>Здесь будет диаграмма распределения по HSK</small>
                    </div>
                </div>
            </div>
            
            <!-- Быстрые действия -->
            <div class="quick-actions">
                <h3>Быстрые действия</h3>
                <div class="action-buttons">
                    <a href="#" class="action-btn">
                        {{-- <div class="action-icon">➕</div> --}}
                        <div class="action-text">
                            <div class="action-title">Добавить иероглиф</div>
                            <div class="action-desc">Создать новый иероглиф</div>
                        </div>
                    </a>
                    
                    <a href="#" class="action-btn">
                        {{-- <div class="action-icon">👤</div> --}}
                        <div class="action-text">
                            <div class="action-title">Добавить пользователя</div>
                            <div class="action-desc">Создать аккаунт пользователя</div>
                        </div>
                    </a>
                    
                    <a href="#" class="action-btn">
                        {{-- <div class="action-icon">📤</div> --}}
                        <div class="action-text">
                            <div class="action-title">Экспорт данных</div>
                            <div class="action-desc">Выгрузить статистику</div>
                        </div>
                    </a>
                    
                    <a href="#" class="action-btn">
                        {{-- <div class="action-icon">💾</div> --}}
                        <div class="action-text">
                            <div class="action-title">Создать бэкап</div>
                            <div class="action-desc">Резервное копирование</div>
                        </div>
                    </a>
                </div>
            </div>
            
            <!-- Недавняя активность -->
            {{-- <div class="recent-activity">
                <div class="activity-header">
                    <h3>Недавняя активность</h3>
                    <a href="#" class="btn--outline">Вся активность</a>
                </div>
                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-avatar">ИИ</div>
                        <div class="activity-content">
                            <p class="activity-text">Иван Иванов добавил новый иероглиф "愛"</p>
                            <div class="activity-time">10 минут назад</div>
                        </div>
                        <div class="activity-badge">Добавление</div>
                    </li>
                    
                    <li class="activity-item">
                        <div class="activity-avatar">ПП</div>
                        <div class="activity-content">
                            <p class="activity-text">Петр Петров обновил настройки системы</p>
                            <div class="activity-time">1 час назад</div>
                        </div>
                        <div class="activity-badge">Настройки</div>
                    </li>
                    
                    <li class="activity-item">
                        <div class="activity-avatar">СС</div>
                        <div class="activity-content">
                            <p class="activity-text">Светлана Светова зарегистрировала нового пользователя</p>
                            <div class="activity-time">3 часа назад</div>
                        </div>
                        <div class="activity-badge">Регистрация</div>
                    </li>
                </ul>
            </div> --}}
        </div>
    </body>
</x-app-layout>