<div class="page-sidebar">
    <div class="main-header-left d-none d-lg-block">
        <div class="logo-wrapper">
            <a href="{{route('admin.dashboard')}}">
                <img class="d-none d-lg-block blur-up lazyloaded"
                    src="{{url('../public/assets')}}/images/dashboard/multikart-logo.png" alt="">
            </a>
        </div>
    </div>
    <div class="sidebar custom-scrollbar">
        <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times"
                aria-hidden="true"></i></a>
        <div class="sidebar-user">
            <img class="img-60" src="{{url('../public/assets')}}/images/dashboard/user3.jpg" alt="#">
            <div>
                <h6 class="f-14">الوسيط</h6>
                <p> لوحة التحكم.</p>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a class="sidebar-header" href="{{route('admin.dashboard')}}">
                    <i data-feather="home"></i>
                    <span>لوحة التحكم</span>
                </a>
            </li>

            <li>
                <a class="sidebar-header" href="javascript:void(0)">
                    <i data-feather="box"></i>
                    <span>الأقسام</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{route('SuperCategory.all')}}">
                            <i class="fa fa-circle"></i>
                            <span>تصنيف عام</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('category.all')}}">
                            <i class="fa fa-circle"></i>
                            <span>تصنيف الرئيسي</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('subcategory.all')}}">
                            <i class="fa fa-circle"></i>
                            <span>تصنيف الفرعي</span>
                        </a>
                    </li>
                   
                </ul>
            </li>

            <li>
                <a class="sidebar-header" href="javascript:void(0)">
                    <i data-feather="archive"></i>
                    <span>الدول</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{route('country.all')}}">
                            <i class="fa fa-circle"></i>
                            <span>الدول</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('government.all')}}">
                            <i class="fa fa-circle"></i>
                            <span>المحافظات</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('state.all')}}">
                            <i class="fa fa-circle"></i>
                            <span>المناطق</span>
                        </a>
                    </li>
                </ul>
            </li>
       		<li>
                  <a class="sidebar-header" href="javascript:void(0)">
                      <i data-feather="archive"></i>
                      <span>نصائح</span>
                      <i class="fa fa-angle-right pull-right"></i>
                  </a>

                  <ul class="sidebar-submenu">
                      <li>
                          <a href="{{route('Teps.all')}}">
                              <i class="fa fa-circle"></i>
                              <span>النصائح</span>
                          </a>
                      </li>

                  </ul>
            </li>
          	<li>
                  <a class="sidebar-header" href="javascript:void(0)">
                      <i data-feather="archive"></i>
                      <span>طلبات التوثيق</span>
                      <i class="fa fa-angle-right pull-right"></i>
                  </a>

                  <ul class="sidebar-submenu">
                      <li>
                          <a href="{{route('verifyRequest.all')}}">
                              <i class="fa fa-circle"></i>
                              <span> طلبات التوثيق </span>
                          </a>
                      </li>

                  </ul>
            </li>
          	<li>
                  <a class="sidebar-header" href="javascript:void(0)">
                      <i data-feather="archive"></i>
                      <span>سياسة الخصوصية</span>
                      <i class="fa fa-angle-right pull-right"></i>
                  </a>

                  <ul class="sidebar-submenu">
                      <li>
                          <a href="{{route('privacyPolicy.all')}}">
                              <i class="fa fa-circle"></i>
                              <span> سياسة الخصوصية</span>
                          </a>
                      </li>

                  </ul>
            </li>
          	<li>
                  <a class="sidebar-header" href="javascript:void(0)">
                      <i data-feather="archive"></i>
                      <span>الرسائل </span>
                      <i class="fa fa-angle-right pull-right"></i>
                  </a>

                  <ul class="sidebar-submenu">
                      <li>
                          <a href="{{route('ContactUs.all')}}">
                              <i class="fa fa-circle"></i>
                              <span> الرسائل </span>
                          </a>
                      </li>

                  </ul>
            </li>
            <li>
                <a class="sidebar-header" href="javascript:void(0)">
                    <i data-feather="box"></i>
                    <span>الاحكام</span>
                    <i class="fa fa-angle-right pull-right"></i>
                </a>

                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{route('termsConditions.all')}}">
                            <i class="fa fa-circle"></i>
                            <span>شروط واحكام </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('purchaseConditions.all')}}">
                            <i class="fa fa-circle"></i>
                            <span> شروط الشراء</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('saleConditions.all')}}">
                            <i class="fa fa-circle"></i>
                            <span> شروط البيع</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
          	<li>
                  <a class="sidebar-header" href="javascript:void(0)">
                      <i data-feather="archive"></i>
                      <span>بلاغات</span>
                      <i class="fa fa-angle-right pull-right"></i>
                  </a>

                  <ul class="sidebar-submenu">
                      <li>
                          <a href="{{route('Report.all')}}">
                              <i class="fa fa-circle"></i>
                              <span>بلاغات</span>
                          </a>
                      </li>

                  </ul>
            </li>


    
        </ul>
    </div>
</div>
