<form action="{{ route('admin.builtin-collections.sync-all') }}" method="POST" class="admin-inline-form"
    onsubmit="return confirm('Синхронизировать встроенные подборки у всех пользователей?');">
    @csrf
    <button type="submit" class="btn-sync-all">Обновить у всех пользователей</button>
</form>
