@php
    $characterModel = $character ?? null;
    $audioValue = $value ?? '';
    $previewUrl = $audioValue ? \App\Models\Character::publicAudioUrl($audioValue) : null;
@endphp
<div class="admin-audio-field" data-audio-kind="{{ $kind }}">
    <label for="{{ $inputId }}" class="optional">{{ $label }}</label>
    <div class="admin-audio-field-row">
        <input type="text" id="{{ $inputId }}" name="{{ $inputName }}"
               class="form-control admin-audio-path-input"
               value="{{ $audioValue }}"
               data-text-source="{{ $textSourceId }}"
               data-glyph-source="{{ $glyphSourceId }}"
               @if(!empty($textSourceFallback)) data-text-fallback="{{ $textSourceFallback }}" @endif>
        <button type="button" class="btn-admin-audio-generate"
                data-kind="{{ $kind }}"
                data-input="{{ $inputId }}"
                data-preview="{{ $inputId }}_preview"
                @if($characterModel)
                    data-character-id="{{ $characterModel->id }}"
                    data-url-character="{{ route('admin.characters.audio.character', $characterModel) }}"
                    data-url-example="{{ route('admin.characters.audio.example', $characterModel) }}"
                @else
                    data-url-preview="{{ route('admin.characters.audio.preview') }}"
                @endif>
            Сгенерировать
        </button>
    </div>
    <div class="form-hint">Путь к файлу или нажмите «Сгенерировать» (Edge TTS)</div>
    <div class="admin-audio-preview-wrap" id="{{ $inputId }}_preview_wrap" @if(!$previewUrl) hidden @endif>
        <audio id="{{ $inputId }}_preview" class="admin-audio-preview" controls preload="none"
            @if($previewUrl) src="{{ $previewUrl }}" @endif></audio>
    </div>
    <p class="admin-audio-status" id="{{ $inputId }}_status" aria-live="polite"></p>
</div>
