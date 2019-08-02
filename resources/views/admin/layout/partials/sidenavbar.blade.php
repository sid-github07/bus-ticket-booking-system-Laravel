<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">

  <ul class="app-menu">
    <li><a class="app-menu__item @if(request()->path() == 'admin/dashboard') active @endif" href="{{route('admin.dashboard')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

    <li class="treeview
    @if(request()->path() == 'admin/generalSetting')
      is-expanded
    @elseif (request()->path() == 'admin/EmailSetting')
      is-expanded
    @elseif (request()->path() == 'admin/SmsSetting')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-globe"></i><span class="app-menu__label">Website Control</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.GenSetting')}}"><i class="icon fa fa-cogs"></i> General Setting</a></li>
        <li><a class="treeview-item" href="{{route('admin.EmailSetting')}}" rel="noopener"><i class="icon fa fa-envelope"></i> Email Setting</a></li>
        <li><a class="treeview-item" href="{{route('admin.SmsSetting')}}"><i class="icon fa fa-mobile"></i> SMS Setting</a></li>
      </ul>
    </li>


    <li><a class="app-menu__item @if(request()->path() == 'admin/amenities/index') active @endif" href="{{route('admin.amenities.index')}}"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Amenities Management</span></a></li>



    <li class="treeview
    @if(request()->path() == 'admin/package/create')
      is-expanded
    @elseif(Request::is('admin/package/*/edit'))
      is-expanded
    @elseif(request()->path() == 'admin/package/index')
      is-expanded
    @elseif(request()->path() == 'admin/package/all')
      is-expanded
    @elseif(request()->path() == 'admin/package/pending')
      is-expanded
    @elseif(request()->path() == 'admin/package/accepted')
      is-expanded
    @elseif(request()->path() == 'admin/package/rejected')
      is-expanded
    @elseif(request()->path() == 'admin/package/rejrequest')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-plane"></i><span class="app-menu__label">Package Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.package.create')}}"><i class="icon fa fa-plus"></i> Add Package</a></li>
        <li><a class="treeview-item" href="{{route('admin.package.index')}}"><i class="icon fa fa-list"></i> All Packages</a></li>
        <li><a class="treeview-item" href="{{route('admin.package.all')}}"><i class="icon fa fa-list"></i> All Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.package.rejected')}}"><i class="icon fa fa-list"></i> Rejected Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.package.rejrequest')}}"><i class="icon fa fa-list"></i> Rejection Requests</a></li>
      </ul>
    </li>



    <li class="treeview
    @if(request()->path() == 'admin/hotel/create')
      is-expanded
    @elseif(Request::is('admin/hotel/*/rooms'))
      is-expanded
    @elseif(Request::is('admin/hotel/*/edit'))
      is-expanded
    @elseif(request()->path() == 'admin/hotel/index')
      is-expanded
    @elseif(request()->path() == 'admin/room/all')
      is-expanded
    @elseif(request()->path() == 'admin/room/rejected')
      is-expanded
    @elseif(request()->path() == 'admin/room/rejrequest')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-hotel"></i><span class="app-menu__label">Hotel Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.hotel.create')}}"><i class="icon fa fa-plus"></i> Add Hotel</a></li>
        <li><a class="treeview-item" href="{{route('admin.hotel.index')}}"><i class="icon fa fa-list"></i> All Hotels</a></li>
        <li><a class="treeview-item" href="{{route('admin.room.all')}}"><i class="icon fa fa-list"></i> All Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.room.rejected')}}"><i class="icon fa fa-list"></i> Rejected Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.room.rejrequest')}}"><i class="icon fa fa-list"></i> Rejection Requests</a></li>
      </ul>
    </li>




    <li class="treeview
    @if(request()->path() == 'admin/lounge/create')
      is-expanded
    @elseif(Request::is('admin/lounge/*/rooms'))
      is-expanded
    @elseif(Request::is('admin/lounge/*/edit'))
      is-expanded
    @elseif(request()->path() == 'admin/lounge/index')
      is-expanded
    @elseif(request()->path() == 'admin/lounge/all')
      is-expanded
    @elseif(request()->path() == 'admin/lounge/rejected')
      is-expanded
    @elseif(request()->path() == 'admin/lounge/rejrequest')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-coffee"></i><span class="app-menu__label">Lounge Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.lounge.create')}}"><i class="icon fa fa-plus"></i> Add Lounge</a></li>
        <li><a class="treeview-item" href="{{route('admin.lounge.index')}}"><i class="icon fa fa-list"></i> All Lounges</a></li>
        <li><a class="treeview-item" href="{{route('admin.lounge.all')}}"><i class="icon fa fa-list"></i> All Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.lounge.rejected')}}"><i class="icon fa fa-list"></i> Rejected Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.lounge.rejrequest')}}"><i class="icon fa fa-list"></i> Rejection Requests</a></li>
      </ul>
    </li>




    <li class="treeview
    @if(request()->path() == 'admin/pickupcar/create')
      is-expanded
    @elseif(Request::is('admin/pickupcar/*/rooms'))
      is-expanded
    @elseif(Request::is('admin/pickupcar/*/edit'))
      is-expanded
    @elseif(Request::is('admin/dropoff/*/edit'))
      is-expanded
    @elseif(Request::is('admin/dropoff/*/create'))
      is-expanded
    @elseif(request()->path() == 'admin/pickupcar/index')
      is-expanded
    @elseif(request()->path() == 'admin/pickupcar/all')
      is-expanded
    @elseif(request()->path() == 'admin/pickupcar/rejected')
      is-expanded
    @elseif(request()->path() == 'admin/pickupcar/rejrequest')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-car"></i><span class="app-menu__label">Pickup Cars Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.pickupcar.create')}}"><i class="icon fa fa-plus"></i> Add Pickup Car</a></li>
        <li><a class="treeview-item" href="{{route('admin.pickupcar.index')}}"><i class="icon fa fa-list"></i> All Pickup Cars</a></li>
        <li><a class="treeview-item" href="{{route('admin.pickupcar.all')}}"><i class="icon fa fa-list"></i> All Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.pickupcar.rejected')}}"><i class="icon fa fa-list"></i> Rejected Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.pickupcar.rejrequest')}}"><i class="icon fa fa-list"></i> Rejection Requests</a></li>
      </ul>
    </li>



    <li class="treeview
    @if(request()->path() == 'admin/rentcar/create')
      is-expanded
    @elseif(Request::is('admin/rentcar/*/rooms'))
      is-expanded
    @elseif(Request::is('admin/rentcar/*/edit'))
      is-expanded
    @elseif(request()->path() == 'admin/rentcar/index')
      is-expanded
    @elseif(request()->path() == 'admin/rentcar/all')
      is-expanded
    @elseif(request()->path() == 'admin/rentcar/rejected')
      is-expanded
    @elseif(request()->path() == 'admin/rentcar/rejrequest')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-car"></i><span class="app-menu__label">Rent Cars Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.rentcar.create')}}"><i class="icon fa fa-plus"></i> Add Car</a></li>
        <li><a class="treeview-item" href="{{route('admin.rentcar.index')}}"><i class="icon fa fa-list"></i> All Cars</a></li>
        <li><a class="treeview-item" href="{{route('admin.rentcar.all')}}"><i class="icon fa fa-list"></i> All Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.rentcar.rejected')}}"><i class="icon fa fa-list"></i> Rejected Bookings</a></li>
        <li><a class="treeview-item" href="{{route('admin.rentcar.rejrequest')}}"><i class="icon fa fa-list"></i> Rejection Requests</a></li>
      </ul>
    </li>




    <li class="treeview
    @if (request()->path() == 'admin/userManagement/allUsers')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/bannedUsers')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/verifiedUsers')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/mobileUnverifiedUsers')
      is-expanded
    @elseif (request()->path() == 'admin/userManagement/emailUnverifiedUsers')
      is-expanded
    @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Users Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.allUsers')}}"><i class="icon fa fa-users"></i> All Users</a></li>
        <li><a class="treeview-item" href="{{route('admin.bannedUsers')}}"><i class="icon fa fa-times"></i> Banned Users</a></li>
        <li><a class="treeview-item" href="{{route('admin.verifiedUsers')}}"><i class="icon fa fa-check"></i> Verified Users</a></li>
        <li><a class="treeview-item" href="{{route('admin.mobileUnverifiedUsers')}}"><i class="icon fa fa-mobile"></i> Mobile Unverified Users</a></li>
        <li><a class="treeview-item" href="{{route('admin.emailUnverifiedUsers')}}"><i class="icon fa fa-envelope"></i> Email Unverified Users</a></li>
      </ul>
    </li>


    <li><a class="app-menu__item @if(request()->path() == 'admin/subscribers') active @endif" href="{{route('admin.subscribers')}}"><i class="app-menu__icon fa fa-newspaper-o"></i><span class="app-menu__label">Subscribers</span></a></li>


    <li><a class="app-menu__item @if(request()->path() == 'admin/gateways') active @endif" href="{{route('admin.gateways')}}"><i class="app-menu__icon fa fa-cc-mastercard"></i><span class="app-menu__label">Gateways</span></a></li>


    <li class="treeview
    @if (request()->path() == 'admin/interfaceControl/logoIcon/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/slider/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/about/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/package/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/hotel/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/lounge/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/subsc/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/contact/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/social/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/background/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/fbComments/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/footer/index')
      is-expanded
    @elseif (request()->path() == 'admin/interfaceControl/choose/index')
      is-expanded
    @endif"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-desktop"></i><span class="app-menu__label">Interface Control</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.logoIcon.index')}}"><i class="icon fa fa-cogs"></i> Logo+Icon Setting</a></li>
        <li><a class="treeview-item" href="{{route('admin.about.index')}}"><i class="icon fa fa-cogs"></i> About Page</a></li>
        <li><a class="treeview-item" href="{{route('admin.choose.index')}}"><i class="icon fa fa-cogs"></i> Choose us Section</a></li>
        <li><a class="treeview-item" href="{{route('admin.slider.index')}}"><i class="icon fa fa-cogs"></i> Slider Setting</a></li>
        <li><a class="treeview-item" href="{{route('admin.ppackage.index')}}"><i class="icon fa fa-cogs"></i> Popular Package Section</a></li>
        <li><a class="treeview-item" href="{{route('admin.photel.index')}}"><i class="icon fa fa-cogs"></i> Popular Hotel Section</a></li>
        <li><a class="treeview-item" href="{{route('admin.subsc.index')}}"><i class="icon fa fa-cogs"></i> Subscription Section</a></li>
        <li><a class="treeview-item" href="{{route('admin.plounge.index')}}"><i class="icon fa fa-cogs"></i> Popular Lounge Section</a></li>
        <li><a class="treeview-item" href="{{route('admin.contact.index')}}"><i class="icon fa fa-cogs"></i> Contact Setting</a></li>
        <li><a class="treeview-item" href="{{route('admin.background.index')}}"><i class="icon fa fa-cogs"></i> Background Image</a></li>
        <li><a class="treeview-item" href="{{route('admin.fbComment.index')}}"><i class="icon fa fa-cogs"></i> Comment Script</a></li>
        <li><a class="treeview-item" href="{{route('admin.footer.index')}}"><i class="icon fa fa-cogs"></i> Footer Text</a></li>
      </ul>
    </li>


    <li><a class="app-menu__item @if(request()->path() == 'admin/tos/index') active @endif" href="{{route('admin.tos.index')}}"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Terms & Privacy</span></a></li>


    <li class="treeview
    @if(request()->path() == 'admin/deposit/pending')
      is-expanded
    @elseif (request()->path() == 'admin/deposit/acceptedRequests')
      is-expanded
    @elseif (request()->path() == 'admin/deposit/rejectedRequests')
      is-expanded
    @elseif (request()->path() == 'admin/deposit/depositLog')
      is-expanded
    @endif">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-download"></i><span class="app-menu__label">Deposit</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item" href="{{route('admin.deposit.pending')}}"><i class="icon fa fa-hourglass"></i> Pending Request</a></li>
        <li><a class="treeview-item" href="{{route('admin.deposit.acceptedRequests')}}" rel="noopener"><i class="icon fa fa-check"></i> Accepted Request</a></li>
        <li><a class="treeview-item" href="{{route('admin.deposit.rejectedRequests')}}"><i class="icon fa fa-times"></i> Rejected Request</a></li>
        <li><a class="treeview-item" href="{{route('admin.deposit.depositLog')}}"><i class="icon fa fa-desktop"></i> Deposit Log</a></li>
      </ul>
    </li>


    <li><a class="app-menu__item @if(request()->path() == 'admin/trxlog') active @endif" href="{{route('admin.trxLog')}}"><i class="app-menu__icon fa fa-exchange"></i><span class="app-menu__label">Transaction Log</span></a></li>


    <li><a class="app-menu__item @if(request()->path() == 'admin/menuManager/index') active @endif" href="{{route('admin.menuManager.index')}}"><i class="app-menu__icon fa fa-bars"></i><span class="app-menu__label">Menu Management</span></a></li>

      <li><a class="app-menu__item
        @if(request()->path() == 'admin/Ad/index')
          active
        @elseif(request()->path() == 'admin/Ad/create')
          active
        @endif" href="{{route('admin.ad.index')}}"><i class="app-menu__icon fa fa-buysellads"></i> <span class="app-menu__label"> Advertisement</span></a></li>
  </ul>
</aside>
