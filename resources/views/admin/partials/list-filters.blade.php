@php
    /** @var array<int, array<string, mixed>> $fields */
    $fields = $fields ?? [];
@endphp
<form method="GET" action="{{ $action }}" class="admin-list-filters">
    <div class="admin-list-filters-grid">
        @foreach($fields as $field)
            <div class="admin-list-filters-field admin-list-filters-field--{{ $field['type'] }}">
                @if(!empty($field['label']))
                    <label for="filter_{{ $field['name'] }}">{{ $field['label'] }}</label>
                @endif
                @if(($field['type'] ?? '') === 'search')
                    <input type="search" id="filter_{{ $field['name'] }}" name="{{ $field['name'] }}"
                        value="{{ $field['value'] ?? '' }}" placeholder="{{ $field['placeholder'] ?? 'Поиск…' }}"
                        class="admin-list-filters-input" autocomplete="off">
                @elseif(($field['type'] ?? '') === 'select')
                    <select id="filter_{{ $field['name'] }}" name="{{ $field['name'] }}" class="admin-list-filters-select">
                        @foreach($field['options'] ?? [] as $optValue => $optLabel)
                            <option value="{{ $optValue }}" @selected((string) ($field['value'] ?? '') === (string) $optValue)>
                                {{ $optLabel }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        @endforeach
        <div class="admin-list-filters-actions">
            <button type="submit" class="admin-list-filters-submit">Применить</button>
            @if(request()->except('page'))
                <a href="{{ $action }}" class="admin-list-filters-reset">Сбросить</a>
            @endif
        </div>
    </div>
</form>
