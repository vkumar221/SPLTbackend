<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{url('vendor/dashboard')}}" class="b-brand text-primary">
                <img src="{{ asset(config('constants.admin_path').'images/sidelogo.png') }}" class="img-fluid logo-lg" alt="logo dd" />
            </a>
        </div>
        <div class="navbar-content">

            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{route('vendor.dashboard-page')}}" class="pc-link @if(isset($set) && $set == 'dashboard') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/overview-white.svg') }}" alt="overview.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/overview-blue.svg') }}" alt="overview.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Overview">Overview</span>
                    </a>
                </li>
                {{-- <li class="pc-item">
                    <a href="order-management.html" class="pc-link">
                        <span class="pc-micon">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/order-white.svg') }}" alt="order.svg">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/order-blue.svg') }}" alt="order.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Order Management">Order Management</span>
                    </a>
                </li> --}}

                <li class="pc-item pc-hasmenu @if(isset($set) && $set == 'attributes' || isset($set) && $set == 'products') pc-trigger @endif">
                    <a href="javascript:void(0)" class="pc-link @if(isset($set) && $set == 'attributes') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/product-white.svg') }}" alt="product.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/product-blue.png') }}" alt="product.png">
                        </span>
                        <span class="pc-mtext" data-i18n="Product Management">Product Management</span>
                        <span class="pc-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item @if(isset($set) && $set == 'products') active @endif"><a class="pc-link" href="{{route('vendor.products')}}" data-i18n="ProductList">Product List</a></li>
                        {{-- <li class="pc-item"><a class="pc-link" href="add-downloadable-files.html" data-i18n="DownloadableFiles">Downloadable Files</a></li> --}}
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="{{route('vendor.inventory')}}" class="pc-link @if(isset($set) && $set == 'inventory') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/stock-white.svg') }}" alt="stock.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/stock-blue.svg') }}" alt="stock.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Stock & Inventory">Stock & Inventory</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{url('vendor/orders')}}" class="pc-link @if(isset($set) && $set == 'orders') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/order-white.svg') }}" alt="order.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/order-blue.svg') }}" alt="order.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Order Management">Order Management</span>
                    </a>
                </li>
                {{-- <li class="pc-item">
                    <a href="reviews-management.html" class="pc-link">
                        <span class="pc-micon">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/review-white.svg') }}" alt="review.svg">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/review-blue.svg') }}" alt="review.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Reviews Management">Reviews Management</span>
                    </a>
                </li> --}}

                {{-- <li class="pc-item">
                    <a href="stock-inventory.html" class="pc-link">
                        <span class="pc-micon">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/stock-white.svg') }}" alt="stock.svg">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/stock-blue.svg') }}" alt="stock.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Stock & Inventory">Stock & Inventory</span>
                    </a>
                </li> --}}

                {{-- <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/affiliate.svg') }}" alt="affiliate.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Affiliate">Affiliate</span>
                    </a>
                </li> --}}
                {{-- <li class="pc-item">
                    <a href="business-reports.html" class="pc-link">
                        <span class="pc-micon">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/reports-white.svg') }}" alt="reports.svg">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/reports-blue.svg') }}" alt="reports.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Business Reports">Business Reports</span>
                    </a>
                </li> --}}
                {{-- <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/automated.svg') }}" alt="automated.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Automated Order Updates">Automated Order Updates</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="issue-withdraw.html" class="pc-link">
                        <span class="pc-micon">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/transactions-white.svg') }}" alt="transactions.svg">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/transactions-blue.svg') }}" alt="transactions.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Transactions">Transactions</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/newsletter.svg') }}" alt="newsletter.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Newsletter">Newsletter</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/workouts.svg') }}" alt="workouts.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Workouts">Workouts</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/trainers.svg') }}" alt="trainers.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Trainers">Trainers</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/achievements.svg') }}" alt="achievements.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Achievements">Achievements</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/violation.svg') }}" alt="violation.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Violation">Violation</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="profile.html" class="pc-link">
                        <span class="pc-micon">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/customers-white.svg') }}" alt="customers.svg">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/customers-blue.svg') }}" alt="customers.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Customers">Customers</span>
                    </a>
                </li> --}}
                {{-- <li class="pc-item">
                    <a href="#!" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/settings.svg') }}" alt="settings.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Settings">Settings</span>
                    </a>
                </li> --}}
                <li class="pc-item">
                    <a href="{{url('vendor/logout')}}" class="pc-link">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/logout.svg') }}" alt="logout.svg">
                        </span>
                        <span class="pc-mtext text-danger" data-i18n="Logout">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
