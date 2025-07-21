  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
      <img src="{{ asset('images/front_images/home/logo.png') }}" style="object-fit: scale-down;" width="120px" height="60px" alt="App Logo">

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(Auth::guard('admin')->user()->type=='admin')
          <img class="profile-user-img img-fluid img-circle" src="{{url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image)}}">
          @else
          <img class="profile-user-img img-fluid img-circle" src="{{url('images/admin_images/admin_photos/vendor_photos/'.Auth::guard('admin')->user()->image)}}">
          @endif
        </div>
        <div class="info">
          @php
          {{
            $fullname = Auth::guard('admin')->user()->name;     
            }}
          @endphp
          <a href="/admin/profile" class="d-block">
            @php
            {{ echo $fullname;}}
            @endphp</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if(Session::get('page')=="dashboard")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="/admin/dashboard" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard

              </p>
            </a>
          </li>
          
          @if(Auth::guard('admin')->user()->type=='admin')
          @if(Session::get('page')=="user" || Session::get('page')=="deactive_user" || Session::get('page')=="active_user" || Session::get('page')=="subscriberuser")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Session::get('page')=="active_user")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="/admin/activeuser" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>Active / Deactive Users</p>
                </a>
              </li>

              @if(Session::get('page')=="subcriber_user")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="/admin/subscriberuser" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>Subscribed Users</p>
                </a>
              </li>

              @if(Session::get('page')=="vendor")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="/admin/vendor" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>Vendor Management</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(Session::get('page')=="catalog" || Session::get('page')=="categories" || Session::get('page')=="sections" || Session::get('page')=="brands" || Session::get('page')=="product")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                Catalogues
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Auth::guard('admin')->user()->type=='admin')
              @if(Session::get('page')=="sections")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('admin/sections')}}" class="nav-link {{$active}}">
                  <i class="nav-icon fas fa-puzzle-piece"></i>

                  <p>
                    Sections
                  </p>
                </a>
              </li>
              @if(Session::get('page')=="brands")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item has-treeview">
                <a href="{{url('admin/brands') }}" class="nav-link {{$active}}">
                  <i class="nav-icon fab fa-creative-commons"></i>
                  <p>
                    Brands
                  </p>
                </a>
              </li>
              @if(Session::get('page')=="categories")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item has-treeview">
                <a href="/admin/categories" class="nav-link {{$active}}">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Categories
                  </p>
                </a>
              </li>
              @endif
              @if(Auth::guard('admin')->user()->type=='vendor')


              @if(Session::get('page')=="product")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item has-treeview">
                <a href="{{url('admin/products') }}" class="nav-link {{$active}}">
                  <i class="nav-icon fas fa-coins"></i>
                  <p>
                    Products
                  </p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          @if(Auth::guard('admin')->user()->type=='admin')
          @if(Session::get('page')=="coupons" || Session::get('page')=="offers" )
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-gift"></i>
              <p>
                Make Offers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              @if(Session::get('page')=="coupons")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item has-treeview">
                <a href="/admin/coupons" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>
                    Manage Coupons
                  </p>
                </a>
              </li>


            </ul>
          </li>
          @endif

          @if(Session::get('page')=="orders" || Session::get('page')=="manageorders" || Session::get('page')=="pendingorders" || Session::get('page')=="deliveredorders")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
                Orders
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Session::get('page')=="manageorders")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('admin/orders')}}" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>Manage Orders</p>
                </a>
              </li>

              @if(Auth::guard('admin')->user()->type=='admin')
              @if(Session::get('page')=="deliveredorders")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="/admin/deliveredorders" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>Delivered Orders </p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          @if(Session::get('page')=="statistics" || Session::get('page')=="stats" || Session::get('page')=="stock" || Session::get('page')=="review")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fas fa-chart-line"></i>
              <p>
                Statistics
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Session::get('page')=="stats")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="/admin/stats" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>Stats</p>
                </a>
              </li>
              @if(Session::get('page')=="stock")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="/admin/stock" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>Stock</p>
                </a>
              </li>
              @if(Session::get('page')=="review")
              <?php $active = "active"; ?>
              @else
              <?php $active = ""; ?>
              @endif
              <li class="nav-item">
                <a href="/admin/review" class="nav-link {{$active}}">
                  <i class="fa fa-angle-right nav-icon"></i>
                  <p>Reviews</p>
                </a>
              </li>
            </ul>
          </li>
          @if(Auth::guard('admin')->user()->type=='admin')
          @if(Session::get('page')=="Banner")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="/admin/banner" class="nav-link {{$active}}">
              <i class="nav-icon fas fas fa-images"></i>
              <p>
                Manage Banners
              </p>
            </a>
          </li>
          @endif

          @if(Auth::guard('admin')->user()->type=='admin')
          @if(Session::get('page')=="contactus")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="/admin/contactusview" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-id-badge"></i>
              <p>
                Contact Us
              </p>
            </a>
          </li>
          @if(Session::get('page')=="report")
          <?php $active = "active"; ?>
          @else
          <?php $active = ""; ?>
          @endif
          <li class="nav-item has-treeview">
            <a href="/admin/report" class="nav-link {{$active}}">
              <i class="nav-icon fas fas fa-chart-pie"></i>
              <p>
                Report
              </p>
            </a>
          </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>