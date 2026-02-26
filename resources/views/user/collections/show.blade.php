<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $collection->name }} - KanjiFlow</title>
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
        
        .collection-show-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Шапка коллекции */
        .collection-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .header-background {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.1"><text x="50%" y="50%" font-family="Noto Serif SC" font-size="24" text-anchor="middle" dominant-baseline="middle">書</text></svg>');
            background-size: 200px;
            opacity: 0.1;
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }
        
        .collection-title h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            font-weight: 800;
        }
        
        .collection-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .collection-badge {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .header-actions {
            display: flex;
            gap: 12px;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: white;
            color: #667eea;
        }
        
        .btn-primary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        .btn-secondary:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .btn-back {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .btn-back:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .collection-description {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.9;
            max-width: 800px;
            margin-bottom: 30px;
        }
        
        /* Статистика */
        .collection-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .stat-value {
            display: block;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        /* Основной контент */
        .collection-main {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }
        
        /* Левая панель */
        .collection-sidebar {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .sidebar-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
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
        
        /* Прогресс изучения */
        .progress-section {
            margin-bottom: 20px;
        }
        
        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.95rem;
            color: #6b7280;
        }
        
        .progress-bar {
            height: 10px;
            background: #e5e7eb;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
            border-radius: 5px;
            transition: width 1s ease;
        }
        
        .progress-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            text-align: center;
        }
        
        .progress-detail {
            padding: 15px;
            background: #f9fafb;
            border-radius: 10px;
        }
        
        .detail-value {
            display: block;
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }
        
        .detail-label {
            font-size: 0.85rem;
            color: #6b7280;
        }
        
        /* Быстрые действия */
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            text-decoration: none;
            color: #1f2937;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .quick-action-btn:hover {
            background: white;
            border-color: #667eea;
            transform: translateX(5px);
        }
        
        .action-icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        /* Правая часть - иероглифы */
        .collection-content {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        /* Панель управления иероглифами */
        .characters-controls {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .controls-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .controls-title {
            font-size: 1.4rem;
            color: #1f2937;
            font-weight: 600;
        }
        
        .controls-actions {
            display: flex;
            gap: 12px;
        }
        
        /* Форма добавления иероглифа */
        .add-character-form {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .form-input {
            flex: 1;
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .form-select {
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            background: white;
            min-width: 200px;
        }
        
        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }
        
        /* Сетка иероглифов */
        .characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }
        
        /* Карточка иероглифа */
        .character-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            position: relative;
            border: 2px solid transparent;
        }
        
        .character-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border-color: #667eea;
        }
        
        .character-card.learned {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-color: #10b981;
        }
        
        .character-char {
            font-family: 'Noto Serif SC', serif;
            font-size: 3.5rem;
            color: #1f2937;
            margin-bottom: 15px;
            line-height: 1;
        }
        
        .character-info {
            margin-bottom: 15px;
        }
        
        .character-pinyin {
            color: #667eea;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        
        .character-meaning {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.4;
            min-height: 2.8em;
        }
        
        .character-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #9ca3af;
            margin-bottom: 15px;
            padding-top: 15px;
            border-top: 1px solid #f3f4f6;
        }
        
        .character-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .status-learned {
            background: #10b981;
            color: white;
        }
        
        .status-new {
            background: #e5e7eb;
            color: #6b7280;
        }
        
        .character-actions {
            display: flex;
            gap: 8px;
        }
        
        .char-action-btn {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            text-align: center;
            transition: all 0.3s;
        }
        
        .action-learn {
            background: #667eea;
            color: white;
        }
        
        .action-learn:hover {
            background: #5a6fd8;
        }
        
        .action-remove {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
        }
        
        .action-remove:hover {
            background: #fee2e2;
        }
        
        .remove-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .character-card:hover .remove-btn {
            opacity: 1;
        }
        
        /* Пустое состояние */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 40px;
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
        
        /* Модальные окна */
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
            .collection-main {
                grid-template-columns: 1fr;
            }
            
            .collection-sidebar {
                order: 2;
            }
        }
        
        @media (max-width: 768px) {
            .collection-header {
                padding: 30px 25px;
            }
            
            .header-top {
                flex-direction: column;
                gap: 20px;
            }
            
            .header-actions {
                width: 100%;
                justify-content: stretch;
            }
            
            .btn {
                flex: 1;
                justify-content: center;
            }
            
            .collection-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .characters-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
            
            .form-row {
                flex-direction: column;
            }
            
            .controls-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .controls-actions {
                justify-content: stretch;
            }
            
            .controls-actions .btn {
                flex: 1;
            }
        }
        
        @media (max-width: 480px) {
            .collection-stats {
                grid-template-columns: 1fr;
            }
            
            .characters-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .progress-details {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="collection-show-container">
        <!-- Шапка коллекции -->
        <div class="collection-header">
            <div class="header-background"></div>
            <div class="header-content">
                <div class="header-top">
                    <div class="collection-title">
                        <h1>{{ $collection->name }}</h1>
                        <div class="collection-meta">
                            <span>Создана {{ $collection->created_at->diffForHumans() }}</span>
                            <span>Обновлена {{ $collection->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <div class="header-actions">
                        <a href="{{ route('collections.index') }}" class="btn btn-back">
                            ← Все коллекции
                        </a>
                        <a href="{{ route('collections.review', $collection) }}" class="btn btn-primary">
                             Повторить коллекцию
                        </a>
                        <a href="{{ route('collections.edit', $collection) }}" class="btn btn-secondary">
                          Редактировать
                      </a>
                    </div>
                </div>
                
                @if($collection->description)
                    <div class="collection-description">
                        {{ $collection->description }}
                    </div>
                @endif
                
             
                <div class="collection-stats">
                    <div class="stat-card">
                        <span class="stat-value" id="totalCharacters">{{ $collection->characters->count() }}</span>
                        <span class="stat-label">Иероглифов в коллекции</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-value" id="learnedCharacters">0</span>
                        <span class="stat-label">Выучено</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-value" id="dueCharacters">0</span>
                        <span class="stat-label">Для повторения</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-value" id="progressPercent">0%</span>
                        <span class="stat-label">Общий прогресс</span>
                    </div>
                </div>
            </div>
        </div>
        
       
        <div class="collection-main">
            
            <aside class="collection-sidebar">
             
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Прогресс изучения</h3>
                    
                    <div class="progress-section">
                        <div class="progress-header">
                            <span>Общий прогресс</span>
                            <span id="progressText">0%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" id="progressBar" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <div class="progress-details">
                        <div class="progress-detail">
                            <span class="detail-value" id="detailNew">0</span>
                            <span class="detail-label">Новые</span>
                        </div>
                        <div class="progress-detail">
                            <span class="detail-value" id="detailLearning">0</span>
                            <span class="detail-label">Изучаются</span>
                        </div>
                        <div class="progress-detail">
                            <span class="detail-value" id="detailReview">0</span>
                            <span class="detail-label">Для повторения</span>
                        </div>
                        <div class="progress-detail">
                            <span class="detail-value" id="detailLearned">0</span>
                            <span class="detail-label">Выучено</span>
                        </div>
                    </div>
                </div>
                
           
                <div class="sidebar-card">
                    <h3 class="sidebar-title"> Быстрые действия</h3>
                    
                    <div class="quick-actions">
                        <a href="{{ route('learning.show', $collection->characters->first() ?? 1) }}" class="quick-action-btn">
                            <span class="action-icon"></span>
                            <span>Начать изучение</span>
                        </a>
                        <a href="{{ route('review.show') }}" class="quick-action-btn">
                            <span class="action-icon"></span>
                            <span>Повторить все</span>
                        </a>
                        <button class="quick-action-btn" onclick="showAddCharacterModal()">
                            <span class="action-icon"></span>
                            <span>Добавить иероглиф</span>
                        </button>
                        <button class="quick-action-btn" onclick="showImportModal()">
                            <span class="action-icon"></span>
                            <span>Импорт из HSK</span>
                        </button>
                        <a href="{{ route('dashboard') }}" class="quick-action-btn">
                            <span class="action-icon"></span>
                            <span>В дашборд</span>
                        </a>
                    </div>
                </div>
                
              
                <div class="sidebar-card">
                    <h3 class="sidebar-title">ℹ️ Информация</h3>
                    
                    <div style="color: #6b7280; line-height: 1.6;">
                        <p style="margin-bottom: 15px;">
                            Эта коллекция содержит иероглифы, которые вы добавили для изучения.
                        </p>
                        <p style="margin-bottom: 10px;">
                            <strong>Совет:</strong> Регулярно повторяйте иероглифы из коллекции
                            для лучшего запоминания.
                        </p>
                        <p>
                            <strong>Статус:</strong>
                            @if($collection->is_public)
                                <span style="color: #10b981;">Публичная</span> - видна другим пользователям
                            @else
                                <span style="color: #6b7280;">Приватная</span> - только для вас
                            @endif
                        </p>
                    </div>
                </div>
            </aside>
            
          
            <main class="collection-content">
               
                <div class="characters-controls">
                    <div class="controls-header">
                        <div class="controls-title">
                            Иероглифы в коллекции 
                            <span style="color: #667eea;">({{ $collection->characters->count() }})</span>
                        </div>
                        
                        <div class="controls-actions">
                            <button class="btn btn-primary" onclick="showAddCharacterModal()">
                                Добавить иероглиф
                            </button>
                            <button class="btn btn-secondary" onclick="showBulkActions()">
                                Групповые действия
                            </button>
                        </div>
                    </div>
                    
                 
                    <div class="add-character-form" id="addCharacterForm" style="display: none;">
                        <form action="{{ route('collections.add-character', $collection) }}" method="POST" id="addCharacterFormElement">
                            @csrf
                            <div class="form-row">
                                <select name="character_id" class="form-select" required>
                                    <option value="">Выберите иероглиф...</option>
                                    @foreach($allCharacters as $char)
                                        @if(!$collection->characters->contains($char))
                                            <option value="{{ $char->id }}">
                                                {{ $char->character }} - {{ $char->pinyin }} ({{ $char->meaning }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-actions">
                                <button type="button" class="modal-btn modal-btn-secondary" onclick="hideAddCharacterForm()">
                                    Отмена
                                </button>
                                <button type="submit" class="modal-btn modal-btn-primary">
                                    Добавить
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Поиск и фильтры -->
                    <div style="margin-top: 20px;">
                        <div class="form-row">
                            <input type="text" 
                                   class="form-input" 
                                   placeholder="Поиск по иероглифу, пиньиню или значению..."
                                   id="characterSearch"
                                   onkeyup="filterCharacters()">
                            <select class="form-select" id="characterFilter" onchange="filterCharacters()">
                                <option value="all">Все иероглифы</option>
                                <option value="learned">Только выученные</option>
                                <option value="new">Только новые</option>
                                <option value="due">Для повторения</option>
                            </select>
                            <select class="form-select" id="hskFilter" onchange="filterCharacters()">
                                <option value="all">Все уровни HSK</option>
                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">HSK {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Сетка иероглифов -->
                <div class="characters-grid" id="charactersGrid">
                    @if($collection->characters->count() > 0)
                        @foreach($collection->characters as $character)
                            @php
                                // Здесь нужно добавить логику определения статуса иероглифа
                                $isLearned = false; // Заглушка - добавьте свою логику
                                $status = $isLearned ? 'learned' : 'new';
                                $statusText = $isLearned ? 'Выучен' : 'Новый';
                            @endphp
                            
                            <div class="character-card {{ $isLearned ? 'learned' : '' }}" 
                                 data-character-id="{{ $character->id }}"
                                 data-pinyin="{{ strtolower($character->pinyin) }}"
                                 data-meaning="{{ strtolower($character->meaning) }}"
                                 data-hsk="{{ $character->hsk_level }}"
                                 data-status="{{ $status }}">
                                
                                <button class="remove-btn" 
                                        onclick="removeCharacter({{ $character->id }})"
                                        title="Удалить из коллекции">
                                    ×
                                </button>
                                
                                <div class="character-char">{{ $character->character }}</div>
                                
                                <div class="character-info">
                                    <div class="character-pinyin">{{ $character->pinyin }}</div>
                                    <div class="character-meaning">{{ $character->meaning }}</div>
                                </div>
                                
                                <div class="character-meta">
                                    <span>HSK {{ $character->hsk_level }}</span>
                                    <span>#{{ $character->id }}</span>
                                </div>
                                
                                <div class="character-status {{ $isLearned ? 'status-learned' : 'status-new' }}">
                                    {{ $statusText }}
                                </div>
                                
                                <div class="character-actions">
                                    <a href="{{ route('learning.show', $character) }}" class="char-action-btn action-learn">
                                        Изучить
                                    </a>
                                    <form action="{{ route('collections.remove-character', ['collection' => $collection, 'character' => $character]) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="char-action-btn action-remove">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Пустое состояние -->
                        <div class="empty-state">
                            <div class="empty-icon">📖</div>
                            <h2 class="empty-title">Коллекция пуста</h2>
                            <p class="empty-description">
                                В этой коллекции пока нет иероглифов. Добавьте иероглифы,
                                чтобы начать изучение.
                            </p>
                            <button class="btn btn-primary" onclick="showAddCharacterModal()" 
                                    style="padding: 16px 40px; font-size: 1.1rem;">
                                Добавить первый иероглиф
                            </button>
                            <div style="margin-top: 20px;">
                                <button class="btn btn-secondary" onclick="showImportModal()">
                                    Импортировать из HSK
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
    
    <!-- Модальное окно редактирования коллекции -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Редактировать коллекцию</h3>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>
            
            <form action="{{ route('collections.update', $collection) }}" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="editName" style="display: block; color: #1f2937; margin-bottom: 10px; font-weight: 600;">
                            Название коллекции *
                        </label>
                        <input type="text" id="editName" name="name" class="form-input" required 
                               value="{{ $collection->name }}">
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label for="editDescription" style="display: block; color: #1f2937; margin-bottom: 10px; font-weight: 600;">
                            Описание
                        </label>
                        <textarea id="editDescription" name="description" class="form-input" 
                                  style="min-height: 120px; resize: vertical;">{{ $collection->description }}</textarea>
                    </div>
                    
                        <p style="color: #6b7280; font-size: 0.9rem; margin-top: 8px; margin-left: 34px;">
                            Публичные коллекции видны другим пользователям
                        </p>
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
    
   
    <div class="modal" id="importModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Импорт иероглифов из HSK</h3>
                <button class="modal-close" onclick="closeImportModal()">×</button>
            </div>
            
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; color: #1f2937; margin-bottom: 10px; font-weight: 600;">
                        Выберите уровень HSK для импорта
                    </label>
                    <select class="form-input" id="importHskLevel">
                        <option value="">Выберите уровень...</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">HSK {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: block; color: #1f2937; margin-bottom: 10px; font-weight: 600;">
                        Количество иероглифов
                    </label>
                    <select class="form-input" id="importLimit">
                        <option value="10">10 иероглифов</option>
                        <option value="20">20 иероглифов</option>
                        <option value="50">50 иероглифов</option>
                        <option value="all">Все иероглифы уровня</option>
                    </select>
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                        <input type="checkbox" id="importSkipLearned" checked>
                        <span>Пропускать уже изученные иероглифы</span>
                    </label>
                </div>
                
                <div id="importPreview" style="display: none;">
                    <h4 style="margin-bottom: 15px; color: #1f2937;">Будут добавлены:</h4>
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 8px; padding: 15px; background: #f9fafb;">
                        <div id="previewList"></div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="closeImportModal()">
                    Отмена
                </button>
                <button type="button" class="modal-btn modal-btn-primary" onclick="startImport()" id="importBtn">
                    Импортировать
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Глобальные переменные
        let collectionId = {{ $collection->id }};
        let csrfToken = '{{ csrf_token() }}';
        
        // Инициализация
        document.addEventListener('DOMContentLoaded', function() {
            updateProgress();
            animateProgressBars();
            
            // Обработка сообщений из сессии
            @if(session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif
            
            @if(session('error'))
                showNotification('{{ session('error') }}', 'error');
            @endif
        });
        
        // Обновление прогресса
        function updateProgress() {
            const total = {{ $collection->characters->count() }};
            const learned = document.querySelectorAll('.character-card.learned').length;
            const progress = total > 0 ? Math.round((learned / total) * 100) : 0;
            
            // Обновляем статистику
            document.getElementById('learnedCharacters').textContent = learned;
            document.getElementById('dueCharacters').textContent = total - learned;
            document.getElementById('progressPercent').textContent = `${progress}%`;
            
            // Обновляем прогресс-бар
            document.getElementById('progressText').textContent = `${progress}%`;
            document.getElementById('progressBar').style.width = `${progress}%`;
            
            // Обновляем детали
            document.getElementById('detailNew').textContent = total - learned;
            document.getElementById('detailLearning').textContent = Math.floor((total - learned) / 2);
            document.getElementById('detailReview').textContent = Math.floor((total - learned) / 4);
            document.getElementById('detailLearned').textContent = learned;
        }
        
        // Анимация прогресс-баров
        function animateProgressBars() {
            const bars = document.querySelectorAll('.progress-fill');
            bars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease';
                    bar.style.width = width;
                }, 100);
            });
        }
        
        // Показать/скрыть форму добавления иероглифа
        function showAddCharacterForm() {
            document.getElementById('addCharacterForm').style.display = 'block';
            document.querySelector('select[name="character_id"]').focus();
        }
        
        function hideAddCharacterForm() {
            document.getElementById('addCharacterForm').style.display = 'none';
        }
        
        
        function showEditModal() {
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
        
      
        window.onclick = function(event) {
            const modals = ['editModal', 'importModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    if (modalId === 'editModal') closeEditModal();
                    if (modalId === 'importModal') closeImportModal();
                }
            });
        }
        
      
        function filterCharacters() {
            const searchTerm = document.getElementById('characterSearch').value.toLowerCase();
            const filterBy = document.getElementById('characterFilter').value;
            const hskLevel = document.getElementById('hskFilter').value;
            
            const cards = document.querySelectorAll('.character-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const pinyin = card.dataset.pinyin;
                const meaning = card.dataset.meaning;
                const hsk = card.dataset.hsk;
                const status = card.dataset.status;
                
                let shouldShow = true;
                
               
                if (searchTerm && !pinyin.includes(searchTerm) && !meaning.includes(searchTerm)) {
                    shouldShow = false;
                }
                
                if (filterBy !== 'all' && filterBy !== status) {
                    shouldShow = false;
                }
                
                
                if (hskLevel !== 'all' && hskLevel !== hsk) {
                    shouldShow = false;
                }
                
                card.style.display = shouldShow ? 'block' : 'none';
                if (shouldShow) visibleCount++;
            });
            
           
            const grid = document.getElementById('charactersGrid');
            const emptyState = grid.querySelector('.empty-state');
            
            if (visibleCount === 0 && !emptyState) {
                grid.innerHTML = `
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <div class="empty-icon">🔍</div>
                        <h2 class="empty-title">Иероглифы не найдены</h2>
                        <p class="empty-description">
                            Попробуйте изменить параметры поиска или фильтры.
                        </p>
                        <button class="btn btn-primary" onclick="resetFilters()">
                            Сбросить фильтры
                        </button>
                    </div>
                `;
            } else if (visibleCount > 0 && emptyState && emptyState.classList.contains('empty-state')) {
                emptyState.remove();
            }
        }
        
      
        function resetFilters() {
            document.getElementById('characterSearch').value = '';
            document.getElementById('characterFilter').value = 'all';
            document.getElementById('hskFilter').value = 'all';
            filterCharacters();
        }
        
     
        function removeCharacter(characterId) {
            if (confirm('Удалить этот иероглиф из коллекции?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/collections/${collectionId}/characters/${characterId}`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
        
      
        function showBulkActions() {
         
            showNotification('Функция групповых действий в разработке', 'info');
        }
        
      
        async function startImport() {
            const hskLevel = document.getElementById('importHskLevel').value;
            const limit = document.getElementById('importLimit').value;
            const skipLearned = document.getElementById('importSkipLearned').checked;
            
            if (!hskLevel) {
                showNotification('Выберите уровень HSK', 'warning');
                return;
            }
            
            const importBtn = document.getElementById('importBtn');
            importBtn.disabled = true;
            importBtn.textContent = 'Импорт...';
            
            try {
                const response = await fetch(`/api/collections/${collectionId}/import-hsk`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        hsk_level: hskLevel,
                        limit: limit === 'all' ? null : parseInt(limit),
                        skip_learned: skipLearned
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification(`Импортировано ${data.count} иероглифов`, 'success');
                    closeImportModal();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification(data.message || 'Ошибка импорта', 'error');
                }
            } catch (error) {
                showNotification('Ошибка при импорте', 'error');
            } finally {
                importBtn.disabled = false;
                importBtn.textContent = 'Импортировать';
            }
        }
        
       
        document.getElementById('importHskLevel').addEventListener('change', async function() {
            const hskLevel = this.value;
            const preview = document.getElementById('importPreview');
            const previewList = document.getElementById('previewList');
            
            if (!hskLevel) {
                preview.style.display = 'none';
                return;
            }
            
            previewList.innerHTML = '<div style="text-align: center; padding: 20px; color: #6b7280;">Загрузка...</div>';
            preview.style.display = 'block';
            
            try {
                const response = await fetch(`/api/hsk/${hskLevel}/characters?limit=5`);
                const data = await response.json();
                
                if (data.success) {
                    previewList.innerHTML = data.characters.map(char => `
                        <div style="display: flex; align-items: center; gap: 10px; padding: 10px; border-bottom: 1px solid #e5e7eb;">
                            <span style="font-family: \'Noto Serif SC\', serif; font-size: 1.5rem;">${char.character}</span>
                            <span style="color: #667eea;">${char.pinyin}</span>
                            <span style="color: #6b7280; font-size: 0.9rem;">${char.meaning}</span>
                        </div>
                    `).join('');
                }
            } catch (error) {
                previewList.innerHTML = '<div style="text-align: center; padding: 20px; color: #dc2626;">Ошибка загрузки</div>';
            }
        });
        
        
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
    </script>
</body>
</html>