<div class="admin-page-toolbar">
    <div class="admin-page-toolbar-start">
        @isset($createUrl)
            <a href="{{ $createUrl }}" class="add-new-link admin-toolbar-add">{{ $createLabel ?? 'Добавить' }}</a>
        @endisset
        @isset($toolbarAppend)
            {!! $toolbarAppend !!}
        @endisset
    </div>
    @include('admin.partials.back-dashboard')
</div>
