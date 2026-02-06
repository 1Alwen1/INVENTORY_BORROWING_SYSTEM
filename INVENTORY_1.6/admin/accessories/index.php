<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	.accessory-img{
		width:3em;
		height:3em;
		object-fit:cover;
		object-position:center center;
	}
</style>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Accessories</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="30%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Category</th>
						<th>Batch</th>
						<th>Model</th>
						<th>Total Items</th>
						<th>Available</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
						$qry = $conn->query("SELECT a.*,c.name as `category` from `accessory_list` a inner join category_list c on a.category_id = c.id where a.delete_flag = 0 order by c.`name` asc, a.`batch` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="px-1 py-2 text-center"><?php echo $i++; ?></td>
							<td class="px-1 py-2"><?= $row['category'] ?></td>
							<td class="px-1 py-2"><?= $row['batch'] ?></td>
							<td class="px-1 py-2"><?= $row['model'] ?? '' ?></td>
							<td class="px-1 py-2 text-center"><?= $row['total_item'] ?? 0 ?></td>
							<td class="px-1 py-2 text-center"><?= $row['available'] ?? 0 ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view-data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit-data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Accessory permanently?","delete_accessory",[$(this).attr('data-id')])
		})
		$('#create_new').click(function(){
			uni_modal("<i class='far fa-plus-square'></i> Add New Accessory ","accessories/manage_accessory.php")
		})
		$('.edit-data').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Edit Accessory ","accessories/manage_accessory.php?id="+$(this).attr('data-id'))
		})
		$('.view-data').click(function(){
			uni_modal("<i class='fa fa-th-list'></i> Accessory Details ","accessories/view_accessory.php?id="+$(this).attr('data-id'))
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [6] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_accessory($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_accessory",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
