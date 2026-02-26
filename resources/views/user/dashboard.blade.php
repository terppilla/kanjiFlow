<x-app-layout>
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
        }

        /* ===== ШАПКА ДАШБОРДА ===== */
        .dashboard-header {
            background: var(--color-dark-blue);
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border-bottom: 3px solid var(--color-primary);
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
            grid-template-columns: 300px 1fr 320px;
            gap: 2rem;
            padding: 2.5rem 3rem;
            max-width: 1920px;
            margin: 0 auto;
            min-height: calc(100vh - 180px);
        }

        @media (max-width: 1400px) {
            .dashboard-main {
                grid-template-columns: 280px 1fr;
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
                grid-template-columns: 1fr;
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
            width: calc(50% - 0.35rem);
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
        }

        .collection-view-btn,
        .collection-review-btn {
            flex: 1;
            text-align: center;
            padding: 0.6rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .collection-view-btn {
            background: rgba(214, 155, 100, 0.1);
            color: var(--color-gold);
            border: 1px solid rgba(214, 155, 100, 0.2);
        }

        .collection-view-btn:hover {
            background: var(--color-white-gold);
            color: var(--color-dark-red);
            border-color: var(--color-gold);
        }

        .collection-review-btn {
            background: var(--color-success);
            color: white;
            border: 1px solid var(--color-success);
        }

        .collection-review-btn:hover {
            background: #0da271;
            border-color: #0da271;
            transform: translateY(-2px);
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
            .collection-review-btn {
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
    </style>

    <div class="dashboard-container">

        <!-- Основной контент -->
        <main class="dashboard-main">
            <!-- Левая колонка: Быстрые действия -->
            <aside class="sidebar">
                <div class="quick-actions">
                    <h3>Быстрые действия</h3>
                    {{-- <a href="{{ route('review.show') }}" class="action-btn primary">
                        <span class="action-icon">⏱</span>
                        <span class="action-text">Повторить иероглифы ({{ $dueCards->count() }})</span>
                    </a> --}}
                    <a href="{{ route('learning.select-level') }}" class="action-btn">
                        <span class="action-text">Изучать новые</span>
                    </a>
                    <a href="{{ route('collections.index') }}" class="action-btn">
                        <span class="action-text">Мои коллекции</span>
                    </a>
                    {{-- <a href="{{ route('review.select-level') }}" class="action-btn">
                        <span class="action-text">Тренировать по HSK</span>
                    </a> --}}
                </div>

                <!-- Статистика -->
                <div class="sidebar-stats">
                    <h3>Общая статистика</h3>
                    <div class="stat-item">
                        <span class="stat-label">Выучено всего:</span>
                        <span class="stat-value">{{ $reviewStats['total_learned'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Повторений:</span>
                        <span class="stat-value">{{ $reviewStats['total_reviews'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Точность:</span>
                        <span class="stat-value">{{ round($reviewStats['average_success_rate'] ?? 0) }}%</span>
                    </div>
                </div>
            </aside>

            <!-- Центральная колонка: Основная информация -->
            <section class="main-content">
                <!-- Приветствие -->
                <div class="welcome-section">
                    <h2>Добро пожаловать, {{ Auth::user()->name }}!</h2>
                    <p>Сегодня у вас <strong>{{ $dueCards->count() }}</strong> иероглифов для повторения</p>
                </div>

                <!-- Прогресс по уровням HSK -->
                <div class="hsk-progress-section">
                    <h3>Прогресс по уровням HSK</h3>
                    <div class="hsk-levels">
                        @for($level = 1; $level <= 6; $level++)
                            <div class="hsk-level-card">
                                <div class="hsk-header">
                                    <h4>HSK {{ $level }}</h4>
                                    <span class="hsk-count">
                                        {{ $hskStats[$level]['learned'] ?? 0 }}/{{ $hskStats[$level]['total'] ?? 0 }}
                                    </span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" 
                                         style="width: {{ $hskStats[$level]['progress'] ?? 0 }}%">
                                    </div>
                                </div>
                                <div class="hsk-progress-text">
                                    {{ $hskStats[$level]['progress'] ?? 0 }}%
                                </div>
                                <a href="{{ route('learning.level', $level) }}" class="hsk-action-btn">
                                    Изучать
                                </a>
                                {{-- <a href="{{ route('review.hsk', $level) }}" class="hsk-review-btn">
                                    Повторить
                                </a> --}}
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Иероглифы для повторения сегодня -->
                <div class="due-cards-section">
                    <h3>Иероглифы для повторения сегодня</h3>
                    @if($dueCards->count() > 0)
                        <div class="due-cards-grid">
                            @foreach($dueCards->take(10) as $card)
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
                        @if($dueCards->count() > 10)
                            <div class="view-all-container">
                                <a href="{{ route('review.show') }}" class="view-all-btn">
                                    Показать все ({{ $dueCards->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="no-cards-message">
                            Отличная работа! Сегодня нет иероглифов для повторения.
                            <a href="{{ route('learning.select-level') }}">Изучите новые иероглифы</a>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Правая колонка: Коллекции и активность -->
            <aside class="right-sidebar">
                <!-- Мои коллекции -->
                <div class="collections-section">
                    <div class="section-header">
                        <h3>Мои коллекции</h3>
                        <a href="{{ route('collections.create') }}" class="add-collection-btn">+</a>
                    </div>
                    @if(isset($collections) && $collections->count() > 0)
                        <div class="collections-list">
                            @foreach($collections as $collection)
                                <div class="collection-item">
                                    <div class="collection-info">
                                        <h4 class="collection-name">{{ $collection->name }}</h4>
                                        <span class="collection-count">
                                            {{ $collection->characters_count ?? 0 }} иероглифов
                                        </span>
                                    </div>
                                    <div class="collection-actions">
                                        <a href="{{ route('collections.show', $collection) }}" 
                                           class="collection-view-btn">Открыть</a>
                                        <a href="{{ route('collections.review', $collection) }}" 
                                           class="collection-review-btn">Повторить</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-collections">
                            <p>У вас пока нет коллекций</p>
                            <a href="{{ route('collections.create') }}" class="create-collection-btn">
                                Создать первую коллекцию
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Последняя активность -->
                <div class="recent-activity">
                    <h3>Последняя активность</h3>
                    {{-- <div class="activity-list">
                        <div class="activity-item">
                            <span class="activity-text">Начали изучение HSK 1</span>
                            <span class="activity-time">2 часа назад</span>
                        </div>
                        <div class="activity-item">
                            <span class="activity-text">Выучили 5 новых иероглифов</span>
                            <span class="activity-time">Вчера</span>
                        </div>
                        <div class="activity-item">
                            <span class="activity-text">Достигли точности 85%</span>
                            <span class="activity-time">3 дня назад</span>
                        </div> --}}
                    </div>
                </div>
            </aside>
        </main>

        <!-- Подвал -->
        <footer class="dashboard-footer">
            <div class="footer-content">
                <p>KanjiFlow © 2024 - Система изучения китайских иероглифов</p>
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
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1.2s cubic-bezier(0.34, 1.56, 0.64, 1)';
                    bar.style.width = width;
                }, 100);
            });
        });

        // Уведомления
        @if(session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif

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
    </script>
</x-app-layout>