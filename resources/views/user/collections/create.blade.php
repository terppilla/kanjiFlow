<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать коллекцию - KanjiFlow</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .create-container {
            width: 100%;
            max-width: 600px;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            opacity: 0.9;
        }
        
        .back-link:hover {
            opacity: 1;
            text-decoration: underline;
        }
        
        .create-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .card-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .card-header h1 {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        .card-header p {
            color: #6b7280;
            font-size: 1.1rem;
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
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            margin-bottom: 5px;
        }
        
        .form-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #d1d5db;
        }
        
        .form-help {
            color: #6b7280;
            font-size: 0.9rem;
            margin-left: 32px;
            margin-top: 5px;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 40px;
        }
        
        .btn {
            flex: 1;
            padding: 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            text-align: center;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #f3f4f6;
            color: #4b5563;
            border: 2px solid #e5e7eb;
        }
        
        .btn-secondary:hover {
            background: #e5e7eb;
        }
        
        .tips-section {
            background: #f9fafb;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
            border-left: 4px solid #667eea;
        }
        
        .tips-section h3 {
            color: #1f2937;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        
        .tips-list {
            list-style: none;
        }
        
        .tips-list li {
            padding: 8px 0;
            color: #6b7280;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        
        .tips-list li:before {
            content: "💡";
            font-size: 1.1rem;
        }
        
        @media (max-width: 640px) {
            .create-card {
                padding: 30px 25px;
            }
            
            .card-header h1 {
                font-size: 2rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="create-container">
        <a href="{{ route('collections.index') }}" class="back-link">← Назад к коллекциям</a>
        
        <div class="create-card">
            <div class="card-header">
                <h1>Создать новую коллекцию</h1>
                <p>Организуйте иероглифы для эффективного обучения</p>
            </div>
            
            <form action="{{ route('collections.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name" class="form-label">Название коллекции *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-input" 
                           required
                           placeholder="Например: Основные иероглифы HSK 1"
                           value="{{ old('name') }}">
                    @error('name')
                        <div style="color: #dc2626; margin-top: 8px; font-size: 0.9rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Описание (необязательно)</label>
                    <textarea id="description" 
                              name="description" 
                              class="form-textarea"
                              placeholder="Опишите цель или содержание коллекции...">{{ old('description') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                        <span>Сделать коллекцию публичной</span>
                    </label>
                    <p class="form-help">
                        Публичные коллекции видны другим пользователям платформы
                    </p>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('collections.index') }}" class="btn btn-secondary">
                        Отмена
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Создать коллекцию
                    </button>
                </div>
            </form>
            
            <div class="tips-section">
                <h3>💡 Советы по созданию коллекций:</h3>
                <ul class="tips-list">
                    <li>Назовите коллекцию так, чтобы было понятно ее содержание</li>
                    <li>Создавайте коллекции по темам (HSK уровни, радикалы, темы)</li>
                    <li>Публичные коллекции можно делиться с другими пользователями</li>
                    <li>Позже вы сможете добавлять и удалять иероглифы</li>
                </ul>
            </div>
        </div>
    </div>
    
    <script>
        // Автофокус на поле названия
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name').focus();
        });
        
        // Показ уведомлений об ошибках
        @if($errors->any())
            setTimeout(() => {
                alert('Пожалуйста, исправьте ошибки в форме');
            }, 100);
        @endif
    </script>
</body>
</html>