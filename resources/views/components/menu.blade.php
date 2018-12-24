@section('menu')
    <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownDemandes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Demandes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownDemandes">
                        <a class="dropdown-item" href="/nouvelledemande"><span style="font-size:1em; color:#6a003e" class="fas fa-file-alt fa-fw"></span> @lang('validation.custom.new_request')</a>
    <a class="dropdown-item" href="/selection"><span style="font-size:1em" class="fas fa-edit fa-fw color-tessi-fonce"></span> @lang('validation.custom.pending_requests')</a>
    <a class="dropdown-item" href="#"><span style="font-size:1em" class="fas fa-archive fa-fw color-tessi-fonce"></span> @lang('validation.custom.archived_requests')</a>
    </div>
    </li>
    <li class="nav-item"> <a class="nav-link" href="#">@lang('validation.custom.benefits')</a> </li>
    <li class="nav-item disabled"> <a class="nav-link" href="#">@lang('validation.custom.statistics')</a> </li>
    <li class="nav-item"> <a class="nav-link" href="#">@lang('validation.custom.documentation')</a> </li>
    @if ($role == "admin")
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdministration" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @lang('validation.custom.administration')
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownAdministration">
                <a class="dropdown-item" href="/accounts">@lang('validation.custom.accounts_managment')</a>
                <a class="dropdown-item" href="/logs" target="_blank">Logs</a>
            </div>
        </li>
        @endif

        </ul>
        </div>
        <form class="form-inline my-2 my-lg-0">
            <input class="mr-sm-2 form-control" type="search" placeholder="Recherche" arial-label="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><span style="font-size:1em" class="fas fa-search color-tessi-fonce"></span> @lang('validation.custom.search')</button>
        </form>
@endsection