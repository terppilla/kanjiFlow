<x-app-layout>
    <div class="construction-container">
        <h1 class="construction-title">Функция в разработке</h1>
        <div class="construction-message">
            Система коллекций иероглифов находится в разработке. 
            <br>Скоро вы сможете создавать свои коллекции, группировать иероглифы по темам и эффективнее организовывать обучение.
        </div>
        <div class="btn-container">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Вернуться в дашборд</a>
            <a href="{{ route('learning.select-level') }}" class="btn btn-secondary">Начать изучение</a>
        </div>
    </div>
</x-app-layout>