<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js', 'resources/css/index.css'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            transition: all 0.3s ease;
            padding-top: 60px;
            /* espaço para botão fixo */
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            height: 100vh;
            width: 250px;
            background-color: #343a40;
            color: white;
            transition: left 0.3s ease;
            padding-top: 60px;
            z-index: 1050;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar.show {
            left: 0;
        }

        .menu-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background-color: transparent;
            border: none;
            font-size: 1.8rem;
            color: white;
        }

        .main-content {
            margin-left: 0;
            padding: 1rem;
            transition: margin-left 0.3s ease;
        }

        .main-content.shifted {
            margin-left: 250px;
        }

        footer {
            margin-top: 2rem;
            padding: 1rem;
            text-align: center;
        }

        /* Responsivo: sidebar fixa em telas grandes */
        @media (min-width: 992px) {
            .sidebar {
                left: 0;
            }

            .menu-toggle {
                display: none;
            }

            .main-content {
                margin-left: 250px !important;
            }
        }
    </style>
</head>

<body data-bs-theme="dark">
    <!-- Botão Sanduíche -->
    <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu lateral">
        <i class="bi bi-list" id="menuIcon"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="/">🏠 SulaLingerie</a>
        <a href="/product">📦 Produtos</a>
        <a href="/supplier">🚚 Fornecedores</a>
        <a href="/report">📊 Relatório de Vendas</a>
        <hr>
        <button id="themeToggle" class="btn btn-outline-light w-100 mb-2">
            <ion-icon id="themeIcon" name="moon"></ion-icon> Alternar Tema
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
                🔒 Logout
            </button>
        </form>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content" id="mainContent">
        @yield('content')
        <footer>
            DEV &copy; 2025
        </footer>
    </div>

    <!-- Script alternância de tema e menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');
            const body = document.body;
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const menuIcon = document.getElementById('menuIcon');

            function applyTheme(theme) {
                body.setAttribute('data-bs-theme', theme);
                icon.setAttribute('name', theme === 'dark' ? 'moon' : 'sunny');
                if (menuIcon) {
                    menuIcon.style.color = theme === 'dark' ? 'white' : 'black';
                }
            }

            const savedTheme = localStorage.getItem('theme') || 'dark';
            applyTheme(savedTheme);

            toggleBtn.addEventListener('click', () => {
                const currentTheme = body.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                applyTheme(newTheme);
                localStorage.setItem('theme', newTheme);
            });

            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                mainContent.classList.toggle('shifted');
            });
        });
    </script>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @stack('scripts')
</body>

</html>
