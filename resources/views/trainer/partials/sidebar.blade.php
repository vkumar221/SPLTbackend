<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{url('trainer/dashboard')}}" class="b-brand text-primary">
                <img src="{{ asset(config('constants.admin_path').'images/sidelogo.png') }}" class="img-fluid logo-lg" alt="logo dd" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{route('trainer.dashboard-page')}}" class="pc-link @if(isset($set) && $set == 'dashboard') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/overview-white.svg') }}" alt="overview.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/overview-blue.svg') }}" alt="overview.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Dashboard">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('trainer.clients')}}" class="pc-link @if(isset($set) && $set == 'clients') active @endif">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/users.svg')}}" alt="users">
                        </span>
                        <span class="pc-mtext" data-i18n="Clients">Clients</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('trainer.workout-plans')}}" class="pc-link @if(isset($set) && $set == 'workout_plans') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/files.svg') }}" alt="files.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/files-b.svg') }}" alt="files.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Workout Plans">Workout Plans</span>
                    </a>
                </li>
                {{-- <li class="pc-item">
                    <a href="{{route('trainer.workouts')}}" class="pc-link @if(isset($set) && $set == 'workouts') active @endif">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/exercise.svg')}}" alt="exercise">
                        </span>
                        <span class="pc-mtext" data-i18n="Exercise Library">Exercise Library</span>
                    </a>
                </li> --}}
                <li class="pc-item">
                    <a href="{{route('trainer.certificates')}}" class="pc-link @if(isset($set) && $set == 'certificates') active @endif">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/achievements.svg') }}" alt="achievements.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Cerificates">Cerificates</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{url('trainer/videos')}}" class="pc-link @if(isset($set) && $set == 'videos') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/videos.svg') }}" alt="files.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/videos.svg')}}" alt="videos">
                        </span>
                        <span class="pc-mtext" data-i18n="Videos Management">Videos Management</span>
                    </a>
                </li>
                {{--
                <li class="pc-item pc-hasmenu">
                    <a href="javascript:void(0)" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/cart-white.svg')}}" alt="product.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Product Management">Product Management</span>
                        <span class="pc-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="product-management.html" data-i18n="ProductList">Product List</a></li>
                        <li class="pc-item"><a class="pc-link" href="attributes.html" data-i18n="Attributes">Attributes</a></li>
                        <li class="pc-item"><a class="pc-link" href="add-downloadable-files.html" data-i18n="DownloadableFiles">Downloadable Files</a></li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="stock-inventory.html" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/stock-white.svg')}}" alt="stock">
                        </span>
                        <span class="pc-mtext" data-i18n="Stock & Inventory">Stock & Inventory</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/affiliate.svg')}}" alt="affiliate">
                        </span>
                        <span class="pc-mtext" data-i18n="Affiliate">Affiliate</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/reports-white.svg')}}" alt="reports.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Business Reports">Business Reports</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="videos-management.html" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/videos.svg')}}" alt="videos">
                        </span>
                        <span class="pc-mtext" data-i18n="Videos Management">Videos Management</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="newsletter.html" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/newsletter.svg')}}" alt="newsletter.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Newsletter">Newsletter</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/review-white.svg')}}" alt="review.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Reviews Management">Reviews Management</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="settings.html" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/settings.svg')}}" alt="settings.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Settings">Settings</span>
                    </a>
                </li> --}}
                <li class="pc-item">
                    <a href="{{url('trainer/logout')}}" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/logout.svg')}}" alt="logout.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Logout">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
