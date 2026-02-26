<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать коллекцию - KanjiFlow</title>
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
        
        .edit-container {
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
        
        .edit-card {
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
        
        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
            border: 2px solid #fecaca;
        }
        
        .btn-danger:hover {
            background: #fecaca;
        }
        
        @media (max-width: 640px) {
            .edit-card {
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
    <div class="edit-container">
        <a href="{{ route('collections.show', $collection) }}" class="back-link">← Назад к коллекции</a>
        
        <div class="edit-card">
            <div class="card-header">
                <h1>Редактировать коллекцию</h1>
                <p>Внесите изменения в вашу коллекцию</p>
            </div>
            
            <form action="{{ route('collections.update', $collection) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name" class="form-label">Название коллекции *</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-input" 
                           required
                           placeholder="Например: Основные иероглифы HSK 1"
                           value="{{ old('name', $collection->name) }}">
                    @error('name')
                        <div style="color: #dc2626; margin-top: 8px; font-size: 0.9rem;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Описание</label>
                    <textarea id="description" 
                              name="description" 
                              class="form-textarea"
                              placeholder="Опишите цель или содержание коллекции...">{{ old('description', $collection->description) }}</textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="is_public" value="1" {{ old('is_public', $collection->is_public) ? 'checked' : '' }}>
                        <span>Сделать коллекцию публичной</span>
                    </label>
                    <p class="form-help">
                        Публичные коллекции видны другим пользователям платформы
                    </p>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('collections.show', $collection) }}" class="btn btn-secondary">
                        Отмена
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Сохранить изменения
                    </button>
                </div>
            </form>
            
            <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid #e5e7eb;">
                <h3 style="color: #dc2626; margin-bottom: 20px;">Опасная зона</h3>
                
                <form action="{{ route('collections.destroy', $collection) }}" method="POST" 
                      onsubmit="return confirm('Вы уверены, что хотите удалить эту коллекцию? Это действие нельзя отменить.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width: 100%;">
                        🗑️ Удалить коллекцию
                    </button>
                    <p style="color: #6b7280; font-size: 0.9rem; margin-top: 10px; text-align: center;">
                        Внимание: это удалит коллекцию, но иероглифы останутся в вашем словаре
                    </p>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Автофокус на поле названия
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name').focus();
        });
    </script>
</body>
</html>