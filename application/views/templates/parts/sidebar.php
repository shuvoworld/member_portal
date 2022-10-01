<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <?php if ($this->ion_auth->in_group('member')) {?>
  <a href="<?php echo base_url(); ?>member/dashboard" class="brand-link">
    <span class="brand-text font-weight-light">হোমপেজ</span>
  </a>
  <?php }?>

   <?php if ($this->ion_auth->is_admin()) {?>
  <a href="<?php echo base_url(); ?>admin/dashboard" class="brand-link">
    <span class="brand-text font-weight-light">হোমপেজ</span>
  </a>
  <?php }?>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <div class="info">
        <a href="#" class="d-block">মেম্বার</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview">
        <?php if (in_array('viewUser', $this->permission)) {?>
          <a href="#" class="nav-link">
            <i class="nav-icon far fa-envelope"></i>
            <p>
              ব্যবহারকারী ব্যবস্থাপনা
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>User/" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ব্যবহারকারী</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>group" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>গ্রুপ</p>
              </a>
            </li>
          </ul>
        </li>
        <?php }?>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              মডিউল
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
          <?php if (in_array('viewMember', $this->permission) && !$this->ion_auth->in_group('member')) {?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>Member/Member_management" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>মেম্বার</p>
              </a>
            </li>
            <?php }?>
            <?php if (in_array('viewPayment', $this->permission)) {?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>payment/payment_management" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ইন্সটলমেন্ট প্রদান</p>
              </a>
            </li>
            <?php }?>

            <?php if (in_array('viewExpense', $this->permission)) {?>
            <li class="nav-item">
              <a href="<?php echo base_url(); ?>expense/Expense_management" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>খরচ</p>
              </a>
            </li>
            <?php }?>
          </ul>

        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
