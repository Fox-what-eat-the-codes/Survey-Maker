<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$type_arr = array('',"Admin","Staff","Subscriber");
	$qry = $conn->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM users where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
}
?>
<div class="container-fluid">
	<table class="table">
		<tr>
			<th>이름:</th>
			<td><b><?php echo ucwords($name) ?></b></td>
		</tr>
		<tr>
			<th>이메일:</th>
			<td><b><?php echo $email ?></b></td>
		</tr>
		<tr>
			<th>연락처:</th>
			<td><b><?php echo $contact ?></b></td>
		</tr>
		<tr>
			<th>주소</th>
			<td><b><?php echo $address ?></b></td>
		</tr>
		<tr>
			<th>유저 역할:</th>
			<td><b><?php echo $type_arr[$type] ?></b></td>
		</tr>
	</table>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>