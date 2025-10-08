<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{url('admin/dashboard')}}" class="b-brand text-primary">
                <img src="{{ asset(config('constants.admin_path').'images/sidelogo.png') }}" class="img-fluid logo-lg" alt="logo dd" />
            </a>
        </div>
        <div class="navbar-content">

            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="{{route('admin.dashboard-page')}}" class="pc-link @if(isset($set) && $set == 'dashboard') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/overview-white.svg') }}" alt="overview.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/overview-blue.svg') }}" alt="overview.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Overview">Overview</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{url('admin/orders')}}" class="pc-link @if(isset($set) && $set == 'orders') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/order-white.svg') }}" alt="order.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/order-blue.svg') }}" alt="order.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Order Management">Order Management</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('admin.categories')}}" class="pc-link @if(isset($set) && $set == 'categories') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/categories-white.svg') }}" alt="categories.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/categories-blue.svg') }}" alt="categories.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Categories">Categories</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('admin.brands')}}" class="pc-link  @if(isset($set) && $set == 'brands') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/bag-white.svg') }}" alt="brands.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/bag-blue.svg') }}" alt="brands.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Brands Management">Brands Management</span>
                    </a>
                </li>
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
                        <li class="pc-item @if(isset($set) && $set == 'products') active @endif"><a class="pc-link" href="{{route('admin.products')}}" data-i18n="ProductList">Product List</a></li>
                        <li class="pc-item @if(isset($set) && $set == 'attributes') active @endif"><a class="pc-link" href="{{route('admin.attributes')}}" data-i18n="Attributes">Attributes</a></li>
                        {{-- <li class="pc-item"><a class="pc-link" href="add-downloadable-files.html" data-i18n="DownloadableFiles">Downloadable Files</a></li> --}}
                    </ul>
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
                <li class="pc-item">
                    <a href="{{route('admin.promo-codes')}}" class="pc-link @if(isset($set) && $set == 'promo_code') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/promo-white.svg') }}" alt="promo.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/promo-blue.svg') }}" alt="promo.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Promo Codes">Promo Codes</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('admin.inventory')}}" class="pc-link @if(isset($set) && $set == 'inventory') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/stock-white.svg') }}" alt="stock.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/stock-blue.svg') }}" alt="stock.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Stock & Inventory">Stock & Inventory</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('admin.vendors')}}" class="pc-link @if(isset($set) && $set == 'vendors') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/vendor-white.svg') }}" alt="vendor.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/vendor-blue.svg') }}" alt="vendor.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Vendor Management">Vendor Management</span>
                    </a>
                </li>
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
                </li>--}}
                <li class="pc-item pc-hasmenu @if(isset($set) && $set == 'exercise_type' || isset($set) && $set == 'equipments' || isset($set) && $set == 'muscle_group' || isset($set) && $set == 'workout_categories' || isset($set) && $set == 'workouts') pc-trigger @endif">
                    <a href="javascript:void(0)" class="pc-link @if(isset($set) && $set == 'attributes') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/workouts.svg') }}" alt="product.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/workouts.svg') }}" alt="product.png">
                        </span>
                        <span class="pc-mtext" data-i18n="Workouts">Workouts</span>
                        <span class="pc-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span>
                    </a>
                    <ul class="pc-submenu">
                        <li class="pc-item @if(isset($set) && $set == 'exercise_type') active @endif"><a class="pc-link" href="{{route('admin.exercise-type')}}" data-i18n="Exercise Type">Exercise Type</a></li>
                        <li class="pc-item @if(isset($set) && $set == 'equipments') active @endif"><a class="pc-link" href="{{route('admin.equipment')}}" data-i18n="Equipments">Equipments</a></li>
                        <li class="pc-item @if(isset($set) && $set == 'muscle_group') active @endif"><a class="pc-link" href="{{route('admin.muscle-group')}}" data-i18n="Muscle Group">Muscle Group</a></li>
                        <li class="pc-item @if(isset($set) && $set == 'workout_category') active @endif"><a class="pc-link" href="{{route('admin.workout-categories')}}" data-i18n="Workout Category">Workout Category</a></li>
                        <li class="pc-item @if(isset($set) && $set == 'workouts') active @endif"><a class="pc-link" href="{{route('admin.workouts')}}" data-i18n="Workout">Workout</a></li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="{{route('admin.workout-plans')}}" class="pc-link @if(isset($set) && $set == 'workout_plans') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/files.svg') }}" alt="files.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/files-b.svg') }}" alt="files.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Workout Plans">Workout Plans</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('admin.trainers')}}" class="pc-link @if(isset($set) && $set == 'trainers') active @endif">
                        <span class="pc-micon">
                            <img src="{{ asset(config('constants.admin_path').'images/icons/trainers.svg') }}" alt="trainers.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Trainers">Trainers</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{route('admin.subscription-plans')}}" class="pc-link @if(isset($set) && $set == 'subscription_plan') active @endif">
                        <span class="pc-micon">
                            <img class="icon-active" src="{{ asset(config('constants.admin_path').'images/icons/reports-white.svg') }}" alt="reports.svg">
                            <img class="icon-default" src="{{ asset(config('constants.admin_path').'images/icons/reports-blue.svg') }}" alt="reports.svg">
                        </span>
                        <span class="pc-mtext" data-i18n="Subscription Plans">Subscription Plan</span>
                    </a>
                </li>
                {{--
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
                    <a href="{{url('admin/logout')}}" class="pc-link">
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
