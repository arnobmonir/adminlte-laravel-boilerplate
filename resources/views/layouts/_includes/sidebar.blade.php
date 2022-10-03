 <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
     @include('layouts._includes.brand')
     <div class="sidebar">
         @include('layouts._includes.sidebar-user')
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <li class="nav-header">ANALYTICS</li>
                 <li class="nav-item">
                     <a href="../../index.html" class="nav-link">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>Dashboard</p>
                     </a>
                 </li>
                 <li class="nav-header">EXAMPLES</li>

             </ul>
         </nav>

     </div>
     <div class="sidebar-custom">
         <a href="#" class="btn btn-link"><i class="fas fa-cogs"></i></a>
         <a href="#" class="btn btn-secondary hide-on-collapse pos-right">Help</a>
     </div>
 </aside>
