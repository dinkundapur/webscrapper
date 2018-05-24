$(document).ready(function () {
    function getAllNews(datastring) {
        $.ajax({
            url: "getAllNews",
            type: 'get',
            dataType: 'html',
            data: datastring,
            success: function (data) {
                $("#news_data").html(data);
            },
            error: function () {
            },
        });
    }

    function load(page)
    {
        var datastring = 'page=' + page;
        getAllNews(datastring);
    }

    load(1);

    $(document).on('click', '.pagination a', function (event) {
        var page = $(this).attr('href');
        var nextpage = encodeURIComponent((page.match(/[\d]+$/)));
        load(nextpage);
        return false;
    });

    $('.export_data').click(function () {
        var filetype = $(this).attr('id');
        $("#filetype").val(filetype);
        $("#exporttocsv").submit();
        return false;
    });

});