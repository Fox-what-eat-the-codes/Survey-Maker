<?php include 'db_connect.php' ?>
<?php 
$answers = $conn->query("SELECT distinct(survey_id) from answers where user_id ={$_SESSION['login_id']}");
$ans = array();
while($row=$answers->fetch_assoc()){
	$ans[$row['survey_id']] = 1;
}
?>
<div class="col-lg-12">
	<div class="d-flex w-100 justify-content-center align-items-center mb-2">
		<label for="" class="control-label">설문 찾기</label>
		<div class="input-group input-group-sm col-sm-5">
			<input type="text" class="form-control" id="filter" placeholder="키워드 입력하기...">
			<span class="input-group-append">
				<button type="button" class="btn btn-primary btn-flat" id="search">검색하기</button>
			</span>
		</div>
		<div class="form-group">
			<select id="filter-type" class="form-control form-control-sm ml-2" style="width: 150px;">
				<option value="all">전체보기</option>
				<option value="mentioned_surveys" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php' && $_GET['page'] == 'mentioned_surveys') ? 'mentioned' : ''; ?>>언급된 설문</option>
			</select>
		</div>
	</div>

	<div class=" w-100" id='ns' style="display: none"><center><b>결과 없음.</b></center></div>
	<div class="row">
	<?php 
	$survey = $conn->query("SELECT * FROM survey_set WHERE '".date('Y-m-d')."' BETWEEN date(start_date) AND date(end_date) ORDER BY rand() ");
	while($row = $survey->fetch_assoc()):
		$isMentioned = $conn->query("SELECT COUNT(*) as count FROM notifications WHERE user_id = {$_SESSION['login_id']} AND survey_id = {$row['id']} AND is_read = 0")->fetch_assoc()['count'] > 0;
	?>
		<div class="col-md-3 py-1 px-1 survey-item" data-mentioned_surveys="<?php echo $isMentioned ? '1' : '0'; ?>">
			<div class="card card-outline card-primary">
				<div class="card-header">
					<h3 class="card-title"><?php echo ucwords($row['title']) ?></h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body" style="display: block;">
					<?php echo $row['description'] ?>
					<div class="row">
						<hr class="border-primary">
						<div class="d-flex justify-content-center w-100 text-center">
							<?php if(!isset($ans[$row['id']])): ?>
								<a href="index.php?page=answer_survey&id=<?php echo $row['id'] ?>" class="btn btn-sm bg-gradient-primary"><i class="fa fa-pen-square"></i> 응답하기</a>
							<?php else: ?>
								<p class="text-primary border-top border-primary">완료</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
</div>
<script>
		function find_survey(){
		start_load();
		var filter = $('#filter').val().toLowerCase();
		var filterType = $('#filter-type').val();  // 드롭다운 필터 값
		
		$('.survey-item').each(function(){
			var txt = $(this).text().toLowerCase();
			var isMentioned = $(this).data('mentioned_surveys') == 1; // 언급된 설문 여부

			// 필터링 조건
			var matchesKeyword = txt.includes(filter);
			var matchesFilterType = (filterType === 'all') || (filterType === 'mentioned_surveys' && isMentioned);

			if(matchesKeyword && matchesFilterType) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});

		// 검색 결과가 없을 때 메시지 표시
		if ($('.survey-item:visible').length <= 0) {
			$('#ns').show();
		} else {
			$('#ns').hide();
		}
		end_load();
	}

	$('#search').click(function(){
		find_survey();
	});

	$('#filter').keypress(function(e){
		if (e.which == 13) {
			find_survey();
			return false;
		}
	});

	$('#filter-type').change(function(){
		find_survey();
	});

</script>
