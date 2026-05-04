<section class="profile-section">
    <header class="profile-section-header">
        <h2 class="profile-section-title">Удаление аккаунта</h2>
        <p class="profile-section-desc">
            Будут безвозвратно удалены все данные: прогресс, коллекции и настройки. Перед удалением сохраните то, что может понадобиться.
        </p>
    </header>

    <button
        type="button"
        class="btn profile-btn profile-btn--danger-outline"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Удалить аккаунт</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="profile-modal-form">
            @csrf
            @method('delete')

            <h2 class="profile-modal-title">Удалить аккаунт?</h2>

            <p class="profile-modal-text">
                Это действие нельзя отменить. Введите пароль для подтверждения.
            </p>

            <div class="form-group profile-form-group">
                <label for="delete_account_password" class="form-label">Пароль</label>
                <input
                    id="delete_account_password"
                    name="password"
                    type="password"
                    class="form-control @error('password', 'userDeletion') error @enderror"
                    placeholder="Текущий пароль"
                    autocomplete="current-password"
                >
                @error('password', 'userDeletion')
                    <p class="profile-field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="profile-modal-actions">
                <button type="button" class="btn btn-secondary profile-btn" x-on:click="$dispatch('close')">
                    Отмена
                </button>
                <button type="submit" class="btn profile-btn profile-btn--danger-solid">
                    Удалить навсегда
                </button>
            </div>
        </form>
    </x-modal>
</section>
