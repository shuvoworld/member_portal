<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

   <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Group</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Group</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

     <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Create New User Group</h3>
            </div>
            <!-- /.card-header -->
            <form role="form" action="<?php base_url('Group/create')?>" method="post">
            <div class="card-body">
            	<?php echo validation_errors(); ?>
            	 <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif;?>
              <div class="form-group col-2">
                <label for="groupName">Group Name</label>
                 <input type="text" class="form-control" id="name" name="name" placeholder="Enter Group name" value="<?php echo $group_data[0]['name']; ?>">
              </div>

              <div class="form-group col-2">
                <label for="groupDescription">Group Description</label>
                 <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $group_data[0]['description']; ?>">
              </div>

              <div class="form-group col-12">
              	<?php $serialize_permission = unserialize($group_data[0]['permission']);?>
              <table id="groupTable" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <td>Permission</td>
                  <th>Create</th>
                  <th>Update</th>
                  <th>View</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <tbody>
								<tr>
                        <td>Member</td>
                        <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createMember" <?php if ($serialize_permission) {
	if (in_array('createMember', $serialize_permission)) {echo "checked";}
}?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateMember" <?php
if ($serialize_permission) {
	if (in_array('updateMember', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewMember" <?php
if ($serialize_permission) {
	if (in_array('viewMember', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteMember" <?php
if ($serialize_permission) {
	if (in_array('deleteMember', $serialize_permission)) {echo "checked";}
}
?>></td>
                      </tr>


                      <tr>
                        <td>Group</td>
                        <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createGroup" <?php if ($serialize_permission) {
	if (in_array('createGroup', $serialize_permission)) {echo "checked";}
}?> ></td>
                        <td><input type="checkbo" name="permission[]" id="permission" class="minimal" value="updateGroup" <?php
if ($serialize_permission) {
	if (in_array('updateGroup', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewGroup" <?php
if ($serialize_permission) {
	if (in_array('viewGroup', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteGroup" <?php
if ($serialize_permission) {
	if (in_array('deleteGroup', $serialize_permission)) {echo "checked";}
}
?>></td>
                      </tr>

                      <tr>
                        <td>User</td>
                        <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createUser" <?php if ($serialize_permission) {
	if (in_array('createUser', $serialize_permission)) {echo "checked";}
}?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser" <?php
if ($serialize_permission) {
	if (in_array('updateUser', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser" <?php
if ($serialize_permission) {
	if (in_array('viewUser', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser" <?php
if ($serialize_permission) {
	if (in_array('deleteUser', $serialize_permission)) {echo "checked";}
}
?>></td>
                      </tr>



                      <tr>
                        <td>Payment</td>
                        <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createPayment" <?php if ($serialize_permission) {
	if (in_array('createPayment', $serialize_permission)) {echo "checked";}
}?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updatePayment" <?php
if ($serialize_permission) {
	if (in_array('updatePayment', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewPayment" <?php
if ($serialize_permission) {
	if (in_array('viewPayment', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deletePayment" <?php
if ($serialize_permission) {
	if (in_array('deletePayment', $serialize_permission)) {echo "checked";}
}
?>></td>
                      </tr>



                      <tr>
                        <td>Account Balance</td>
                        <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createBalance" <?php if ($serialize_permission) {
	if (in_array('createBalance', $serialize_permission)) {echo "checked";}
}?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateBalance" <?php
if ($serialize_permission) {
	if (in_array('updateBalance', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewBalance" <?php
if ($serialize_permission) {
	if (in_array('viewBalance', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteBalance" <?php
if ($serialize_permission) {
	if (in_array('deleteBalance', $serialize_permission)) {echo "checked";}
}
?>></td>
                      </tr>



                      <tr>
                        <td>Expense</td>
                        <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createExpense" <?php if ($serialize_permission) {
  if (in_array('createExpense', $serialize_permission)) {echo "checked";}
}?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateExpense" <?php
if ($serialize_permission) {
  if (in_array('updateExpense', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewExpense" <?php
if ($serialize_permission) {
  if (in_array('viewExpense', $serialize_permission)) {echo "checked";}
}
?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteExpense" <?php
if ($serialize_permission) {
  if (in_array('deleteExpense', $serialize_permission)) {echo "checked";}
}
?>></td>
                      </tr>



                </tbody>
              </table>
            </div>
            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <div class="col-12">
          <a href="<?php echo base_url('group') ?>" class="btn btn-secondary">Cancel</a>
          <input type="submit" value="Save and Close" class="btn btn-success float-right">
        </div>
      </div>
      </form>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    </section>
</div>
