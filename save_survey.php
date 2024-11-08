// 해시태그 필드로부터 학년 및 학과 정보 가져오기
$hashtags = explode(',', $_POST['hashtags']);
$survey_id = ...; // 새로 저장된 설문 ID

foreach ($hashtags as $tag) {
    $tag = trim($tag);

    // 학년 해시태그에 해당하는 유저 조회
    if (strpos($tag, '학년') !== false) {
        $grade = str_replace('#', '', $tag);
        $users = $conn->query("SELECT id FROM users WHERE grade='$grade'");
    } elseif (strpos($tag, '과') !== false) { // 학과 해시태그에 해당하는 유저 조회
        $department = str_replace('#', '', $tag);
        $users = $conn->query("SELECT id FROM users WHERE department='$department'");
    }

    // 알림 등록
    while ($user = $users->fetch_assoc()) {
        $conn->query("INSERT INTO notifications (user_id, survey_id, message) VALUES ('{$user['id']}', '$survey_id', '새로운 설문이 등록되었습니다.')");
    }
}
