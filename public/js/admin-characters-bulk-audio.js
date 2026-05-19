(function () {
    var btn = document.getElementById('bulkAudioBtn');
    var status = document.getElementById('bulkAudioStatus');
    if (!btn || !status) return;

    function csrf() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.content : '';
    }

    btn.addEventListener('click', async function () {
        if (!confirm('Сгенерировать отсутствующее аудио? Обработка идёт порциями.')) return;

        btn.disabled = true;
        btn.classList.add('is-busy');
        var totalChar = 0;
        var totalEx = 0;
        var rounds = 0;

        try {
            while (true) {
                rounds++;
                status.textContent = 'Генерация, порция ' + rounds + '…';
                status.classList.remove('is-error', 'is-success');

                var res = await fetch(btn.dataset.url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf(),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                var data = await res.json().catch(function () { return {}; });
                if (!res.ok) throw new Error(data.message || 'Ошибка сервера');

                totalChar += data.character || 0;
                totalEx += data.example || 0;

                if (!data.remaining || data.remaining < 1) {
                    status.textContent = 'Готово. Иероглифов: ' + totalChar + ', примеров: ' + totalEx + '.';
                    status.classList.add('is-success');
                    break;
                }

                status.textContent = 'Иероглифов: ' + totalChar + ', примеров: ' + totalEx + '. Осталось: ' + data.remaining + '…';
            }
        } catch (e) {
            status.textContent = e.message || 'Ошибка генерации';
            status.classList.add('is-error');
        } finally {
            btn.disabled = false;
            btn.classList.remove('is-busy');
        }
    });
})();
