<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <style>
        /* ===== ПЕРЕМЕННЫЕ ===== */
        :root {
            --color-primary: #C1121F;
            --color-dark-red: #7A1414;
            --color-red: #8E1B1B;
            --color-gold: #D69B64;
            --color-white-gold: #F3CAA5;
            --color-calm-blue: #1F2933;
            --color-dark-blue: #0F172A;
            --color-gray: #C0C0C0;
            --color-success: #10b981;
            --color-warning: #f59e0b;
            --color-error: #ef4444;
            --color-info: #3b82f6;
            --color-light-bg: #f8f9fa;
        }

        /* ===== ОБЩИЕ СТИЛИ ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans SC', sans-serif;
            background: var(--color-light-bg);
            color: var(--color-calm-blue);
            min-height: 100vh;
        }

        /* ===== КОНТЕЙНЕР ДАШБОРДА ===== */
        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(243, 202, 165, 0.1) 0%, rgba(214, 155, 100, 0.05) 100%);
            font-family: 'Noto Sans SC', sans-serif;
            overflow-x: hidden;
        }

        /* ===== ШАПКА ДАШБОРДА ===== */
        .dashboard-header {
            background: var(--color-dark-blue);
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left .logo {
            font-family: 'Noto Serif SC', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-white-gold);
            margin-bottom: 0.25rem;
            letter-spacing: 1px;
        }

        .header-left .subtitle {
            color: rgba(243, 202, 165, 0.8);
            font-size: 1rem;
            letter-spacing: 0.5px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--color-white-gold);
            font-size: 1.1rem;
        }

        .profile-link {
            color: var(--color-white-gold);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 6px;
            background: rgba(243, 202, 165, 0.1);
        }

        .profile-link:hover {
            background: rgba(243, 202, 165, 0.2);
            color: var(--color-gold);
            text-decoration: none;
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            background: var(--color-primary);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            font-family: 'Noto Sans SC', sans-serif;
            font-size: 0.95rem;
            border: 2px solid transparent;
        }

        .logout-btn:hover {
            background: var(--color-red);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(193, 18, 31, 0.3);
        }

        /* ===== ОСНОВНОЙ КОНТЕНТ ===== */
        .dashboard-main {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr) 320px;
            gap: 2rem;
            padding: 2.5rem 3rem;
            max-width: 1920px;
            margin: 0 auto;
            min-height: calc(100vh - 180px);
            min-width: 0;
        }

        @media (max-width: 1400px) {
            .dashboard-main {
                grid-template-columns: 280px minmax(0, 1fr);
            }
            
            .right-sidebar {
                grid-column: 1 / -1;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }

        @media (max-width: 1024px) {
            .dashboard-main {
                grid-template-columns: minmax(0, 1fr);
            }
            
            .sidebar {
                order: 2;
            }
            
            .right-sidebar {
                order: 3;
                grid-template-columns: 1fr;
            }
        }

        /* ===== ЛЕВАЯ БОКОВАЯ ПАНЕЛЬ ===== */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .quick-actions {
            background: white;
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(122, 20, 20, 0.08);
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .quick-actions h3 {
            font-family: 'Noto Serif SC', serif;
            font-size: 1.3rem;
            color: var(--color-dark-blue);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(214, 155, 100, 0.2);
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            background: var(--color-light-bg);
            border: 2px solid rgba(214, 155, 100, 0.2);
            border-radius: 10px;
            text-decoration: none;
            color: var(--color-calm-blue);
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .action-btn:hover {
            background: var(--color-white-gold);
            border-color: var(--color-gold);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(214, 155, 100, 0.2);
            color: var(--color-dark-red);
        }

        .action-btn.primary {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
            font-weight: 600;
        }

        .action-btn.primary:hover {
            background: var(--color-red);
            border-color: var(--color-red);
            box-shadow: 0 6px 15px rgba(193, 18, 31, 0.3);
        }

        .action-icon {
            font-size: 1.3rem;
            width: 30px;
            text-align: center;
        }

        .sidebar-stats {
            background: white;
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(122, 20, 20, 0.08);
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .sidebar-stats h3 {
            font-family: 'Noto Serif SC', serif;
            font-size: 1.3rem;
            color: var(--color-dark-blue);
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(214, 155, 100, 0.2);
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.85rem 0;
            border-bottom: 1px solid rgba(192, 192, 192, 0.1);
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-label {
            color: var(--color-gray);
            font-size: 0.95rem;
        }

        .stat-value {
            font-weight: 700;
            color: var(--color-dark-red);
            font-size: 1.2rem;
        }

        /* ===== ЦЕНТРАЛЬНАЯ КОЛОНКА ===== */
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            min-width: 0;
            max-width: 100%;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--color-dark-red) 0%, var(--color-primary) 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(122, 20, 20, 0.25);
            border: 2px solid var(--color-gold);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-section::before {
            content: '欢迎';
            position: absolute;
            bottom: -30px;
            right: 30px;
            font-family: 'Noto Serif SC', serif;
            font-size: 8rem;
            color: rgba(255, 255, 255, 0.05);
            z-index: 0;
        }

        .welcome-section h2 {
            font-family: 'Noto Serif SC', serif;
            font-size: 2.2rem;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .welcome-section p {
            font-size: 1.2rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        .welcome-section strong {
            color: var(--color-gold);
        }

        .hsk-progress-section {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(122, 20, 20, 0.08);
            border: 1px solid rgba(214, 155, 100, 0.1);
            animation: fadeInUp 0.6s ease 0.1s backwards;
        }

        .hsk-progress-section h3 {
            font-family: 'Noto Serif SC', serif;
            font-size: 1.5rem;
            color: var(--color-dark-blue);
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(214, 155, 100, 0.2);
        }

        .hsk-levels {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }

        @media (max-width: 1400px) {
            .hsk-levels {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hsk-levels {
                grid-template-columns: 1fr;
            }
        }

        .hsk-level-card {
            background: var(--color-light-bg);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(214, 155, 100, 0.2);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            animation: fadeInUp 0.6s ease backwards;
        }

        .hsk-level-card:nth-child(1) { animation-delay: 0.1s; }
        .hsk-level-card:nth-child(2) { animation-delay: 0.2s; }
        .hsk-level-card:nth-child(3) { animation-delay: 0.3s; }
        .hsk-level-card:nth-child(4) { animation-delay: 0.4s; }
        .hsk-level-card:nth-child(5) { animation-delay: 0.5s; }
        .hsk-level-card:nth-child(6) { animation-delay: 0.6s; }

        .hsk-level-card:hover {
            border-color: var(--color-gold);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(214, 155, 100, 0.15);
        }

        .hsk-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .hsk-header h4 {
            color: var(--color-dark-blue);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .hsk-count {
            background: var(--color-primary);
            color: white;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .progress-bar {
            height: 10px;
            background: rgba(192, 192, 192, 0.2);
            border-radius: 5px;
            margin-bottom: 0.75rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--color-primary), var(--color-gold));
            border-radius: 5px;
            transition: width 1.2s ease;
        }

        .hsk-progress-text {
            text-align: center;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 1.25rem;
            font-size: 1.1rem;
        }

        .hsk-action-btn,
        .hsk-review-btn {
            display: inline-block;
            text-align: center;
            padding: 0.6rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .hsk-action-btn {
            background: var(--color-primary);
            color: white;
            margin-right: 0.35rem;
            border: 2px solid var(--color-primary);
        }

        .hsk-action-btn:hover {
            background: var(--color-red);
            border-color: var(--color-red);
            transform: translateY(-2px);
        }

        .hsk-review-btn {
            background: transparent;
            color: var(--color-calm-blue);
            margin-left: 0.35rem;
            border: 2px solid rgba(214, 155, 100, 0.3);
        }

        .hsk-review-btn:hover {
            background: var(--color-white-gold);
            border-color: var(--color-gold);
            color: var(--color-dark-red);
            transform: translateY(-2px);
        }

        /* ===== ИЕРОГЛИФЫ ДЛЯ ПОВТОРЕНИЯ ===== */
        .due-cards-section {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(122, 20, 20, 0.08);
            border: 1px solid rgba(214, 155, 100, 0.1);
            animation: fadeInUp 0.6s ease 0.2s backwards;
        }

        .due-cards-section h3 {
            font-family: 'Noto Serif SC', serif;
            font-size: 1.5rem;
            color: var(--color-dark-blue);
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(214, 155, 100, 0.2);
        }

        .due-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .due-card {
            background: white;
            border: 2px solid rgba(214, 155, 100, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            animation: fadeInUp 0.6s ease backwards;
        }

        .due-card:nth-child(1) { animation-delay: 0.2s; }
        .due-card:nth-child(2) { animation-delay: 0.3s; }
        .due-card:nth-child(3) { animation-delay: 0.4s; }
        .due-card:nth-child(4) { animation-delay: 0.5s; }
        .due-card:nth-child(5) { animation-delay: 0.6s; }
        .due-card:nth-child(6) { animation-delay: 0.7s; }

        .due-card:hover {
            border-color: var(--color-gold);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 8px 25px rgba(214, 155, 100, 0.15);
        }

        .due-card-character {
            font-family: 'Noto Serif SC', serif;
            font-size: 3.5rem;
            color: var(--color-dark-red);
            margin-bottom: 1rem;
            line-height: 1;
        }

        .due-card-info {
            width: 100%;
        }

        .due-card-pinyin {
            color: var(--color-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-style: italic;
            font-size: 1rem;
        }

        .due-card-meaning {
            color: var(--color-calm-blue);
            font-size: 0.95rem;
            margin-bottom: 1rem;
            line-height: 1.4;
            min-height: 2.8em;
        }

        .due-card-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--color-gray);
            padding-top: 0.75rem;
            border-top: 1px solid rgba(192, 192, 192, 0.2);
        }

        .due-card-level {
            color: var(--color-gold);
            font-weight: 500;
        }

        .view-all-container {
            text-align: center;
            margin-top: 1.5rem;
        }

        .view-all-btn {
            display: inline-block;
            background: var(--color-primary);
            color: white;
            padding: 0.85rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .view-all-btn:hover {
            background: var(--color-red);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(193, 18, 31, 0.25);
            border-color: var(--color-white-gold);
        }

        .no-cards-message {
            text-align: center;
            padding: 3rem 2rem;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            border: 2px dashed var(--color-success);
            border-radius: 16px;
            color: var(--color-success);
            font-size: 1.1rem;
        }

        .no-cards-message a {
            color: var(--color-success);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
        }

        .no-cards-message a:hover {
            color: #0da271;
            border-bottom-color: var(--color-success);
        }

        /* ===== ПРАВАЯ БОКОВАЯ ПАНЕЛЬ ===== */
        .right-sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            min-width: 0;
        }

        .collections-section {
            background: white;
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(122, 20, 20, 0.08);
            border: 1px solid rgba(214, 155, 100, 0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-header h3 {
            font-family: 'Noto Serif SC', serif;
            font-size: 1.3rem;
            color: var(--color-dark-blue);
            margin: 0;
        }

        .add-collection-btn {
            width: 36px;
            height: 36px;
            background: var(--color-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            font-weight: 300;
        }

        .add-collection-btn:hover {
            background: var(--color-red);
            transform: rotate(90deg) scale(1.1);
            box-shadow: 0 4px 12px rgba(193, 18, 31, 0.3);
        }

        .collections-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .collection-item {
            background: var(--color-light-bg);
            padding: 1.25rem;
            border-radius: 10px;
            border: 1px solid rgba(214, 155, 100, 0.2);
            transition: all 0.3s ease;
        }

        .collection-item:hover {
            background: white;
            border-color: var(--color-gold);
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(214, 155, 100, 0.15);
        }

        .collection-info {
            margin-bottom: 1rem;
        }

        .collection-name {
            font-weight: 600;
            color: var(--color-dark-blue);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .collection-count {
            font-size: 0.9rem;
            color: var(--color-gray);
        }

        .collection-actions {
            display: flex;
            gap: 0.75rem;
            align-items: stretch;
        }

        /* Одна высота/типографика с «Открыть», без разметки карточек quick-actions */
        .collection-actions .collection-view-btn,
        .collection-actions .collection-review-btn,
        .collection-actions .action-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0.65rem 1rem;
            min-height: 2.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: background 0.25s ease, border-color 0.25s ease, color 0.25s ease, transform 0.2s ease, box-shadow 0.25s ease;
            margin-bottom: 0;
            gap: 0;
            box-sizing: border-box;
            border-width: 1px;
            border-style: solid;
        }

        .collection-actions .action-btn:hover {
            transform: translateY(-2px);
        }

        .collection-actions .collection-view-btn {
            background: rgba(214, 155, 100, 0.1);
            color: var(--color-gold);
            border-color: rgba(214, 155, 100, 0.25);
        }

        .collection-actions .collection-view-btn:hover {
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            border-color: var(--color-gold);
            box-shadow: 0 4px 12px rgba(214, 155, 100, 0.15);
        }

        .collection-actions .collection-review-btn {
            background: var(--color-success);
            color: white;
            border-color: var(--color-success);
        }

        .collection-actions .action-btn.primary {
            border-color: var(--color-primary);
        }

        .collection-actions .action-btn.primary:hover {
            box-shadow: 0 4px 14px rgba(193, 18, 31, 0.28);
        }

        .no-collections {
            text-align: center;
            padding: 2.5rem 1.5rem;
        }

        .no-collections p {
            color: var(--color-gray);
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .create-collection-btn {
            display: inline-block;
            background: var(--color-primary);
            color: white;
            padding: 0.85rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .create-collection-btn:hover {
            background: var(--color-red);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(193, 18, 31, 0.25);
            border-color: var(--color-white-gold);
        }

        .recent-activity {
            background: white;
            padding: 1.75rem;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(122, 20, 20, 0.08);
            border: 1px solid rgba(214, 155, 100, 0.1);
            animation: fadeInUp 0.6s ease 0.3s backwards;
        }

        .recent-activity h3 {
            font-family: 'Noto Serif SC', serif;
            font-size: 1.3rem;
            color: var(--color-dark-blue);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(214, 155, 100, 0.2);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(192, 192, 192, 0.1);
            animation: fadeInUp 0.6s ease backwards;
        }

        .activity-item:nth-child(1) { animation-delay: 0.3s; }
        .activity-item:nth-child(2) { animation-delay: 0.4s; }
        .activity-item:nth-child(3) { animation-delay: 0.5s; }

        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .activity-icon {
            font-size: 1.3rem;
            width: 36px;
            height: 36px;
            background: rgba(214, 155, 100, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-text {
            flex: 1;
            color: var(--color-calm-blue);
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .activity-time {
            font-size: 0.85rem;
            color: var(--color-gray);
            white-space: nowrap;
        }

        /* ===== ПОДВАЛ ===== */
        .dashboard-footer {
            background: var(--color-dark-blue);
            color: white;
            padding: 1.75rem 3rem;
            margin-top: 2rem;
            border-top: 3px solid var(--color-primary);
        }

        .footer-content {
            max-width: 1920px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-content p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
        }

        .footer-links a {
            color: var(--color-white-gold);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            position: relative;
        }

        .footer-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--color-gold);
            transition: width 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--color-gold);
        }

        .footer-links a:hover::after {
            width: 100%;
        }

        /* ===== УВЕДОМЛЕНИЯ ===== */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--color-success);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 1000;
            animation: slideInRight 0.3s ease;
            max-width: 400px;
        }

        .notification-success {
            background: var(--color-success);
        }

        .notification-error {
            background: var(--color-error);
        }

        .notification-info {
            background: var(--color-info);
        }

        .notification-warning {
            background: var(--color-warning);
        }

        .notification button {
            background: none;
            border: none;
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.3s ease;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification button:hover {
            opacity: 1;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* ===== АДАПТИВНОСТЬ ===== */
        @media (max-width: 1200px) {
            .dashboard-header {
                padding: 1.5rem 2rem;
            }
            
            .dashboard-main {
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
                padding: 1.5rem 1rem;
            }
            
            .user-info {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1.5rem;
            }
            
            .dashboard-main {
                padding: 1.5rem 1rem;
            }
            
            .due-cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .footer-content {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
            
            .footer-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .hsk-levels {
                grid-template-columns: 1fr;
            }
            
            .due-cards-grid {
                grid-template-columns: 1fr;
            }
            
            .hsk-action-btn,
            .hsk-review-btn {
                width: 100%;
                margin: 0.25rem 0;
            }
            
            .collection-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .collection-view-btn,
            .collection-review-btn,
            .collection-actions .action-btn {
                width: 100%;
                text-align: center;
            }
            
            .dashboard-footer {
                padding: 1.5rem 1rem;
            }
        }

        /* ===== АНИМАЦИИ ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Достижения (горизонтальный скролл только внутри блока) */
        .achievements-section {
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(15, 23, 42, 0.06);
            border: 1px solid rgba(214, 155, 100, 0.2);
            min-width: 0;
            max-width: 100%;
            box-sizing: border-box;
        }

        .achievements-section h3 {
            margin-bottom: 0.75rem;
            font-family: 'Noto Serif SC', serif;
            color: var(--color-dark-blue);
            font-size: 1.25rem;
        }

        .achievements-slider-wrap {
            position: relative;
            max-width: 100%;
            overflow: hidden;
        }

        .achievements-slider-wrap::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 8px;
            width: 40px;
            pointer-events: none;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.95));
            border-radius: 0 12px 12px 0;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .achievements-slider-wrap.is-scrollable::after {
            opacity: 1;
        }

        .achievements-slider {
            display: flex;
            gap: 0.65rem;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow-x: auto;
            overflow-y: hidden;
            overscroll-behavior-x: contain;
            scroll-snap-type: x mandatory;
            scroll-padding-inline: 0.25rem;
            padding: 0.25rem 0 0.75rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(193, 18, 31, 0.35) rgba(15, 23, 42, 0.06);
        }

        .achievements-slider::-webkit-scrollbar {
            height: 8px;
        }

        .achievements-slider::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.06);
            border-radius: 4px;
        }

        .achievements-slider::-webkit-scrollbar-thumb {
            background: rgba(193, 18, 31, 0.35);
            border-radius: 4px;
        }

        /* Уже базовой ширины: правая колонка ~320px минус padding секции */
        .achievement-slide {
            flex: 0 0 min(204px, 100%);
            width: min(220px, 100%);
            max-width: 100%;
            scroll-snap-align: start;
            box-sizing: border-box;
        }

        .achievement-card {
            display: flex;
            flex-direction: column;
            gap: 0.55rem;
            height: 100%;
            padding: 0.75rem 0.8rem 0.7rem;
            border-radius: 10px;
            border: 1px solid rgba(31, 41, 51, 0.12);
            background: #fafafa;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .achievement-card.earned {
            border-color: rgba(16, 185, 129, 0.35);
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(243, 202, 165, 0.15) 100%);
        }

        .achievement-card.locked {
            opacity: 0.58;
        }

        .achievement-card.earned:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.1);
        }

        .achievement-card.locked:hover {
            opacity: 0.72;
        }

        .achievement-card-top {
            display: flex;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .achievement-icon {
            font-size: 1.65rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .achievement-name {
            font-weight: 700;
            font-size: 0.92rem;
            color: var(--color-dark-blue);
            margin-bottom: 0.25rem;
            line-height: 1.25;
        }

        .achievement-desc {
            font-size: 0.78rem;
            color: #4b5563;
            line-height: 1.35;
        }

        .achievement-date {
            font-size: 0.72rem;
            color: #6b7280;
            margin-top: auto;
            padding-top: 0.35rem;
            border-top: 1px solid rgba(31, 41, 51, 0.08);
        }

        .achievement-date--pending {
            font-style: italic;
            color: #9ca3af;
            border-top-color: rgba(31, 41, 51, 0.06);
        }

    </style>

    <div class="dashboard-container">

        <!-- Основной контент -->
        <main class="dashboard-main">
            <!-- Левая колонка: Быстрые действия -->
            <aside class="sidebar">
                <div class="quick-actions">
                    <h3>Быстрые действия</h3>
                    <a href="<?php echo e(route('learning.review.due')); ?>" class="btn action-btn primary">
                        <span class="action-icon">⏱</span>
                        <span class="action-text">Повторить иероглифы (<?php echo e($dueCardsTotal); ?>)</span>
                    </a>
                    <a href="<?php echo e(route('learning.select-level')); ?>" class="action-btn">
                        <span class="action-text">Изучать новые</span>
                    </a>
                    <a href="<?php echo e(route('collections.index')); ?>" class="action-btn">
                        <span class="action-text">Мои коллекции</span>
                    </a>
                    <a href="<?php echo e(route('articles.index')); ?>" class="action-btn">
                        <span class="action-text">Читать статьи</span>
                    </a>
                </div>

                <!-- Статистика -->
                <div class="sidebar-stats">
                    <h3>Общая статистика</h3>
                    <div class="stat-item">
                        <span class="stat-label">Выучено всего:</span>
                        <span class="stat-value"><?php echo e($reviewStats['total_learned'] ?? 0); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Повторений:</span>
                        <span class="stat-value"><?php echo e($reviewStats['total_reviews'] ?? 0); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Точность:</span>
                        <span class="stat-value"><?php echo e(round($reviewStats['average_success_rate'] ?? 0)); ?>%</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Серия дней:</span>
                        <span class="stat-value"><?php echo e((int) (Auth::user()->study_streak ?? 0)); ?></span>
                    </div>
                </div>

                <?php if(isset($sortedAchievements) && $sortedAchievements->isNotEmpty()): ?>
                <div class="achievements-section">
                    <h3>Достижения</h3>
                    <div class="achievements-slider-wrap" id="achievementsSliderWrap">
                        <div class="achievements-slider" id="achievementsSlider" role="list">
                            <?php $__currentLoopData = $sortedAchievements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achievement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $earnedAt = $earnedAtByAchievementId[$achievement->id] ?? null;
                                    $isEarned = $earnedAt !== null;
                                ?>
                                <div class="achievement-slide" role="listitem">
                                    <article class="achievement-card <?php echo e($isEarned ? 'earned' : 'locked'); ?>">
                                        <div class="achievement-card-top">
                                            <div class="achievement-icon" aria-hidden="true"><?php echo e($achievement->icon); ?></div>
                                            <div class="achievement-body">
                                                <div class="achievement-name"><?php echo e($achievement->name); ?></div>
                                                <div class="achievement-desc"><?php echo e($achievement->description); ?></div>
                                            </div>
                                        </div>
                                        <?php if($isEarned): ?>
                                            <div class="achievement-date">
                                                Получено <?php echo e(\Illuminate\Support\Carbon::parse($earnedAt)->format('d.m.Y')); ?>

                                            </div>
                                        <?php else: ?>
                                            <div class="achievement-date achievement-date--pending">Ещё не получено</div>
                                        <?php endif; ?>
                                    </article>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

            </aside>

            <!-- Центральная колонка: Основная информация -->
            <section class="main-content">
                <!-- Приветствие -->
                <div class="welcome-section">
                    <h2>Добро пожаловать, <?php echo e(Auth::user()->name); ?>!</h2>
                    <p>Сегодня у вас <strong><?php echo e($dueCardsTotal); ?></strong> иероглифов для повторения</p>
                </div>

                <!-- Прогресс по уровням HSK -->
                <div class="hsk-progress-section">
                    <h3>Прогресс по уровням HSK</h3>
                    <div class="hsk-levels">
                        <?php for($level = 1; $level <= 6; $level++): ?>
                            <div class="hsk-level-card">
                                <div class="hsk-header">
                                    <h4>HSK <?php echo e($level); ?></h4>
                                    <span class="hsk-count">
                                        <?php echo e($hskStats[$level]['learned'] ?? 0); ?>/<?php echo e($hskStats[$level]['total'] ?? 0); ?>

                                    </span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" 
                                         style="width: <?php echo e($hskStats[$level]['progress'] ?? 0); ?>%">
                                    </div>
                                </div>
                                <div class="hsk-progress-text">
                                    <?php echo e($hskStats[$level]['progress'] ?? 0); ?>%
                                </div>
                                <a href="<?php echo e(route('learning.level', $level)); ?>" class="hsk-action-btn">
                                    Изучать
                                </a>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

              

                <!-- Иероглифы для повторения сегодня -->
                <div class="due-cards-section">
                    <h3>Иероглифы для повторения сегодня</h3>
                    <?php if($dueCards->count() > 0): ?>
                        <div class="due-cards-grid">
                            <?php $__currentLoopData = $dueCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="due-card">
                                    <div class="due-card-character">
                                        <?php echo e($card->character->character); ?>

                                    </div>
                                    <div class="due-card-info">
                                        <div class="due-card-pinyin"><?php echo e($card->character->pinyin); ?></div>
                                        <div class="due-card-meaning"><?php echo e($card->character->meaning); ?></div>
                                        <div class="due-card-meta">
                                            <span class="due-card-level">HSK <?php echo e($card->character->hsk_level); ?></span>
                                            <span class="due-card-time">
                                                <?php echo e($card->next_review_at->diffForHumans()); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="pagination">
                            <?php echo e($dueCards->links('vendor.pagination.my-pagination')); ?>

                        </div>
                        
                        <a href="<?php echo e(route('learning.review.due')); ?>" class="btn action-btn primary">
                            <span class="action-icon">⏱</span>
                            <span class="action-text">Повторить иероглифы (<?php echo e($dueCardsTotal); ?>)</span>
                        </a>
                
                    <?php else: ?>
                        <div class="no-cards-message">
                            Отличная работа! Сегодня нет иероглифов для повторения.
                            <a href="<?php echo e(route('learning.select-level')); ?>">Изучите новые иероглифы</a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Правая колонка: Коллекции и активность -->
            <aside class="right-sidebar">
                <!-- Мои коллекции -->
                <div class="collections-section">
                    <div class="section-header">
                        <h3>Мои коллекции</h3>
                        <a href="<?php echo e(route('collections.create')); ?>" class="add-collection-btn">+</a>
                    </div>
                    <?php if(isset($collections) && $collections->count() > 0): ?>
                        <div class="collections-list">
                            <?php $__currentLoopData = $collections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="collection-item">
                                    <div class="collection-info">
                                        <h4 class="collection-name"><?php echo e($collection->name); ?></h4>
                                        <span class="collection-count">
                                            <?php echo e($collection->characters_count ?? 0); ?> иероглифов
                                        </span>
                                    </div>
                                    <div class="collection-actions">
                                        <a href="<?php echo e(route('collections.show', $collection)); ?>" 
                                           class="collection-view-btn">Открыть</a>
                                        <a href="<?php echo e(route('collections.review', $collection)); ?>" 
                                           class="action-btn primary">Повторить</a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="no-collections">
                            <p>У вас пока нет коллекций</p>
                            <a href="<?php echo e(route('collections.create')); ?>" class="create-collection-btn">
                                Создать первую коллекцию
                            </a>
                        </div>
                    <?php endif; ?>
                </div>


                <script>
                    (function () {
                        var wrap = document.getElementById('achievementsSliderWrap');
                        var el = document.getElementById('achievementsSlider');
                        if (!wrap || !el) return;
                        function sync() {
                            wrap.classList.toggle('is-scrollable', el.scrollWidth > el.clientWidth + 2);
                        }
                        sync();
                        el.addEventListener('scroll', sync);
                        window.addEventListener('resize', sync);
                    })();
                </script>
            <?php endif; ?>
            </aside>
        </main>

        <!-- Подвал -->
        <footer class="dashboard-footer">
            <div class="footer-content">
                <p>KanjiFlow © 2026 - Система изучения китайских иероглифов</p>
                <div class="footer-links">
                    <a href="#">Помощь</a>
                    <a href="#">О проекте</a>
                    <a href="#">Контакты</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Простая анимация для прогресс-баров
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.hsk-level-card .progress-fill').forEach(function(bar) {
                var width = bar.style && bar.style.width;
                if (!width && bar.getAttribute('style')) {
                    var m = bar.getAttribute('style').match(/width\s*:\s*([^;]+)/i);
                    if (m) {
                        width = m[1].trim();
                    }
                }
                if (!width) {
                    return;
                }
                bar.style.width = '0';
                setTimeout(function() {
                    bar.style.transition = 'width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1)';
                    bar.style.width = width;
                }, 80);
            });
        });

        // Уведомления
        <?php if(session('success')): ?>
            showNotification('<?php echo e(session('success')); ?>', 'success');
        <?php endif; ?>

        <?php if(session('error')): ?>
            showNotification('<?php echo e(session('error')); ?>', 'error');
        <?php endif; ?>

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;
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

document.addEventListener('DOMContentLoaded', function() {
    // Находим все ссылки пагинации
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            let url = this.getAttribute('href');
            
            // Показываем загрузку
            document.querySelector('.due-cards-grid').style.opacity = '0.5';
            
            // Загружаем новую страницу
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                // Обновляем весь блок
                let temp = document.createElement('div');
                temp.innerHTML = html;
                
                let newGrid = temp.querySelector('.due-cards-grid');
                let newPagination = temp.querySelector('.pagination');
                
                if (newGrid) document.querySelector('.due-cards-grid').innerHTML = newGrid.innerHTML;
                if (newPagination) document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
                
                document.querySelector('.due-cards-grid').style.opacity = '1';
                
                // Обновляем обработчики
                attachHandlers();
            });
        });
    });
    
    function attachHandlers() {
        document.querySelectorAll('.pagination a').forEach(link => {
            link.removeEventListener('click', clickHandler);
            link.addEventListener('click', clickHandler);
        });
    }
    
    function clickHandler(e) {
        e.preventDefault();
        let url = this.getAttribute('href');
        
        document.querySelector('.due-cards-grid').style.opacity = '0.5';
        
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                let temp = document.createElement('div');
                temp.innerHTML = html;
                
                let newGrid = temp.querySelector('.due-cards-grid');
                let newPagination = temp.querySelector('.pagination');
                
                if (newGrid) document.querySelector('.due-cards-grid').innerHTML = newGrid.innerHTML;
                if (newPagination) document.querySelector('.pagination').innerHTML = newPagination.innerHTML;
                
                document.querySelector('.due-cards-grid').style.opacity = '1';
                attachHandlers();
            });
    }
    
    attachHandlers();
});
        
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /home/c/cy906984/kanjilflow_public/public_html/resources/views/user/dashboard.blade.php ENDPATH**/ ?>