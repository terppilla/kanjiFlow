<?php


namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\UserCharacter;
use Illuminate\Support\Facades\Auth;

class DueCardsList extends Component
{
    use WithPagination;

    // Количество элементов на странице
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $user = Auth::user();

        $dueCards = UserCharacter::where('user_id', $user->id)
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->with('character')
            ->orderBy('next_review_at')
            ->paginate(6);

        $dueCount = UserCharacter::where('user_id', $user->id)
            ->where('next_review_at', '<=', now())
            ->where('is_learned', false)
            ->count();

        return view('livewire.due-cards-list', [
            'dueCards' => $dueCards,
            'dueCount' => $dueCount
        ]);
    }
}


<div>
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

    {{-- Пагинация Livewire — без перезагрузки страницы! --}}
    <div class="mt-6">
        {{ $dueCards->links() }}
    </div>
</div>
?>