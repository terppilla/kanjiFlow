<x-app-layout>
    <style>
        /* Переменные цветов в стиле сайта */
        :root {
            --color-primary: #C1121F;
            --color-dark-red: #7A1414;
            --color-gold: #D69B64;
            --color-white-gold: #F3CAA5;
            --color-calm-blue: #1F2933;
            --color-dark-blue: #0F172A;
            --color-gray: #C0C0C0;
            --color-success: #10b981;
            --color-light-bg: #f8f9fa;
            --color-white: #ffffff;
            --color-bg: #f5f7fa;
        }

        /* Основные стили */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--color-bg);
            color: var(--color-calm-blue);
        }

        /* Контейнер */
        .learning-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }

        /* Шапка */
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(214, 155, 100, 0.2);
            margin-bottom: 2rem;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--color-dark-blue);
        }

        .btn-back {
            padding: 0.5rem 1rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid rgba(214, 155, 100, 0.3);
            font-size: 0.9rem;
        }

        .btn-back:hover {
            background: var(--color-gold);
            color: white;
            transform: translateY(-1px);
        }

        /* Навигация HSK */
        .hsk-navigation {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 1px solid rgba(214, 155, 100, 0.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .hsk-levels {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .hsk-level {
            padding: 0.5rem 1rem;
            background: rgba(214, 155, 100, 0.1);
            color: var(--color-calm-blue);
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid rgba(214, 155, 100, 0.2);
            font-size: 0.9rem;
        }

        .hsk-level:hover {
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            border-color: var(--color-gold);
            transform: translateY(-1px);
        }

        .hsk-level.active {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .hsk-progress {
            background: rgba(243, 202, 165, 0.05);
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid rgba(214, 155, 100, 0.2);
        }

        .progress-text {
            display: block;
            margin-bottom: 0.75rem;
            color: var(--color-calm-blue);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .progress-bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary), var(--color-gold));
            border-radius: 4px;
            transition: width 0.6s ease;
        }

        /* Контейнер карточки */
        .card-container {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            border: 1px solid rgba(214, 155, 100, 0.15);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(214, 155, 100, 0.1);
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card-title-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-dark-blue);
            margin-bottom: 0.25rem;
        }

        .card-subtitle {
            color: var(--color-gray);
            font-size: 0.9rem;
        }

        /* Выбор режима */
        .mode-selector {
            display: flex;
            gap: 0.5rem;
        }

        .mode-btn {
            padding: 0.75rem 1rem;
            background: white;
            border: 2px solid rgba(214, 155, 100, 0.2);
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            color: var(--color-calm-blue);
        }

        .mode-btn:hover {
            border-color: var(--color-gold);
            transform: translateY(-1px);
        }

        .mode-btn.active {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .mode-icon {
            font-size: 1.1rem;
        }

        .mode-label {
            font-weight: 500;
        }

        /* Карточка иероглифа */
        .character-card {
            margin-bottom: 1.5rem;
        }

        .character-display {
            text-align: center;
            padding: 2rem;
            background: rgba(243, 202, 165, 0.05);
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: 1px dashed rgba(214, 155, 100, 0.2);
        }

        .character-char {
            font-family: 'Noto Serif SC', serif;
            font-size: 5rem;
            color: var(--color-dark-red);
            margin-bottom: 1rem;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .character-audio {
            margin-top: 0.5rem;
        }

        .audio-btn {
            padding: 0.75rem 1.5rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid rgba(214, 155, 100, 0.3);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .audio-btn:hover {
            background: var(--color-gold);
            color: white;
            transform: translateY(-1px);
        }

        .character-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .detail-row {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid rgba(214, 155, 100, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-label {
            color: var(--color-gray);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .pinyin {
            color: var(--color-primary);
            font-style: italic;
        }

        .hsk-level {
            color: var(--color-gold);
        }

        /* Пример использования */
        .example-section {
            background: rgba(31, 41, 51, 0.03);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 1.5rem 0;
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .section-title {
            font-weight: 600;
            color: var(--color-dark-blue);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .example-content {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .example-hanzi {
            font-size: 1.5rem;
            color: var(--color-dark-red);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .example-pinyin {
            color: var(--color-primary);
            font-style: italic;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .example-translation {
            color: var(--color-calm-blue);
            line-height: 1.5;
            padding-top: 0.5rem;
            border-top: 1px solid rgba(214, 155, 100, 0.1);
            font-size: 0.95rem;
        }

        .example-audio {
            margin-top: 1rem;
        }

        /* Разделы ответов */
        .answer-section {
            margin: 2rem 0;
        }

        .answer-mode {
            display: none;
        }

        .answer-mode.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .question-text {
            font-size: 1.2rem;
            color: var(--color-dark-blue);
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        /* Режим ввода */
        .keyboard-input {
            display: flex;
            gap: 1rem;
            max-width: 600px;
            margin: 0 auto 1.5rem;
        }

        #textAnswer {
            flex: 1;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(214, 155, 100, 0.3);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        #textAnswer:focus {
            outline: none;
            border-color: var(--color-gold);
            box-shadow: 0 0 0 3px rgba(214, 155, 100, 0.1);
        }

        #textAnswer:disabled {
            background: rgba(192, 192, 192, 0.1);
            cursor: not-allowed;
        }

        .check-btn {
            padding: 1rem 1.5rem;
            background: var(--color-primary);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
            min-width: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .check-btn:hover:not(:disabled) {
            background: var(--color-dark-red);
            transform: translateY(-1px);
        }

        .check-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .hint-container {
            max-width: 600px;
            margin: 1rem auto;
            background: rgba(59, 130, 246, 0.05);
            padding: 1rem;
            border-radius: 6px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            display: none;
        }

        .hint-message {
            color: #3b82f6;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .attempts-counter {
            text-align: center;
            color: #f59e0b;
            font-weight: 500;
            margin: 1rem 0;
            display: none;
            padding: 0.75rem;
            background: rgba(245, 158, 11, 0.05);
            border-radius: 6px;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        /* Режим просмотра */
        .answer-revealed {
            background: rgba(16, 185, 129, 0.05);
            padding: 2rem;
            border-radius: 10px;
            border: 1px solid rgba(16, 185, 129, 0.2);
            text-align: center;
        }

        .answer-header {
            font-size: 1.1rem;
            color: var(--color-success);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .meaning-display {
            font-size: 2rem;
            color: var(--color-success);
            font-weight: 700;
            margin: 1rem 0;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            border: 1px dashed rgba(16, 185, 129, 0.3);
        }

        .mnemonic-box {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1.5rem;
            border: 1px solid rgba(214, 155, 100, 0.2);
            text-align: left;
        }

        .mnemonic-label {
            display: block;
            color: var(--color-gold);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .mnemonic-text {
            color: var(--color-calm-blue);
            line-height: 1.6;
            font-style: italic;
            font-size: 0.95rem;
        }

        /* Режим выбора */
        .options-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            max-width: 700px;
            margin: 0 auto 1.5rem;
        }

        .option-btn {
            padding: 1.5rem;
            background: white;
            border: 2px solid rgba(214, 155, 100, 0.2);
            border-radius: 10px;
            cursor: pointer;
            text-align: left;
            transition: all 0.2s ease;
            position: relative;
        }

        .option-btn:hover:not(:disabled) {
            border-color: var(--color-gold);
            transform: translateY(-2px);
        }

        .option-btn.correct {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--color-success);
            color: var(--color-success);
        }

        .option-btn.incorrect {
            background: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            color: #ef4444;
        }

        .option-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .option-number {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            width: 24px;
            height: 24px;
            background: rgba(214, 155, 100, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--color-calm-blue);
        }

        .option-text {
            font-size: 1.1rem;
            font-weight: 500;
            margin-right: 2rem;
            line-height: 1.4;
        }

        .option-pinyin {
            color: var(--color-gray);
            font-style: italic;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .loading-options {
            text-align: center;
            padding: 2rem;
            grid-column: 1 / -1;
            color: var(--color-gray);
        }

        .loading-error {
            text-align: center;
            padding: 1.5rem;
            background: rgba(239, 68, 68, 0.05);
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            font-size: 0.9rem;
        }

        /* Подвал карточки */
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(214, 155, 100, 0.1);
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .footer-left {
            flex: 1;
            min-width: 200px;
        }

        .footer-center {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }

        .footer-right {
            flex: 1;
            min-width: 200px;
        }

        .navigation-buttons {
            display: flex;
            gap: 0.75rem;
        }

        .nav-btn {
            padding: 0.75rem 1.25rem;
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid rgba(214, 155, 100, 0.3);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-btn:hover {
            background: var(--color-gold);
            color: white;
            transform: translateY(-1px);
        }

        /* Оценка знаний */
        .evaluation-section {
            margin: 1rem 0;
        }

        .evaluation-question {
            font-size: 1rem;
            color: var(--color-calm-blue);
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .evaluation-buttons {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .eval-btn {
            padding: 0.75rem 1.25rem;
            background: white;
            border: 2px solid rgba(214, 155, 100, 0.2);
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            min-width: 100px;
            color: var(--color-calm-blue);
        }

        .eval-btn:hover {
            border-color: var(--color-gold);
            transform: translateY(-1px);
        }

        .eval-again:hover { background: rgba(239, 68, 68, 0.1); border-color: #ef4444; }
        .eval-hard:hover { background: rgba(245, 158, 11, 0.1); border-color: #f59e0b; }
        .eval-good:hover { background: rgba(16, 185, 129, 0.1); border-color: var(--color-success); }
        .eval-easy:hover { background: rgba(59, 130, 246, 0.1); border-color: #3b82f6; }

        .result-actions {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin: 1rem 0;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .try-again-btn {
            background: var(--color-white-gold);
            color: var(--color-dark-red);
        }

        .try-again-btn:hover {
            background: var(--color-gold);
            color: white;
        }

        .continue-btn {
            background: var(--color-primary);
            color: white;
        }

        .continue-btn:hover {
            background: var(--color-dark-red);
            transform: translateY(-1px);
        }

        /* Статистика прогресса */
        .progress-stats {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            background: rgba(243, 202, 165, 0.05);
            padding: 1.25rem;
            border-radius: 8px;
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(214, 155, 100, 0.1);
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-label {
            color: var(--color-gray);
            font-size: 0.9rem;
        }

        .stat-value {
            font-weight: 600;
            color: var(--color-calm-blue);
            font-size: 1.1rem;
        }

        /* Модальное окно */
        .result-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            border: 2px solid var(--color-gold);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(214, 155, 100, 0.2);
        }

        .modal-header h3 {
            font-size: 1.5rem;
            color: var(--color-dark-blue);
            font-weight: 700;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--color-gray);
            cursor: pointer;
            transition: color 0.2s ease;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .modal-close:hover {
            color: var(--color-primary);
            background: rgba(193, 18, 31, 0.1);
        }

        .modal-body {
            text-align: center;
            padding: 1rem 0;
        }

        .result-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .result-message {
            font-size: 1.1rem;
            color: var(--color-calm-blue);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .correct-answer-card {
            background: rgba(16, 185, 129, 0.05);
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .answer-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .answer-row:last-child {
            border-bottom: none;
        }

        .answer-label {
            color: var(--color-success);
            font-weight: 500;
            min-width: 100px;
            text-align: left;
        }

        .answer-value {
            color: var(--color-calm-blue);
            font-weight: 500;
            text-align: right;
            flex: 1;
            padding-left: 1rem;
        }

        .next-review-info {
            color: var(--color-gold);
            font-size: 0.95rem;
            margin-top: 1rem;
            padding: 1rem;
            background: rgba(214, 155, 100, 0.05);
            border-radius: 6px;
        }

        .modal-footer {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(214, 155, 100, 0.2);
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            min-width: 120px;
            font-size: 0.9rem;
        }

        .modal-btn-secondary {
            background: rgba(192, 192, 192, 0.1);
            color: var(--color-calm-blue);
            border: 1px solid rgba(192, 192, 192, 0.3);
        }

        .modal-btn-secondary:hover {
            background: var(--color-gray);
            color: white;
        }

        /* Уведомления */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.25rem;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            z-index: 1001;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .notification.info {
            background: #3b82f6;
        }

        .notification.success {
            background: var(--color-success);
        }

        .notification.warning {
            background: #f59e0b;
        }

        .notification.error {
            background: #ef4444;
        }

        .notification button {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s ease;
        }

        .notification button:hover {
            opacity: 1;
        }

        /* Адаптивность */
        @media (max-width: 992px) {
            .card-footer {
                flex-direction: column;
                align-items: stretch;
            }
            
            .footer-left,
            .footer-center,
            .footer-right {
                min-width: 100%;
            }
            
            .navigation-buttons {
                justify-content: center;
            }
            
            .progress-stats {
                max-width: 300px;
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .learning-container {
                padding: 1rem;
            }
            
            .card-container {
                padding: 1.5rem;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .mode-selector {
                width: 100%;
                justify-content: stretch;
            }
            
            .mode-btn {
                flex: 1;
                justify-content: center;
            }
            
            .character-char {
                font-size: 4rem;
            }
            
            .character-details {
                grid-template-columns: 1fr;
            }
            
            .keyboard-input {
                flex-direction: column;
            }
            
            .check-btn {
                width: 100%;
            }
            
            .options-grid {
                grid-template-columns: 1fr;
            }
            
            .evaluation-buttons {
                flex-direction: column;
            }
            
            .eval-btn {
                width: 100%;
            }
            
            .modal-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .hsk-levels {
                justify-content: center;
            }
            
            .character-char {
                font-size: 3rem;
            }
            
            .modal-content {
                padding: 1.25rem;
                width: 95%;
            }
            
            .modal-footer {
                flex-direction: column;
            }
            
            .modal-btn {
                width: 100%;
            }
            
            .notification {
                left: 1rem;
                right: 1rem;
                width: auto;
                min-width: auto;
            }
            
            .result-actions {
                flex-direction: column;
            }
            
            .action-btn {
                width: 100%;
            }
            
            .navigation-buttons {
                flex-direction: column;
            }
            
            .nav-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <x-slot name="header">
        <div class="header-content">
            <h2 class="header-title">
                {{ __('Обучение: ') }} HSK {{ $character->hsk_level }}
            </h2>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="btn-back">← Назад в дашборд</a>
            </div>
        </div>
    </x-slot>

    <div class="learning-container">
        <div class="hsk-navigation">
            <div class="hsk-levels">
                @for($i = 1; $i <= 6; $i++)
                    <a href="{{ route('learning.level', $i) }}" 
                       class="hsk-level {{ $character->hsk_level == $i ? 'active' : '' }}">
                        HSK {{ $i }}
                    </a>
                @endfor
            </div>
            <div class="hsk-progress">
                <span class="progress-text">Прогресс HSK {{ $character->hsk_level }}: {{ $progress }}%</span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>

        <div class="card-container">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-title-text">Изучение иероглифов</h3>
                    <p class="card-subtitle">HSK {{ $character->hsk_level }} • Иероглиф {{ $character->id }}</p>
                </div>
                
                <div class="mode-selector">
                    <button class="mode-btn {{ $mode == 'keyboard' ? 'active' : '' }}" 
                            data-mode="keyboard" title="Режим ввода">
                        <span class="mode-icon">⌨️</span>
                        <span class="mode-label">Ввод</span>
                    </button>
                    <button class="mode-btn {{ $mode == 'eye' ? 'active' : '' }}" 
                            data-mode="eye" title="Режим просмотра">
                        <span class="mode-icon">👁️</span>
                        <span class="mode-label">Просмотр</span>
                    </button>
                    <button class="mode-btn {{ $mode == 'multiple' ? 'active' : '' }}" 
                            data-mode="multiple" title="Выбор из вариантов">
                        <span class="mode-icon">🔘</span>
                        <span class="mode-label">Варианты</span>
                    </button>
                </div>
            </div>

            <div class="character-card">
                <div class="character-display">
                    <div class="character-main">
                        <span class="character-char">{{ $character->character }}</span>
                        <div class="character-audio">
                            @if($character->audio_character)
                                <button class="audio-btn" onclick="playAudio('{{ $character->audio_character }}')">
                                    <span class="audio-icon">🔊</span>
                                    <span class="audio-text">Произношение</span>
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <div class="character-details">
                        <div class="detail-row">
                            <span class="detail-label">Пиньинь:</span>
                            <span class="detail-value pinyin">{{ $character->pinyin }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">HSK:</span>
                            <span class="detail-value hsk-level">Уровень {{ $character->hsk_level }}</span>
                        </div>
                    </div>
                </div>

                @if($character->example_hanzi)
                <div class="example-section">
                    <div class="section-title">
                        <span>Пример использования:</span>
                    </div>
                    <div class="example-content">
                        <div class="example-hanzi">{{ $character->example_hanzi }}</div>
                        <div class="example-pinyin">{{ $character->example_pinyin }}</div>
                        <div class="example-translation">{{ $character->example_translation }}</div>
                        @if($character->audio_example)
                            <button class="audio-btn example-audio" onclick="playAudio('{{ $character->audio_example }}')">
                                <span class="audio-icon">🔊</span>
                                <span class="audio-text">Прослушать пример</span>
                            </button>
                        @endif
                    </div>
                </div>
                @endif

                <div class="answer-section">
                    <!-- Режим ввода (keyboard) -->
                    <div class="answer-mode {{ $mode == 'keyboard' ? 'active' : '' }}" id="keyboardMode">
                        <div class="question-text">
                            <p>Введите перевод этого иероглифа:</p>
                        </div>
                        <div class="keyboard-input">
                            <input type="text" 
                                   id="textAnswer" 
                                   placeholder="Введите значение на русском..."
                                   autocomplete="off"
                                   autofocus
                                   data-correct-answer="{{ strtolower($character->meaning) }}">
                            <button class="check-btn" id="checkAnswerBtn">
                                <span class="check-icon">✓</span>
                                <span class="check-text">Проверить</span>
                            </button>
                        </div>
                        <div class="hint-container" id="hintContainer"></div>
                        <div class="attempts-counter" id="attemptsCounter" style="display: none;">
                            <span>Осталось попыток: <span id="attemptsLeft">3</span></span>
                        </div>
                    </div>

                    <!-- Режим просмотра (eye) -->
                    <div class="answer-mode {{ $mode == 'eye' ? 'active' : '' }}" id="eyeMode">
                        <div class="answer-revealed">
                            <div class="answer-header">
                                <span>Значение:</span>
                            </div>
                            <div class="answer-content">
                                <div class="meaning-display">{{ $character->meaning }}</div>
                                @if($character->mnemonic)
                                    <div class="mnemonic-box">
                                        <span class="mnemonic-label">Подсказка для запоминания:</span>
                                        <p class="mnemonic-text">{{ $character->mnemonic }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Режим выбора (multiple) -->
                    <div class="answer-mode {{ $mode == 'multiple' ? 'active' : '' }}" id="multipleMode">
                        <div class="question-text">
                            <p>Выберите правильный перевод:</p>
                        </div>
                        <div class="options-grid" id="optionsGrid">
                            <div class="loading-options">
                                <span>Загрузка вариантов...</span>
                            </div>
                        </div>
                        <div class="attempts-counter" id="multipleAttemptsCounter" style="display: none;">
                            <span>Осталось попыток: <span id="multipleAttemptsLeft">3</span></span>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="footer-left">
                        <div class="navigation-buttons">
                            @if($prevCharacter)
                                <a href="{{ route('learning.show', ['character' => $prevCharacter->id, 'mode' => $mode]) }}" 
                                   class="nav-btn btn-prev">
                                    ← Предыдущий
                                </a>
                            @endif
                            
                            @if($nextCharacter)
                                <a href="{{ route('learning.show', ['character' => $nextCharacter->id, 'mode' => $mode]) }}" 
                                   class="nav-btn btn-next">
                                    Следующий →
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="footer-center">
                        <div class="evaluation-section" id="evaluationSection" style="display: none;">
                            <p class="evaluation-question">Оцените, насколько хорошо вы знаете этот иероглиф:</p>
                            <div class="evaluation-buttons">
                                <button class="eval-btn eval-again" data-result="again">
                                    <span class="label">Не знаю</span>
                                </button>
                                <button class="eval-btn eval-hard" data-result="hard">
                                    <span class="label">С трудом</span>
                                </button>
                                <button class="eval-btn eval-good" data-result="good">
                                    <span class="label">Знаю</span>
                                </button>
                                <button class="eval-btn eval-easy" data-result="easy">
                                    <span class="label">Отлично</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="result-actions" id="resultActions" style="display: none;">
                            <button class="action-btn try-again-btn" id="tryAgainBtn">
                                <span class="action-icon">↻</span>
                                <span class="action-text">Попробовать снова</span>
                            </button>
                            <button class="action-btn continue-btn" id="continueBtn">
                                <span class="action-icon">→</span>
                                <span class="action-text">Продолжить</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="footer-right">
                        <div class="progress-stats">
                            <div class="stat-item">
                                <span class="stat-label">Выучено:</span>
                                <span class="stat-value">{{ $learnedCount }}/{{ $totalInLevel }}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Прогресс:</span>
                                <span class="stat-value">{{ $progress }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="result-modal" id="resultModal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="resultTitle">Результат</h3>
                    <button class="modal-close" onclick="closeResultModal()">×</button>
                </div>
                <div class="modal-body">
                    <div class="result-icon" id="resultIcon">🎉</div>
                    <div class="result-message" id="resultMessage"></div>
                    
                    <div class="correct-answer-card" id="correctAnswerDisplay" style="display: none;">
                        <div class="answer-card">
                            <div class="answer-row">
                                <span class="answer-label">Иероглиф:</span>
                                <span class="answer-value">{{ $character->character }}</span>
                            </div>
                            <div class="answer-row">
                                <span class="answer-label">Пиньинь:</span>
                                <span class="answer-value">{{ $character->pinyin }}</span>
                            </div>
                            <div class="answer-row">
                                <span class="answer-label">Значение:</span>
                                <span class="answer-value">{{ $character->meaning }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="next-review-info" id="nextReviewInfo" style="display: none;">
                        <p>Следующее повторение: <span id="nextReviewDate"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="modal-btn modal-btn-secondary" onclick="closeResultModal()">
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentMode = '{{ $mode }}';
        let attemptsLeft = 3;
        let hasAnswered = false;
        let correctAnswer = "{{ strtolower($character->meaning) }}";
        let characterId = {{ $character->id }};
        let userId = {{ auth()->id() }};

        document.addEventListener('DOMContentLoaded', function() {
            if (currentMode === 'multiple') {
                loadMultipleChoiceOptions();
            }

            setupModeSwitching();
            setupAnswerChecking();
            setupEvaluationButtons();
            setupNavigation();
            
            document.getElementById('resultModal').style.display = 'none';
            
            if (currentMode === 'keyboard') {
                document.getElementById('textAnswer').focus();
            }
        });

        function playAudio(audioUrl) {
            const audio = new Audio(audioUrl);
            audio.play().catch(e => console.log('Не удалось воспроизвести аудио', e));
        }

        function setupModeSwitching() {
            document.querySelectorAll('.mode-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const mode = this.dataset.mode;
                    const url = new URL(window.location.href);
                    url.searchParams.set('mode', mode);
                    window.location.href = url.toString();
                });
            });
        }

        async function loadMultipleChoiceOptions() {
            try {
                const response = await fetch(`/api/characters/${characterId}/multiple-choice`);
                const data = await response.json();
                
                if (data.success) {
                    const optionsGrid = document.getElementById('optionsGrid');
                    optionsGrid.innerHTML = '';
                    
                    data.options.forEach((option, index) => {
                        const btn = document.createElement('button');
                        btn.className = 'option-btn';
                        btn.innerHTML = `
                            <span class="option-number">${index + 1}</span>
                            <span class="option-text">${option.meaning}</span>
                            ${option.pinyin ? `<span class="option-pinyin">${option.pinyin}</span>` : ''}
                        `;
                        btn.dataset.optionId = option.id;
                        btn.dataset.isCorrect = option.is_correct;
                        
                        btn.addEventListener('click', function() {
                            checkMultipleChoiceAnswer(this);
                        });
                        
                        optionsGrid.appendChild(btn);
                    });
                }
            } catch (error) {
                console.error('Error loading options:', error);
                document.getElementById('optionsGrid').innerHTML = 
                    '<div class="loading-error">Не удалось загрузить варианты. Пожалуйста, попробуйте снова.</div>';
            }
        }

        function checkMultipleChoiceAnswer(button) {
            const isCorrect = button.dataset.isCorrect === 'true';
            
            if (isCorrect) {
                button.classList.add('correct');
                showResult(true, 'multiple');
            } else {
                button.classList.add('incorrect');
                attemptsLeft--;
                
                const attemptsCounter = document.getElementById('multipleAttemptsCounter');
                const attemptsLeftSpan = document.getElementById('multipleAttemptsLeft');
                
                attemptsLeftSpan.textContent = attemptsLeft;
                attemptsCounter.style.display = 'block';
                
                if (attemptsLeft <= 0) {
                    showCorrectAnswer();
                    showResult(false, 'multiple');
                }
            }
            
            document.querySelectorAll('.option-btn').forEach(btn => {
                btn.disabled = true;
                if (btn.dataset.isCorrect === 'true') {
                    btn.classList.add('correct');
                }
            });
        }

        function setupAnswerChecking() {
            const checkBtn = document.getElementById('checkAnswerBtn');
            const textInput = document.getElementById('textAnswer');
            const hintContainer = document.getElementById('hintContainer');
            
            if (!checkBtn || !textInput) return;
            
            checkBtn.addEventListener('click', function() {
                checkKeyboardAnswer();
            });
            
            textInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    checkKeyboardAnswer();
                }
            });
        }

        function checkKeyboardAnswer() {
            const userAnswer = document.getElementById('textAnswer').value.trim().toLowerCase();
            const attemptsCounter = document.getElementById('attemptsCounter');
            const attemptsLeftSpan = document.getElementById('attemptsLeft');
            const hintContainer = document.getElementById('hintContainer');
            
            if (!userAnswer) {
                showNotification('Пожалуйста, введите ответ', 'warning');
                return;
            }
            
            const isCorrect = validateAnswer(userAnswer, correctAnswer);
            
            if (isCorrect) {
                showResult(true, 'keyboard');
            } else {
                attemptsLeft--;
                attemptsLeftSpan.textContent = attemptsLeft;
                attemptsCounter.style.display = 'block';
                
                const hint = generateHint(userAnswer);
                if (hint) {
                    hintContainer.innerHTML = `<div class="hint-message">💡 ${hint}</div>`;
                    hintContainer.style.display = 'block';
                }
                
                if (attemptsLeft <= 0) {
                    showCorrectAnswer();
                    showResult(false, 'keyboard');
                }
            }
        }

        function validateAnswer(userAnswer, correctAnswer) {
            const correctParts = correctAnswer.split(';').map(part => part.trim().toLowerCase());
            
            if (correctParts.includes(userAnswer)) {
                return true;
            }
            
            for (const part of correctParts) {
                if (part.includes(userAnswer) || userAnswer.includes(part)) {
                    return true;
                }
                
                const words = part.split(' ');
                if (words.some(word => word === userAnswer)) {
                    return true;
                }
            }
            
            return false;
        }

        function generateHint(userAnswer) {
            const hints = [];
            
            const firstLetter = correctAnswer.charAt(0);
            if (!userAnswer.startsWith(firstLetter.toLowerCase())) {
                hints.push(`Начинается с "${firstLetter}"`);
            }
            
            const wordCount = correctAnswer.split(' ').length;
            if (wordCount > 1 && userAnswer.split(' ').length < wordCount) {
                hints.push(`Состоит из ${wordCount} слов`);
            }
            
            if (correctAnswer.includes(';')) {
                const synonyms = correctAnswer.split(';');
                if (synonyms.length > 1) {
                    hints.push(`Также может означать: ${synonyms[1].trim()}`);
                }
            }
            
            return hints.length > 0 ? hints[0] : null;
        }

        function showCorrectAnswer() {
            const correctDisplay = document.getElementById('correctAnswerDisplay');
            if (correctDisplay) {
                correctDisplay.style.display = 'block';
            }
        }

        function showResult(isCorrect, mode) {
            hasAnswered = true;
            
            document.getElementById('evaluationSection').style.display = 'block';
            
            if (mode === 'keyboard') {
                document.getElementById('textAnswer').disabled = true;
                document.getElementById('checkAnswerBtn').disabled = true;
            } else if (mode === 'multiple') {
                document.querySelectorAll('.option-btn').forEach(btn => btn.disabled = true);
            }
            
            showResultModal(isCorrect);
        }

        function showResultModal(isCorrect) {
            const modal = document.getElementById('resultModal');
            const icon = document.getElementById('resultIcon');
            const title = document.getElementById('resultTitle');
            const message = document.getElementById('resultMessage');
            
            if (isCorrect) {
                icon.textContent = '🎉';
                title.textContent = 'Правильно!';
                message.textContent = 'Вы правильно определили значение иероглифа.';
            } else {
                icon.textContent = '😕';
                title.textContent = 'Попробуйте еще раз';
                message.textContent = 'Не совсем правильно. Вот правильный ответ:';
                document.getElementById('correctAnswerDisplay').style.display = 'block';
            }
            
            modal.style.display = 'flex';
        }

        function closeResultModal() {
            document.getElementById('resultModal').style.display = 'none';
        }

        function setupEvaluationButtons() {
            document.querySelectorAll('.eval-btn').forEach(btn => {
                btn.addEventListener('click', async function() {
                    const result = this.dataset.result;
                    await submitEvaluation(result);
                });
            });
            
            document.getElementById('tryAgainBtn')?.addEventListener('click', function() {
                resetAnswerState();
            });
            
            document.getElementById('continueBtn')?.addEventListener('click', function() {
                if ({{ $nextCharacter ? 'true' : 'false' }}) {
                    window.location.href = "{{ route('learning.show', ['character' => $nextCharacter->id ?? $character->id, 'mode' => $mode]) }}";
                }
            });
        }

        async function submitEvaluation(result) {
            try {
                const response = await fetch('/api/review/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        character_id: characterId,
                        result: result,
                        attempts: 3 - attemptsLeft 
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('nextReviewInfo').style.display = 'block';
                    document.getElementById('nextReviewDate').textContent = data.next_review_at;
                    
                    document.getElementById('evaluationSection').style.display = 'none';
                    document.getElementById('resultActions').style.display = 'block';
                    
                    showNotification(data.message);
                }
            } catch (error) {
                console.error('Error submitting evaluation:', error);
                alert('Ошибка при сохранении результата');
            }
        }

        function resetAnswerState() {
            attemptsLeft = 3;
            hasAnswered = false;
            
            if (currentMode === 'keyboard') {
                document.getElementById('textAnswer').value = '';
                document.getElementById('textAnswer').disabled = false;
                document.getElementById('checkAnswerBtn').disabled = false;
                document.getElementById('attemptsCounter').style.display = 'none';
                document.getElementById('hintContainer').style.display = 'none';
                document.getElementById('textAnswer').focus();
            }
            
            if (currentMode === 'multiple') {
                document.querySelectorAll('.option-btn').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('correct', 'incorrect');
                });
                document.getElementById('multipleAttemptsCounter').style.display = 'none';
            }
            
            document.getElementById('evaluationSection').style.display = 'none';
            document.getElementById('resultActions').style.display = 'none';
            document.getElementById('correctAnswerDisplay').style.display = 'none';
            document.getElementById('nextReviewInfo').style.display = 'none';
            closeResultModal();
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = 'notification ' + type;
            notification.innerHTML = `
                <span>${message}</span>
                <button onclick="this.parentElement.remove()">×</button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        function setupNavigation() {
            document.querySelectorAll('.nav-btn').forEach(btn => {
                const originalHref = btn.href;
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(originalHref);
                    url.searchParams.set('mode', currentMode);
                    window.location.href = url.toString();
                });
            });
            
            document.addEventListener('keydown', function(e) {
                if (hasAnswered) return;
                
                if (e.key === 'Enter' && currentMode === 'keyboard') {
                    checkKeyboardAnswer();
                }
                
                if (e.key >= '1' && e.key <= '4' && currentMode === 'multiple') {
                    const index = parseInt(e.key) - 1;
                    const options = document.querySelectorAll('.option-btn');
                    if (options[index]) {
                        options[index].click();
                    }
                }
                
                if (e.key === 'ArrowLeft' && document.querySelector('.btn-prev')) {
                    document.querySelector('.btn-prev').click();
                }
                if (e.key === 'ArrowRight' && document.querySelector('.btn-next')) {
                    document.querySelector('.btn-next').click();
                }
            });
        }
    </script>
</x-app-layout>