<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
	.reservation-img{
		width:3em;
		height:3em;
		object-fit:cover;
		object-position:center center;
	}
</style>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Reservations</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="20%">
					<col width="10%">
					<col width="20%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>User</th>
						<th>Date & Time</th>
						<th>Status</th>
                              <th>Categories</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT r.*, CASE WHEN r.user_type = 1 THEN s.full_name WHEN r.user_type = 2 THEN f.full_name ELSE 'Unknown' END as user_name FROM `reservations` r LEFT JOIN students s ON r.user_type = 1 AND r.user_id = s.id LEFT JOIN faculty f ON r.user_type = 2 AND r.user_id = f.id ORDER BY r.created_at DESC");
						while($row = $qry->fetch_assoc()):
							$items_qry = $conn->query("SELECT GROUP_CONCAT(CONCAT(c.name, '/', i.LabID) SEPARATOR ', ') as items FROM reservation_items ri INNER JOIN item_list i ON ri.item_id = i.id INNER JOIN category_list c ON i.category_id = c.id WHERE ri.reservation_id = '{$row['id']}'");
							$items = $items_qry->fetch_assoc()['items'] ?? '';
							$status_labels = ['Pending', 'Approved', 'Borrowed', 'Returned', 'Cancelled'];
							$status = $status_labels[$row['status']] ?? 'Unknown';
					?>
						<tr>
							<td class="px-2 py-1 text-center"><?php echo $i++; ?></td>
							<td class="px-2 py-1"><?php echo date("Y-m-d H:i",strtotime($row['created_at'])) ?></td>
							<td class="px-2 py-1"><?php echo $row['user_name'] ?? 'Unknown' ?></td>
							<td class="px-2 py-1"><?php echo $row['date_time'] ?></td>
							<td class="text-center">
								<span class="badge badge-<?php echo $row['status'] == 0 ? 'warning' : ($row['status'] == 1 ? 'success' : ($row['status'] == 2 ? 'info' : ($row['status'] == 3 ? 'primary' : 'secondary'))) ?> px-3 rounded-pill"><?php echo $status ?></span>
							</td>
							<td class="px-2 py-1"><?php echo $items ?></td>
							<td align="center">
								<?php if($row['status'] == 0): ?>
									<button class="btn btn-sm btn-success accept_reservation" data-id="<?php echo $row['id'] ?>">Accept</button>
									<button class="btn btn-sm btn-danger cancel_reservation" data-id="<?php echo $row['id'] ?>">Cancel</button>
								<?php elseif($row['status'] == 2): ?>
									<button class="btn btn-sm btn-primary return_reservation" data-id="<?php echo $row['id'] ?>">Return</button>
								<?php endif; ?>
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
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [6] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')

		$('.accept_reservation').click(function(){
			var id = $(this).attr('data-id');
			_conf("Are you sure to accept this reservation?", "accept_reservation", [id]);
		});

		$('.return_reservation').click(function(){
			var id = $(this).attr('data-id');
			_conf("Are you sure to mark this as returned?", "return_reservation", [id]);
		});

		$('.cancel_reservation').click(function(){
			var id = $(this).attr('data-id');
			_conf("Are you sure to cancel this reservation?", "cancel_reservation", [id]);
		});
	})

	function accept_reservation($id){
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=accept_reservation",
			method: "POST",
			data: {id: $id},
			dataType: "json",
			error: err => {
				console.log(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			}
		});
	}

	function return_reservation($id){
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=return_reservation",
			method: "POST",
			data: {id: $id},
			dataType: "json",
			error: err => {
				console.log(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			}
		});
	}

	function cancel_reservation($id){
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=cancel_reservation",
			method: "POST",
			data: {id: $id},
			dataType: "json",
			error: err => {
				console.log(err);
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function(resp){
				if(typeof resp == 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			}
		});
	}
</script>
