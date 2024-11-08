function find_survey(){
    start_load();
    var filter = $('#filter').val().toLowerCase();
    var filterType = $('#filter-type').val();
    
    $('.survey-item').each(function(){
        var txt = $(this).text().toLowerCase();
        var isMentioned = $(this).data('mentioned') == 1; // 언급된 설문 여부

        // 필터링 조건
        var matchesKeyword = txt.includes(filter);
        var matchesFilterType = (filterType === 'all') || (filterType === 'mentioned' && isMentioned);

        if(matchesKeyword && matchesFilterType) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

    // 검색 결과 없을 때 메시지 표시
    if($('.survey-item:visible').length <= 0){
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
    if(e.which == 13){
        find_survey();
        return false;
    }
});

$('#filter-type').change(function(){
    find_survey();
});
