$(document).ready(function() {
    let hashtags = [];

    // 해시태그 입력 필드에서 Enter 또는 , 입력 시 해시태그로 변환
    $('#hashtag-input').on('keypress', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addHashtag($(this).val().trim());
            $(this).val('');
        }
    });

    // 해시태그 추가 함수
    function addHashtag(text) {
        if (text === '') return;
        const hashtag = text.startsWith('#') ? text : `#${text}`;
        if (!hashtags.includes(hashtag)) {
            hashtags.push(hashtag);
            renderHashtags();
        }
    }

    // 해시태그 렌더링 함수
    function renderHashtags() {
        $('#hashtag-container').empty();
        hashtags.forEach((tag, index) => {
            $('#hashtag-container').append(`
                <span class="hashtag-item">
                    ${tag} <span class="remove-hashtag" data-index="${index}">&times;</span>
                </span>
            `);
        });
        $('#hashtags').val(hashtags.join(', ')); // hidden input에 저장
    }

    // 해시태그 삭제 이벤트
    $(document).on('click', '.remove-hashtag', function() {
        const index = $(this).data('index');
        hashtags.splice(index, 1);
        renderHashtags();
    });
});
