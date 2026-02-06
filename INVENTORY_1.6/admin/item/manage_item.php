<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT i.*, c.name as `category` from `item_list` i inner join category_list c on i.category_id = c.id where i.id = '{$_GET['id']}' and c.`delete_flag` = 0 and i.`delete_flag` = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
	<form action="" id="item-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="category_id" class="control-label">Category</label>
			<select name="category_id" id="category_id" class="form-control form-control-sm rounded-0" required="required">
				<option value="" <?= !isset($category_id) ? 'selected' : '' ?>></option>
				<?php 
				$category = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1 order by `name` asc");
				while($row = $category->fetch_assoc()):
				?>
				<option value="<?= $row['id'] ?>" <?= isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="LabID" class="control-label">LabID</label>
			<input type="text" name="LabID" id="LabID" class="form-control form-control-sm rounded-0" value="<?php echo isset($LabID) ? $LabID : ''; ?>"  required/>
		</div>
		<div class="form-group">
			<label for="batch" class="control-label">Batch</label>
			<textarea rows="3" name="batch" id="batch" class="form-control form-control-sm rounded-0" required><?php echo isset($batch) ? $batch : ''; ?></textarea>
		</div>
				<div class="form-group">
			<label for="brand" class="control-label">Brand</label>
			<input type="text" name="brand" id="brand" class="form-control form-control-sm rounded-0" value="<?php echo isset($brand) ? $brand : ''; ?>" />
		</div>
		<div class="form-group">
			<label for="model" class="control-label">Model</label>
			<input type="text" name="model" id="model" class="form-control form-control-sm rounded-0" value="<?php echo isset($model) ? $model : ''; ?>" />
		</div>
		<div class="form-group">
			<label for="supplier_name" class="control-label">Supplier</label>
			<input type="text" name="supplier_name" id="supplier_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($supplier_name) ? $supplier_name : ''; ?>" />
		</div>
		<div class="form-group">
			<label for="serial_id" class="control-label">Serial ID</label>
			<input type="text" name="serial_id" id="serial_id" class="form-control form-control-sm rounded-0" value="<?php echo isset($serial_id) ? $serial_id : ''; ?>" required/>
			<small id="serial_error" class="text-danger" style="display:none;"></small>
		</div>


		<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required="required">
				<option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Working</option>
				<option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Not Working</option>
			</select>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#uni_modal').on('shown.bs.modal',function(){
			$('#category_id').select2({
				placeholder:"Please select category here",
				width:'100%',
				dropdownParent:$('#uni_modal'),
				containerCssClass:'form-control form-control-sm rounded-0'
			})
		})
		// Serial ID uniqueness check removed - users can now input custom serial IDs
		$('#item-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_item",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						// location.reload()
						alert_toast(resp.msg, 'success')
						uni_modal("<i class='fa fa-th-list'></i> Item Details ","item/view_item.php?id="+resp.cid)
						$('#uni_modal').on('hide.bs.modal', function(){
							location.reload()
						})
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

	})
</script>