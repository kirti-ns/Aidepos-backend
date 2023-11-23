<div class="main-menu menu-fixed menu-accordion menu-shadow menu-light" data-scroll-to-active="true">
   <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="nav-item">
            <a data-id="dashboard" href="<?= base_url('/agent/dashboard')?>">
              <i class="icon-grid"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span>
            </a>
         </li>
         <li class="nav-item">
            <a data-id="merchants" href="<?= base_url('/agent/merchants')?>">
              <i class="ft-users"></i><span class="menu-title" data-i18n="nav.merchants.main">Merchants</span>
            </a>
         </li>
         <li class="nav-item">
            <a href="<?= base_url('/agent/renewals/term') ?>"><i class="icon-note"></i> <span class="menu-title" data-i18n="nav.renewals.main">Renewals</span></a>
            <ul class="menu-content">
               <li><a class="menu-item" data-id="#term" href="<?= base_url('/agent/renewals/term') ?>" data-i18n="nav.renewals.term"> <i class="fa fa-minus"></i> Term</a>
               </li>
            </ul>
         </li>
      </ul>
   </div>
</div>