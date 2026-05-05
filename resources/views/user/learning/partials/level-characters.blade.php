<div class="learn-all-row">
    @if(isset($collection) && $collection)
        <a href="{{ route('learning.collection.show', [$collection, $characters->first()]) }}" class="learn-all-btn">
            Начать изучение первого иероглифа
        </a>
    @else
        <a href="{{ route('learning.show', $characters->first() ?? 1) }}" class="learn-all-btn">
            Начать изучение первого иероглифа
        </a>
    @endif
</div>

<div class="characters-grid" id="charactersGrid">
    @foreach($characters as $character)
        @php
            $isLearned = in_array($character->id, $learnedCharacterIds);
        @endphp
        <div
           class="character-card {{ $isLearned ? 'learned' : '' }}"
           data-pinyin="{{ strtolower($character->pinyin) }}"
           data-meaning="{{ strtolower($character->meaning) }}">
            <div class="character-char">{{ $character->character }}</div>
            <div class="character-pinyin">{{ $character->pinyin }}</div>
            <div class="character-meaning">{{ $character->meaning }}</div>
            <button type="button" class="audio-btn" id="audioExampleBtn" 
            style="{{ $character->audio_example ? '' : 'display:none' }}" 
            data-audio-url="{{ \App\Models\Character::publicAudioUrl($character->audio_example) ?? '' }}">
            <img src="{{ asset('img/voice-icon.svg') }}" alt="Произношение" class="audio-icon">
        </button>
        </div>
    @endforeach
</div>

@if($characters->hasPages())
    <div class="pagination" data-level-pagination>
        {{ $characters->links('vendor.pagination.my-pagination') }}
    </div>
@endif
