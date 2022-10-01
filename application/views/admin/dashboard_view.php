<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo convertEnglishDigitToBengali(count($members)); ?> জন </h3>
              <p>সদস্য</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo base_url(); ?>Member/Member_management" class="small-box-footer">বিস্তারিত <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo convertEnglishDigitToBengali($total_deposit); ?> টাকা</h3>
              <p>কিস্তি বাবদ জমা হয়েছে</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url(); ?>Payment/Payment_management" class="small-box-footer">বিস্তারিত <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo convertEnglishDigitToBengali($total_expense); ?> টাকা</h3>

              <p>মোট খরচ হয়েছে</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url(); ?>Expense/Expense_management" class="small-box-footer">বিস্তারিত <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?php echo convertEnglishDigitToBengali($total_expense - $total_deposit); ?> টাকা</h3>
              <p>বর্তমান স্থিতি রয়েছে</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">&nbsp;</a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
      </div>
      <!-- /.row -->


    </div>
    <!-- Main row -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

      </div>
    </div>
</div>
</div>
</div>