<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои коллекции - KanjiFlow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #f8fafc;
            color: #1f2937;
        }
        
        .collections-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Шапка */
        .collections-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        
        .header-left h1 {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        .header-left p {
            color: #6b7280;
            font-size: 1.1rem;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: #f3f4f6;
            color: #4b5563;
            border: 2px solid #e5e7eb;
        }
        
        .btn-secondary:hover {
            background: #e5e7eb;
        }
        
        .btn-back {
            background: #374151;
            color: white;
        }
        
        .btn-back:hover {
            background: #1f2937;
        }
        
        /* Основной контент */
        .collections-main {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }
        
        /* Левая боковая панель - фильтры и статистика */
        .collections-sidebar {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .sidebar-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .sidebar-title {
            font-size: 1.2rem;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Фильтры */
        .filter-section {
            margin-bottom: 20px;
        }
        
        .filter-label {
            display: block;
            color: #6b7280;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .filter-select, .filter-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .filter-select:focus, .filter-input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .filter-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            cursor: pointer;
        }
        
        .filter-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #d1d5db;
        }
        
        /* Статистика */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .stat-item {
            text-align: center;
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
        }
        
        .stat-value {
            display: block;
            font-size: 1.8rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
        }
        
        /* Правая часть - коллекции */
        .collections-content {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        /* Панель поиска */
        .search-bar {
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        
        .search-form {
            display: flex;
            gap: 15px;
        }
        
        .search-input {
            flex: 1;
            padding: 14px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .search-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .search-btn:hover {
            background: #5a6fd8;
        }
        
        /* Сетка коллекций */
        .collections-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        /* Карточка коллекции */
        .collection-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s;
            border: 2px solid transparent;
        }
        
        .collection-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
            border-color: #667eea;
        }
        
        .collection-header {
            padding: 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
        }
        
        .collection-header h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .collection-description {
            opacity: 0.9;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        
        .collection-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .collection-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        /* Тело карточки */
        .collection-body {
            padding: 25px;
        }
        
        .collection-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .collection-stat {
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
        }
        
        .collection-stat-value {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .collection-stat-label {
            font-size: 0.85rem;
            color: #6b7280;
        }
        
        /* Прогресс изучения */
        .collection-progress {
            margin-bottom: 20px;
        }
        
        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: #6b7280;
        }
        
        .progress-bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
            border-radius: 4px;
            transition: width 1s ease;
        }
        
        /* Действия */
        .collection-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 20px;
        }
        
        .collection-action-btn {
            padding: 12px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            font-size: 0.9rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .action-view {
            background: #667eea;
            color: white;
        }
        
        .action-view:hover {
            background: #5a6fd8;
        }
        
        .action-review {
            background: #10b981;
            color: white;
        }
        
        .action-review:hover {
            background: #0da271;
        }
        
        .action-edit {
            background: #f3f4f6;
            color: #4b5563;
        }
        
        .action-edit:hover {
            background: #e5e7eb;
        }
        
        .action-delete {
            background: #fef2f2;
            color: #dc2626;
            border: 2px solid #fee2e2;
        }
        
        .action-delete:hover {
            background: #fee2e2;
        }
        
        /* Пустое состояние */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .empty-icon {
            font-size: 5rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
        
        .empty-title {
            font-size: 1.8rem;
            color: #1f2937;
            margin-bottom: 15px;
        }
        
        .empty-description {
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }
        
        /* Модальное окно создания коллекции */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            animation: modalAppear 0.3s ease;
        }
        
        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .modal-header {
            padding: 25px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .modal-header h3 {
            font-size: 1.5rem;
            margin: 0;
        }
        
        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            color: #1f2937;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .form-input, .form-textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }
        
        .form-checkbox input[type="checkbox"] {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            border: 2px solid #d1d5db;
        }
        
        .modal-footer {
            padding: 20px 30px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }
        
        .modal-btn {
            padding: 12px 28px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .modal-btn-primary {
            background: #667eea;
            color: white;
        }
        
        .modal-btn-primary:hover {
            background: #5a6fd8;
        }
        
        .modal-btn-secondary {
            background: #e5e7eb;
            color: #4b5563;
        }
        
        .modal-btn-secondary:hover {
            background: #d1d5db;
        }
        
        /* Уведомления */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 18px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 1001;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .notification button {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
        }
        
        /* Адаптивность */
        @media (max-width: 1200px) {
            .collections-main {
                grid-template-columns: 1fr;
            }
            
            .collections-sidebar {
                order: 2;
            }
        }
        
        @media (max-width: 768px) {
            .collections-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .header-actions {
                flex-direction: column;
                width: 100%;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .collections-grid {
                grid-template-columns: 1fr;
            }
            
            .search-form {
                flex-direction: column;
            }
        }
        
        @media (max-width: 480px) {
            .collection-actions {
                grid-template-columns: 1fr;
            }
            
            .collection-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="collections-container">
        <!-- Шапка -->
        <div class="collections-header">
            <div class="header-left">
                <h1>📚 Мои коллекции</h1>
                <p>Создавайте и организуйте иероглифы для эффективного обучения</p>
            </div>
            
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-back">
                    ← Назад в дашборд
                </a>
                <button class="btn btn-primary" onclick="showCreateModal()">
                    ➕ Создать коллекцию
                </button>
            </div>
        </div>
        
        <!-- Основной контент -->
        <div class="collections-main">
            <!-- Левая боковая панель -->
            <aside class="collections-sidebar">
                <!-- Фильтры -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">🔍 Фильтры</h3>
                    
                    <div class="filter-section">
                        <label class="filter-label">Поиск по названию</label>
                        <input type="text" class="filter-input" placeholder="Введите название..." id="searchFilter">
                    </div>
                    
                    <div class="filter-section">
                        <label class="filter-label">Сортировка</label>
                        <select class="filter-select" id="sortFilter">
                            <option value="newest">Сначала новые</option>
                            <option value="oldest">Сначала старые</option>
                            <option value="name_asc">По названию (А-Я)</option>
                            <option value="name_desc">По названию (Я-А)</option>
                            <option value="size_desc">По размеру (большие)</option>
                            <option value="size_asc">По размеру (маленькие)</option>
                        </select>
                    </div>
                    
                    <div class="filter-section">
                        <label class="filter-label">Показать</label>
                        <div class="filter-checkbox">
                            <input type="checkbox" id="showWithCards" checked>
                            <label for="showWithCards">С иероглифами</label>
                        </div>
                        <div class="filter-checkbox">
                            <input type="checkbox" id="showEmpty" checked>
                            <label for="showEmpty">Пустые</label>
                        </div>
                        <div class="filter-checkbox">
                            <input type="checkbox" id="showPublic">
                            <label for="showPublic">Только публичные</label>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary" style="width: 100%; margin-top: 10px;" onclick="applyFilters()">
                        Применить фильтры
                    </button>
                </div>
                
                <!-- Статистика -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">📊 Статистика</h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-value" id="totalCollections">{{ $collections->count() }}</span>
                            <span class="stat-label">Коллекций</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value" id="totalCharacters">0</span>
                            <span class="stat-label">Иероглифов</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value" id="learnedCharacters">0</span>
                            <span class="stat-label">Выучено</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value" id="progressPercent">0%</span>
                            <span class="stat-label">Прогресс</span>
                        </div>
                    </div>
                </div>
                
                <!-- Быстрые действия -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">⚡ Быстрые действия</h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="{{ route('review.show') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                            🔄 Повторить все
                        </a>
                        <a href="{{ route('learning.select-level') }}" class="btn btn-secondary" style="justify-content: flex-start;">
                            📚 Изучать новые
                        </a>
                        <button class="btn btn-secondary" style="justify-content: flex-start;" onclick="showImportModal()">
                            📥 Импорт иероглифов
                        </button>
                    </div>
                </div>
            </aside>
            
            <!-- Правая часть - коллекции -->
            <main class="collections-content">
                <!-- Панель поиска -->
                <div class="search-bar">
                    <form class="search-form" onsubmit="searchCollections(event)">
                        <input type="text" 
                               class="search-input" 
                               placeholder="Поиск по названию коллекции или описанию..."
                               id="globalSearch">
                        <button type="submit" class="search-btn">Найти</button>
                    </form>
                </div>
                
                <!-- Сетка коллекций -->
                <div class="collections-grid" id="collectionsGrid">
                    @if($collections->count() > 0)
                        @foreach($collections as $collection)
                            @php
                                $totalCharacters = $collection->characters_count ?? 0;
                                $learnedCharacters = 0; // Здесь нужно добавить логику подсчета выученных
                                $progress = $totalCharacters > 0 ? round(($learnedCharacters / $totalCharacters) * 100) : 0;
                            @endphp
                            
                            <div class="collection-card" data-collection-id="{{ $collection->id }}">
                                <div class="collection-header">
                                    <h3>{{ $collection->name }}</h3>
                                    @if($collection->description)
                                        <p class="collection-description">{{ Str::limit($collection->description, 100) }}</p>
                                    @endif
                                    <div class="collection-meta">
                                        <span>Создана {{ $collection->created_at->diffForHumans() }}</span>
                                        <span>{{ $totalCharacters }} иер.</span>
                                    </div>
                                    @if($collection->is_public)
                                        <span class="collection-badge">🌍 Публичная</span>
                                    @endif
                                </div>
                                
                                <div class="collection-body">
                                    <!-- Статистика -->
                                    <div class="collection-stats">
                                        <div class="collection-stat">
                                            <span class="collection-stat-value">{{ $totalCharacters }}</span>
                                            <span class="collection-stat-label">Всего</span>
                                        </div>
                                        <div class="collection-stat">
                                            <span class="collection-stat-value">{{ $learnedCharacters }}</span>
                                            <span class="collection-stat-label">Выучено</span>
                                        </div>
                                        <div class="collection-stat">
                                            <span class="collection-stat-value">{{ $progress }}%</span>
                                            <span class="collection-stat-label">Прогресс</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Прогресс изучения -->
                                    <div class="collection-progress">
                                        <div class="progress-header">
                                            <span>Изучено</span>
                                            <span>{{ $progress }}%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Действия -->
                                    <div class="collection-actions">
                                        <a href="{{ route('collections.show', $collection) }}" class="collection-action-btn action-view">
                                            Просмотр
                                        </a>
                                        <a href="{{ route('collections.review', $collection) }}" class="collection-action-btn action-review">
                                            Повторить
                                        </a>
                                        <a href="{{ route('collections.edit', $collection) }}" class="collection-action-btn action-edit">
                                            Изменить
                                        </a>
                                        <form action="{{ route('collections.destroy', $collection) }}" method="POST" class="delete-form" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="collection-action-btn action-delete" onclick="confirmDelete(this)">
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Пустое состояние -->
                        <div class="empty-state">
                            <div class="empty-icon">📁</div>
                            <h2 class="empty-title">У вас пока нет коллекций</h2>
                            <p class="empty-description">
                                Коллекции помогают организовывать иероглифы по темам, уровням HSK 
                                или вашим целям обучения. Создайте первую коллекцию, чтобы начать!
                            </p>
                            <button class="btn btn-primary" onclick="showCreateModal()" style="padding: 16px 40px; font-size: 1.1rem;">
                                Создать первую коллекцию
                            </button>
                        </div>
                    @endif
                </div>
                
              
                @if($collections->hasPages())
                    <div style="display: flex; justify-content: center; margin-top: 40px;">
                        <div style="display: flex; gap: 10px;">
                            @if($collections->onFirstPage())
                                <span class="btn btn-secondary" style="opacity: 0.5; cursor: not-allowed;">← Назад</span>
                            @else
                                <a href="{{ $collections->previousPageUrl() }}" class="btn btn-secondary">← Назад</a>
                            @endif
                            
                            <span class="btn" style="background: #667eea; color: white;">
                                Страница {{ $collections->currentPage() }} из {{ $collections->lastPage() }}
                            </span>
                            
                            @if($collections->hasMorePages())
                                <a href="{{ $collections->nextPageUrl() }}" class="btn btn-secondary">Вперед →</a>
                            @else
                                <span class="btn btn-secondary" style="opacity: 0.5; cursor: not-allowed;">Вперед →</span>
                            @endif
                        </div>
                    </div>
                @endif
            </main>
        </div>
    </div>
    
    <!-- Модальное окно создания коллекции -->
    <div class="modal" id="createModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Создать новую коллекцию</h3>
                <button class="modal-close" onclick="closeCreateModal()">×</button>
            </div>
            
            <form action="{{ route('collections.store') }}" method="POST" id="createForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="collectionName" class="form-label">Название коллекции *</label>
                        <input type="text" id="collectionName" name="name" class="form-input" required 
                               placeholder="Например: Основные иероглифы HSK 1">
                    </div>
                    
                    <div class="form-group">
                        <label for="collectionDescription" class="form-label">Описание (необязательно)</label>
                        <textarea id="collectionDescription" name="description" class="form-textarea" 
                                  placeholder="Опишите цель или содержание коллекции..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-checkbox">
                            <input type="checkbox" name="is_public" value="1">
                            <span>Сделать коллекцию публичной</span>
                        </label>
                        <p style="color: #6b7280; font-size: 0.9rem; margin-top: 8px; margin-left: 34px;">
                            Публичные коллекции видны другим пользователям
                        </p>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-secondary" onclick="closeCreateModal()">
                        Отмена
                    </button>
                    <button type="submit" class="modal-btn modal-btn-primary">
                        Создать коллекцию
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Модальное окно редактирования -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Редактировать коллекцию</h3>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>
            
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editName" class="form-label">Название коллекции *</label>
                        <input type="text" id="editName" name="name" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editDescription" class="form-label">Описание</label>
                        <textarea id="editDescription" name="description" class="form-textarea"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-checkbox">
                            <input type="checkbox" name="is_public" id="editIsPublic" value="1">
                            <span>Сделать коллекцию публичной</span>
                        </label>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="modal-btn modal-btn-secondary" onclick="closeEditModal()">
                        Отмена
                    </button>
                    <button type="submit" class="modal-btn modal-btn-primary">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Модальное окно импорта -->
    <div class="modal" id="importModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Импорт иероглифов</h3>
                <button class="modal-close" onclick="closeImportModal()">×</button>
            </div>
            
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Выберите коллекцию для импорта</label>
                    <select class="form-input" id="importCollection">
                        <option value="">Выберите коллекцию...</option>
                        @foreach($collections as $collection)
                            <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Импортировать из уровня HSK</label>
                    <select class="form-input" id="importHskLevel">
                        <option value="">Выберите уровень...</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">HSK {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Или выберите иероглифы вручную</label>
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px;">
                        <!-- Здесь будет список иероглифов для выбора -->
                        <p style="color: #6b7280; text-align: center; padding: 20px;">
                            Выберите коллекцию и уровень HSK для отображения иероглифов
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="closeImportModal()">
                    Отмена
                </button>
                <button type="button" class="modal-btn modal-btn-primary" onclick="importCharacters()">
                    Импортировать
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Модальные окна
        function showCreateModal() {
            document.getElementById('createModal').style.display = 'flex';
            document.getElementById('collectionName').focus();
        }
        
        function closeCreateModal() {
            document.getElementById('createModal').style.display = 'none';
            document.getElementById('createForm').reset();
        }
        
        function showEditModal(collectionId, collectionData) {
            const form = document.getElementById('editForm');
            form.action = `/collections/${collectionId}`;
            document.getElementById('editName').value = collectionData.name;
            document.getElementById('editDescription').value = collectionData.description || '';
            document.getElementById('editIsPublic').checked = collectionData.is_public || false;
            document.getElementById('editModal').style.display = 'flex';
        }
        
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        function showImportModal() {
            document.getElementById('importModal').style.display = 'flex';
        }
        
        function closeImportModal() {
            document.getElementById('importModal').style.display = 'none';
        }
        
        // Закрытие модальных окон по клику вне
        window.onclick = function(event) {
            const modals = ['createModal', 'editModal', 'importModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    if (modalId === 'createModal') closeCreateModal();
                    if (modalId === 'editModal') closeEditModal();
                    if (modalId === 'importModal') closeImportModal();
                }
            });
        }
        
        // Редактирование коллекции
        async function editCollection(collectionId) {
            try {
                const response = await fetch(`/collections/${collectionId}`);
                const collection = await response.json();
                showEditModal(collectionId, collection);
            } catch (error) {
                showNotification('Ошибка загрузки данных коллекции', 'error');
            }
        }
        
        // Удаление коллекции с подтверждением
        function confirmDelete(button) {
            if (confirm('Вы уверены, что хотите удалить эту коллекцию? Все иероглифы в ней останутся, но будут удалены из коллекции.')) {
                button.closest('.delete-form').submit();
            }
        }
        
        // Фильтрация и поиск
        function applyFilters() {
            const searchTerm = document.getElementById('searchFilter').value.toLowerCase();
            const sortBy = document.getElementById('sortFilter').value;
            const showWithCards = document.getElementById('showWithCards').checked;
            const showEmpty = document.getElementById('showEmpty').checked;
            const showPublic = document.getElementById('showPublic').checked;
            
            const cards = document.querySelectorAll('.collection-card');
            
            cards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('.collection-description')?.textContent.toLowerCase() || '';
                const characterCount = parseInt(card.querySelector('.collection-stat-value').textContent);
                const isPublic = card.querySelector('.collection-badge') !== null;
                
                // Применяем фильтры
                let shouldShow = true;
                
                if (searchTerm && !name.includes(searchTerm) && !description.includes(searchTerm)) {
                    shouldShow = false;
                }
                
                if (!showWithCards && characterCount > 0) {
                    shouldShow = false;
                }
                
                if (!showEmpty && characterCount === 0) {
                    shouldShow = false;
                }
                
                if (showPublic && !isPublic) {
                    shouldShow = false;
                }
                
                card.style.display = shouldShow ? 'block' : 'none';
            });
            
           
            const grid = document.getElementById('collectionsGrid');
            const sortedCards = Array.from(cards).filter(card => card.style.display !== 'none');
            
            sortedCards.sort((a, b) => {
                const aName = a.querySelector('h3').textContent;
                const bName = b.querySelector('h3').textContent;
                const aCount = parseInt(a.querySelector('.collection-stat-value').textContent);
                const bCount = parseInt(b.querySelector('.collection-stat-value').textContent);
                const aDate = a.querySelector('.collection-meta span').textContent;
                
                switch(sortBy) {
                    case 'name_asc': return aName.localeCompare(bName);
                    case 'name_desc': return bName.localeCompare(aName);
                    case 'size_desc': return bCount - aCount;
                    case 'size_asc': return aCount - bCount;
                    default: return 0; // Для остальных сортировок нужны даты
                }
            });
            
            // Переставляем карточки
            sortedCards.forEach(card => grid.appendChild(card));
            
            updateStats();
        }
        
        // Глобальный поиск
        function searchCollections(event) {
            event.preventDefault();
            const searchTerm = document.getElementById('globalSearch').value.toLowerCase();
            
            const cards = document.querySelectorAll('.collection-card');
            let foundCount = 0;
            
            cards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('.collection-description')?.textContent.toLowerCase() || '';
                
                if (name.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                    foundCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            showNotification(`Найдено ${foundCount} коллекций`, 'info');
            updateStats();
        }
        
        function updateStats() {
            const visibleCards = document.querySelectorAll('.collection-card[style="display: block"]');
            let totalCharacters = 0;
            let learnedCharacters = 0;
            
            visibleCards.forEach(card => {
                const total = parseInt(card.querySelector('.collection-stat-value').textContent);
                const learned = parseInt(card.querySelectorAll('.collection-stat-value')[1]?.textContent) || 0;
                totalCharacters += total;
                learnedCharacters += learned;
            });
            
            document.getElementById('totalCollections').textContent = visibleCards.length;
            document.getElementById('totalCharacters').textContent = totalCharacters;
            document.getElementById('learnedCharacters').textContent = learnedCharacters;
            
            const progress = totalCharacters > 0 ? Math.round((learnedCharacters / totalCharacters) * 100) : 0;
            document.getElementById('progressPercent').textContent = `${progress}%`;
        }
        
        // Импорт иероглифов
        async function importCharacters() {
            const collectionId = document.getElementById('importCollection').value;
            const hskLevel = document.getElementById('importHskLevel').value;
            
            if (!collectionId || !hskLevel) {
                showNotification('Выберите коллекцию и уровень HSK', 'warning');
                return;
            }
            
            try {
                showNotification('Импорт начат...', 'info');
                
                // Здесь должен быть AJAX запрос для импорта
                // await fetch(`/api/collections/${collectionId}/import-hsk/${hskLevel}`, {
                //     method: 'POST',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                //     }
                // });
                
                // Временная заглушка
                setTimeout(() => {
                    showNotification('Иероглифы успешно импортированы!', 'success');
                    closeImportModal();
                }, 1500);
                
            } catch (error) {
                showNotification('Ошибка при импорте', 'error');
            }
        }
        
        
        function showNotification(message, type = 'info') {
            const colors = {
                info: '#3b82f6',
                success: '#10b981',
                warning: '#f59e0b',
                error: '#ef4444'
            };
            
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()">×</button>
            `;
            notification.style.background = colors[type] || colors.info;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
        
       
        document.addEventListener('DOMContentLoaded', function() {
            updateStats();
            
            
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease';
                    bar.style.width = width;
                }, 100);
            });
            
          
            @if(session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif
            
            @if(session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif
        });
    </script>
</body>
</html>