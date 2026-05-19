@php
    $earnedAt = $earnedAtByAchievementId[$achievement->id] ?? null;
    $isEarned = $earnedAt !== null;
@endphp
<article class="achievement-card {{ $isEarned ? 'earned' : 'locked' }}">
    <div class="achievement-card-top">
        <span class="achievement-icon" aria-hidden="true">{{ $achievement->icon }}</span>
        <div class="achievement-body">
            <div class="achievement-name">{{ $achievement->name }}</div>
            <div class="achievement-desc">{{ $achievement->description }}</div>
        </div>
    </div>
    @if($isEarned)
        <div class="achievement-date">
            Получено {{ \Illuminate\Support\Carbon::parse($earnedAt)->format('d.m.Y') }}
        </div>
    @else
        <div class="achievement-date achievement-date--pending">Ещё не получено</div>
    @endif
</article>
