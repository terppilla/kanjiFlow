<x-app-layout>
    <div class="form-container admin-article-form-page">
        <h1 class="form-title">Редактирование статьи</h1>
        <p class="admin-form-subtitle">Обновите заголовки, контент и фотографии в едином светлом стиле формы.</p>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" class="character-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" id="title" name="title" class="form-control @error('title') error @enderror" value="{{ old('title', $article->title) }}" required>
                @error('title')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="subtitle" class="optional">Подзаголовок</label>
                <input type="text" id="subtitle" name="subtitle" class="form-control @error('subtitle') error @enderror" value="{{ old('subtitle', $article->subtitle) }}">
                @error('subtitle')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="content">Содержание</label>
                <input type="hidden" id="content" name="content" value="{{ old('content', $article->content) }}">
                <div id="editor" class="quill-editor @error('content') error @enderror"></div>
                @error('content')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            @if($article->images->isNotEmpty())
                <div class="form-group">
                    <label class="optional">Текущие фото</label>
                    <div class="admin-article-images-grid">
                        @foreach($article->images as $image)
                            <label class="admin-article-image-card">
                                <img src="{{ Storage::url($image->image_path) }}" alt="article image">
                                <span>{{ $image->caption ?: 'Без подписи' }}</span>
                                <span class="remove-check">
                                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}">
                                    Удалить
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="images" class="optional">Добавить новые фотографии</label>
                <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
                @error('images')<div class="error-message">{{ $message }}</div>@enderror
                @error('images.*')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="optional">Подписи к новым фото</label>
                <div id="captions-list"></div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Обновить статью</button>
                <a href="{{ route('admin.articles.index') }}" class="btn-cancel">Отмена</a>
            </div>
        </form>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link', 'blockquote', 'code-block'],
                    ['clean']
                ]
            }
        });

        const contentInput = document.getElementById('content');
        const initialHtml = contentInput.value;
        if (initialHtml) {
            quill.root.innerHTML = initialHtml;
        }

        document.querySelector('.character-form').addEventListener('submit', () => {
            contentInput.value = quill.root.innerHTML;
        });

        const imagesInput = document.getElementById('images');
        const captionsList = document.getElementById('captions-list');

        imagesInput.addEventListener('change', () => {
            captionsList.innerHTML = '';
            [...imagesInput.files].forEach((file, index) => {
                const wrap = document.createElement('div');
                wrap.className = 'fieldset-group';
                wrap.innerHTML = `
                    <label>Подпись к фото #${index + 1} (${file.name})</label>
                    <input type="text" name="captions[${index}]" class="form-control" />
                `;
                captionsList.appendChild(wrap);
            });
        });
    </script>
</x-app-layout>
