<!DOCTYPE html>
<html lang="{{  str_replace('_', '-', app()->getLocale())  }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body data-bs-theme="dark">
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">SulaLingerie</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/product">Produtos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/supplier">Fornecedores</a>
                        </li>
                        <li class="nav-item">
                            <a href="/report" class="nav-link">Relatório de Vendas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <button id="themeToggle" class="btn btn-outline-secondary">
                        <ion-icon id="themeIcon" name="moon"></ion-icon>
                    </button>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </nav>
    </header>
    @yield('content')
    <footer>
        DEV &copy; 2025
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('themeToggle');
            const icon = document.getElementById('themeIcon');
            const body = document.body;

            function applyTheme(theme) {
                body.setAttribute('data-bs-theme', theme);
                icon.setAttribute('name', theme === 'dark' ? 'moon' : 'sunny');
            }

            const savedTheme = localStorage.getItem('theme') || 'dark';
            applyTheme(savedTheme);

            toggleBtn.addEventListener('click', () => {
                const currentTheme = body.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                applyTheme(newTheme);
                localStorage.setItem('theme', newTheme);
            });
        });
    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @stack('scripts')
</body>

</html>
