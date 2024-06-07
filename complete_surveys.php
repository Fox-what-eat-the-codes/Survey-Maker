<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_survey"><i class="fa fa-plus"></i> Add New Survey</a>
			</div>
		</div>
		<div class="card-body">
            <!-- 드롭다운 메뉴 추가 -->
			<div class="form-group">
                <label for="survey_filter">Filter Surveys:</label>
                <select id="survey_filter" class="form-control">
                    <option value="survey_list" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && $_GET['page'] == 'survey_list') ? 'selected' : ''; ?>>전체 설문</option>
                    <option value="ongoing_surveys" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && $_GET['page'] == 'ongoing_surveys') ? 'selected' : ''; ?>>진행중인 설문</option>
                    <option value="complete_surveys" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && $_GET['page'] == 'complete_surveys') ? 'selected' : ''; ?>>끝난 설문</option>
                </select>
            </div>
			<table class="table table-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>제목</th>
						<th>설명</th>
						<th>시작일</th>
						<th>마감일</th>
						<th>기능들</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM survey_set WHERE end_date < NOW() ORDER BY start_date ASC");
					while($row = $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['title']) ?></b></td>
						<td><b class="truncate"><?php echo $row['description'] ?></b></td>
						<td><b><?php echo date("M d, Y", strtotime($row['start_date'])) ?></b></td>
						<td><b><?php echo date("M d, Y", strtotime($row['end_date'])) ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="./index.php?page=edit_survey&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <a href="./index.php?page=view_survey&id=<?php echo $row['id'] ?>" class="btn btn-info btn-flat">
		                          <i class="fas fa-eye"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_survey" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
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
		$('#list').dataTable();
        document.getElementById('survey_filter').addEventListener('change', function() {
        var filterPage = this.value;
        window.location.href = 'index.php?page=' + filterPage;
        });

        // 드롭다운 메뉴가 화면 상단에 위치하도록 스크롤
        document.addEventListener('DOMContentLoaded', function() {
            window.scrollTo(0, document.getElementById('survey_filter').offsetTop);
        });
		$('.delete_survey').click(function(){
			_conf("진짜로 설문을 삭제하시겠습니까?","delete_survey",[$(this).attr('data-id')])
		});
	});

	function delete_survey($id){
		start_load();
		$.ajax({
			url: 'ajax.php?action=delete_survey',
			method: 'POST',
			data: {id: $id},
			success: function(resp){
				if(resp == 1){
					alert_toast("설문이 성공적으로 삭제됨", 'success');
					setTimeout(function(){
						location.reload();
					}, 1500);
				}
			}
		});
	}
</script>
