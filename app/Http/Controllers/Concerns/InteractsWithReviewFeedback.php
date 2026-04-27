<?php

namespace App\Http\Controllers\Concerns;

trait InteractsWithReviewFeedback
{
    /**
     * Короткое сообщение после оценки сложности (SRS).
     * Используется и при обучении, и при повторении.
     */
    protected function getResultMessage(string $result): string
    {
        return match ($result) {
            'again' => 'Запомним и вернёмся к этой карточке позже.',
            'hard' => 'Сложно, но вы справились — так закрепляется материал.',
            'good' => 'Отлично! Хорошее понимание иероглифа.',
            'easy' => 'Прекрасно, вы уверенно знаете этот иероглиф.',
            default => 'Ответ сохранён.',
        };
    }
}
