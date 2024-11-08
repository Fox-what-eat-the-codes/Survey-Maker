<?php include('db_connect.php') ?>
<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3" id="survey_list_link">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">총 설문수</span>
                  <span class="info-box-number">
                    <?php echo $conn->query("SELECT * FROM survey_set")->num_rows; ?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3" id="ongoing_survey_link">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">진행중인 설문수</span>
                 <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM survey_set WHERE end_date > now()")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3" id="completed_survey_link">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>
          <div class="info-box-content">
                <span class="info-box-text">끝난 설문수</span>
                 <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM survey_set WHERE end_date < now()")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>

<?php else: ?>
	 <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Welcome <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
      <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box" id="mentioned_surveys_link">
                  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-bell"></i></span>
                  <div class="info-box-content">
                      <span class="info-box-text">언급된 설문</span>
                      <span class="info-box-number">
                          <?php 
                          $mentioned_count = $conn->query("SELECT COUNT(*) as count FROM notifications WHERE user_id = {$_SESSION['login_id']} AND is_read = 0")->fetch_assoc()['count'];
                          echo $mentioned_count;
                          ?>
                      </span>
                  </div>
              </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">설문 응답수</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT distinct(survey_id) FROM answers  where user_id = {$_SESSION['login_id']}")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>
          
<?php endif; ?>

<script>
    document.getElementById('survey_list_link').addEventListener('click', function() {
        window.location.href = 'index.php?page=survey_list';
    });

    document.getElementById('ongoing_survey_link').addEventListener('click', function() {
    window.location.href = 'index.php?page=ongoing_surveys';
    });

    document.getElementById('completed_survey_link').addEventListener('click', function() {
      window.location.href = 'index.php?page=complete_surveys';
    });

    document.getElementById('mentioned_surveys_link').addEventListener('click', function() {
      window.location.href = 'index.php?page=survey_widget&filter=mentioned_surveys';
    });


</script>
