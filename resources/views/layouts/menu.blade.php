<nav class="navbar navbar-expand-lg navbar-light al-navbar" style="background-color: #e6e6e6">
    <div class="container">
        <a class="navbar-brand" href="#">App Truck</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#primaryNav"
            aria-controls="primaryNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="primaryNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Viajar <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('veiculos/cadastro') }}">Veículos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Viagens</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Ganhos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Gastos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cofrinho Manutenção</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" id="navbarDropdown">
                        <i class="fa fa-envelope" aria-hidden="true">
                            <span class="badge badge-secondary">0</span>
                        </i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <p class="dropdown-item"> Sem Notificações</p>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Minha Conta
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"><i class="fa fa-fw fa-user"></i> Perfil</a>
                        <a class="dropdown-item" href="{{ url('usuarios', ['login']) }}"><i
                                class="fa fa-fw fa-close"></i> Sair</a>
                    </div>
                </li>
            </ul>


        </div>
    </div>
</nav>