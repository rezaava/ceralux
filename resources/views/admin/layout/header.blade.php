<!-- Mobile Hamburger Button -->
<style>
    .submenu .nav-link {
        font-size: 0.9rem;
        /* کوچیک‌تر از متن اصلی */
        padding-left: 1.5rem;
        /* کمی فاصله برای زیبایی */
    }

    #add-list:hover {
        width: 90%;
    }

    #show-list:hover {
        width: 90%;
    }
</style>
<button class="mobile-menu-btn" id="mobileMenuBtn" style="display:none;">
    <i class="fas fa-bars"></i>
</button>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo" id="sidebarLogo">
            <i class="fas fa-store"></i>
            <span class="sidebar-title">پنل فروشگاه</span>
        </div>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="fas fa-home"></i>
                <span class="menu-label">داشبورد</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-users"></i>
                <span class="menu-label">کاربران</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-flask"></i>
                <span class="menu-label">آزمایشات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-file-alt"></i>
                <span class="menu-label">گزارشات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-percent"></i>
                <span class="menu-label">درصدها</span>
            </a>
        </li>
    </ul>
</div>
<!-- Offcanvas Sidebar for Mobile -->
<div class="sidebar offcanvas-mobile" id="offcanvasSidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-file-invoice-dollar"></i>
            <span class="sidebar-title">{{__('messages.name_invocie') }}</span>
        </div>
        <button class="close-offcanvas d-md-none" id="closeOffcanvasBtn"><i class="fas fa-times"></i></button>
    </div>
    
        <ul class="nav flex-column">
        @if (Auth::user()->hasRole('manager'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="/admin/dashboard">
                    <i class="fas fa-home"></i>
                    <span class="menu-label">داشبورد</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('size') ? 'active' : '' }}" href="/admin/size">
                    <i class="fa-solid fa-maximize"></i>
                    <span class="menu-label">سایز ها</span>
                </a>
            </li>
            @endif
            @if (Auth::user()->hasRole('adminSocialMedia') || Auth::user()->hasRole('manager') || Auth::user()->hasRole('adminWorker'))
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center {{ request()->is('admin/product*') ? 'active' : '' }}"
                        data-bs-toggle="collapse" href="#productMenu" role="button"
                        aria-expanded="{{ request()->is('admin/product*') ? 'true' : 'false' }}" aria-controls="productMenu">
                        <i class="fa-solid fa-boxes-stacked me-2"></i>
                        <span class="menu-label">محصولات</span>
                        <!-- آیکون فلش -->
                        <i style="font-size:0.9rem" class="fa-solid fa-chevron-down ms-auto toggle-icon"></i>
                    </a>

                    <div class="collapse {{ request()->is('admin/product*') ? 'show' : '' }}" id="productMenu"
                        style="border-right: 2px solid #fff;margin-right: 1.6rem">
                        <ul class="nav flex-column ms-3 submenu" style="list-style-type: disc ; padding-right: 1.4rem">
                            <li class="nav-item {{ request()->routeIs('product-list') ? 'activeLi' : '' }}">
                                <a class="nav-link {{ request()->routeIs('product-list') ? 'active1' : '' }}"
                                    href="/admin/product/list" id="add-list">لیست محصولات</a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('product-add') ? 'activeLi' : '' }}">
                                <a class="nav-link {{ request()->routeIs('product-add') ? 'active1' : '' }}"
                                    href="/admin/product/add/{$id}" id="show-list">افزودن محصول جدید</a>
                            </li>
                        </ul>
                    </div>

                </li>
            @endif
            @if (Auth::user()->hasRole('manager'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}" href="/admin/catalog">
                    <i class="fas fa-file-alt"></i>
                    <span class="menu-label">کاتالوگ ها</span>
                </a>
            </li>
            @endif
            @if (Auth::user()->hasRole('manager') || Auth::user()->hasRole('adminWorker'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('req') ? 'active' : '' }}" href="/admin/request">
                    <i class="fas fa-file-alt"></i>
                    <span class="menu-label">درخواست ها</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ request()->is('admin/crm*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#productMenu1" role="button"
                    aria-expanded="{{ request()->is('admin/crm*') ? 'true' : 'false' }}" aria-controls="productMenu">
                    <i class="fa-solid fa-boxes-stacked me-2"></i>
                    <span class="menu-label">CRM</span>
                    <!-- آیکون فلش -->
                    <i style="font-size:0.9rem" class="fa-solid fa-chevron-down ms-auto toggle-icon"></i>
                </a>

                <div class="collapse {{ request()->is('admin/crm*') ? 'show' : '' }}" id="productMenu1"
                    style="border-right: 2px solid #fff;margin-right: 1.6rem">
                    <ul class="nav flex-column ms-3 submenu" style="list-style-type: disc ; padding-right: 1.4rem">

                        <li class="nav-item {{ request()->routeIs('buy') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('buy') ? 'active1' : '' }}"
                                href="/admin/crm/buy/add/{id}" id="show-list">فاکتور خرید</a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('lpo') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('lpo') ? 'active1' : '' }}"
                                href="/admin/crm/lpo/add/{id}" id="show-list">ثبت LPO</a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('reqSale') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('reqSale') ? 'active1' : '' }}"
                                href="/admin/crm/reqSale/{id}" id="add-list">فاکتور فروش </a>
                        </li>

                        {{-- <li class="nav-item {{ request()->routeIs('reqSalef') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('reqSalef') ? 'active1' : '' }}"
                                href="/admin/crm/reqSaleF/{id}" id="add-list">فاکتور فروش سریع </a>
                        </li> --}}

                        <li class="nav-item {{ request()->routeIs('reqProd') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('reqProd') ? 'active1' : '' }}"
                                href="/admin/crm/reqProd" id="show-list">درخواست تولید</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('addProd') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('addProd') ? 'active1' : '' }}"
                                href="/admin/crm/addProd" id="show-list"> موجودی انبار </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('listInvocie') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('listInvocie') ? 'active1' : '' }}"
                                href="/admin/crm/listInvocie" id="show-list">لیست فاکتور ها</a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('leave') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('leave') ? 'active1' : '' }}"
                                href="/admin/req/leave" id="show-list">خروج محصول از انبار</a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('sample') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('sample') ? 'active1' : '' }}"
                                href="/admin/req/sample" id="show-list">درخواست نمونه</a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('break') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('break') ? 'active1' : '' }}"
                                href="/admin/req/break" id="show-list">ثبت شکستگی</a>
                        </li>


                    </ul>
                </div>


            </li>
            @endif
            @if(Auth::user()->hasRole('manager'))
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ request()->is('admin/financial*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#productMenu3" role="button"
                    aria-expanded="{{ request()->is('admin/financial*') ? 'true' : 'false' }}" aria-controls="productMenu3">
                    <i class="fa-solid fa-boxes-stacked me-2"></i>
                    <span class="menu-label">مالی</span>
                    <!-- آیکون فلش -->
                    <i style="font-size:0.9rem" class="fa-solid fa-chevron-down ms-auto toggle-icon"></i>
                </a>

                <div class="collapse {{ request()->is('admin/financial*') ? 'show' : '' }}" id="productMenu3"
                    style="border-right: 2px solid #fff;margin-right: 1.6rem">
                    <ul class="nav flex-column ms-3 submenu" style="list-style-type: disc ; padding-right: 1.4rem">
                        <li class="nav-item {{ request()->routeIs('submit') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('submit') ? 'active1' : '' }}"
                                href="/admin/financial/submit/{$id}" id="add-list"> ثبت چک</a>
                        </li>
                         <li class="nav-item {{ request()->routeIs('submitList1') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('submitList1') ? 'active1' : '' }}"
                                href="/admin/financial/submit/show/list" id="add-list"> لیست چک ها</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('received') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('received') ? 'active1' : '' }}"
                                href="/admin/financial/received" id="show-list">دریافتی</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('pay') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('pay') ? 'active1' : '' }}"
                                href="/admin/financial/pay" id="show-list">پرداختی</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('listPay') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('listPay') ? 'active1' : '' }}"
                                href="/admin/financial/list" id="show-list">صورت حساب  ها</a>
                        </li>
                    </ul>
                </div>


            </li>
            @endif
            @if(Auth::user()->hasRole('manager') || Auth::user()->hasRole('adminWorker'))
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center {{ request()->is('admin/user*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#productMenu2" role="button"
                    aria-expanded="{{ request()->is('admin/user*') ? 'true' : 'false' }}" aria-controls="productMenu">
                    <i class="fa-solid fa-users-between-lines"></i>
                    <span class="menu-label">مشتریان</span>
                    <!-- آیکون فلش -->
                    <i style="font-size:0.9rem" class="fa-solid fa-chevron-down ms-auto toggle-icon"></i>
                </a>

                <div class="collapse {{ request()->is('admin/user*') ? 'show' : '' }}" id="productMenu2"
                    style="border-right: 2px solid #fff;margin-right: 1.6rem">
                    <ul class="nav flex-column ms-3 submenu" style="list-style-type: disc ; padding-right: 1.4rem">
                        <li class="nav-item {{ request()->routeIs('listUser') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('listUser') ? 'active1' : '' }}"
                                href="/admin/user/list" id="add-list">لیست مشتریان</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('addUser') ? 'activeLi' : '' }}">
                            <a class="nav-link {{ request()->routeIs('addUser') ? 'active1' : '' }}"
                                href="/admin/user/add/{id}" id="show-list"> افزودن مشتریان</a>
                        </li>
                    </ul>
                </div>

            </li>
            @endif
            @if(Auth::user()->hasRole('manager'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('setting') ? 'active' : '' }}" href="/admin/setting">
                    <i class="fa-solid fa-sliders"></i>
                    <span class="menu-label">تنظیمات</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fa-solid fa-reply-all"></i>
                    <span class="menu-label">بازگشت به سایت</span>
                </a>
            </li>
        
            <li class="nav-item text-center mt-3 mb-3">
                <a class="btn btn-danger" href="/logout/admin">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span class="menu-label mx-2">خروج</span>
                </a>
            </li>
        </ul>
</div>


<script>
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function (el) {
    el.addEventListener('click', function () {
        const icon = el.querySelector('.toggle-icon');
        const target = document.querySelector(el.getAttribute('href'));

        target.addEventListener('shown.bs.collapse', function () {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        });

        target.addEventListener('hidden.bs.collapse', function () {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        });
    });
});


</script>