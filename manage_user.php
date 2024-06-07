<?php 
include('db_connect.php');
session_start();
$utype = array('','users','staff','customers');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM {$utype[$_SESSION['login_type']]} where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}

?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">이름</label>
			<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="name">성씨</label>
			<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">이메일</label>
			<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">비밀번호</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<small><i>비밀번호 변경을 원치 않을 경우엔 비워주세요</i></small>
		</div>
		
		

	</form>
</div>
<script>
	
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=update_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_load()
				}
			}
		})
	})

</script>
