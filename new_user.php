<?php ?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user">
				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<b class="text-muted">개인 정보</b>
						<div class="form-group">
							<label for="" class="control-label">성씨</label>
							<input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">이름</label>
							<input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
						</div>
						<div class="form-group">
							<label for="" class="control-label">학년</label>
							<select name="grade" id="grade" class="custom-select custom-select-sm">
								<option value="1학년" <?php echo isset($class) && $class == "1학년" ? 'selected' : '' ?>>1학년</option>
								<option value="2학년" <?php echo isset($class) && $class == "2학년" ? 'selected' : '' ?>>2학년</option>
								<option value="3학년" <?php echo isset($class) && $class == "3학년" ? 'selected' : '' ?>>3학년</option>
								<option value="4학년" <?php echo isset($class) && $class == "4학년" ? 'selected' : '' ?>>4학년</option>
							</select>
						</div>
						<div class="form-group">
							<label for="" class="control-label">학과</label>
							<select name="department" id="department" class="custom-select custom-select-sm">
								<option value="컴퓨터소프트웨어학과" 
								<?php echo isset($department) && $department == "컴퓨터소프트웨어학과" ? 'selected' : '' ?>>컴퓨터소프트웨어학과</option>
								<option value="컴퓨터전자과" 
								<?php echo isset($department) && $department == "컴퓨터전자과" ? 'selected' : '' ?>>컴퓨터전자과</option>
								<option value="바이오학과" 
								<?php echo isset($department) && $department == "바이오학과" ? 'selected' : '' ?>>바이오학과</option>
								<option value="게임디자인과" 
								<?php echo isset($department) && $department == "게임디자인과" ? 'selected' : '' ?>>게임디자인과</option>
							</select>
						</div>
						<div class="form-group">
							<label for="" class="control-label">전화번호</label>
							<input type="text" name="contact" class="form-control form-control-sm" required value="<?php echo isset($contact) ? $contact : '' ?>">
						</div>
						<div class="form-group">
							<label class="control-label">집 주소</label>
							<textarea name="address" id="" cols="30" rows="4" class="form-control" required><?php echo isset($address) ? $address : '' ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<b class="text-muted">시스템 역할</b>
						<?php if($_SESSION['login_type'] == 1): ?>
						<div class="form-group">
							<label for="" class="control-label">계정 역할</label>
							<select name="type" id="type" class="custom-select custom-select-sm">
								<option value="3" <?php echo isset($type) && $type == 3 ? 'selected' : '' ?>>유저</option>
								<option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>스태프</option>
								<option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>어드민</option>
							</select>
						</div>
						<?php else: ?>
							<input type="hidden" name="type" value="3">
						<?php endif; ?>
						<div class="form-group">
							<label class="control-label">이메일</label>
							<input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
							<small id="#msg"></small>
						</div>
						<div class="form-group">
							<label class="control-label">비밀번호</label>
							<input type="password" class="form-control form-control-sm" name="password" <?php echo isset($id) ? "":'required' ?>>
							<small><i><?php echo isset($id) ? "비밀번호 변경을 원치 않을 경우엔 비워주세요":'' ?></i></small>
						</div>
						<div class="form-group">
							<label class="label control-label">비밀번호 확인</label>
							<input type="password" class="form-control form-control-sm" name="cpass" <?php echo isset($id) ? 'required' : '' ?>>
							<small id="pass_match" data-status=''></small>
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">저장</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = 'index.php?page=user_list'">취소</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$('[name="password"],[name="cpass"]').keyup(function(){
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cpass"]').val()
		if(cpass == '' ||pass == ''){
			$('#pass_match').attr('data-status','')
		}else{
			if(cpass == pass){
				$('#pass_match').attr('data-status','1').html('<i class="text-success">비밀번호가 일치합니다.</i>')
			}else{
				$('#pass_match').attr('data-status','2').html('<i class="text-danger">비밀번호가 일치하지 않습니다.</i>')
			}
		}
	})
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage_user').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		if($('#pass_match').attr('data-status') != 1){
			if($("[name='password']").val() !=''){
				$('[name="password"],[name="cpass"]').addClass("border-danger")
				end_load()
				return false;
			}
		}
		$.ajax({
			url:'ajax.php?action=save_user',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved.',"success");
					setTimeout(function(){
						location.replace('index.php?page=user_list')
					},750)
				}else if(resp == 2){
					$('#msg').html("<div class='alert alert-danger'>이메일이 이미 존재합니다.</div>");
					$('[name="email"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>
