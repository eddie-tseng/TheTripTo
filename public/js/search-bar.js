var result = "";
$(document).on('ready', function () {
    defaultValue();
    $('#search').on({
        keyup: function (e) {
            // $('#btn-search').prop("type", "");
            var flag = e.target.isNeedPrevent;
            if (flag) return;
            $value = $(this).val();
            response();
            e.target.keyEvent = false;
        },
        keydown: function (e) {
            // $('#btn-search').prop("type", "");
            e.target.keyEvent = true;
        },
        input: function (e) {
            if (!e.target.keyEvent) {
                // console.log('keyevent');
            }
        },
        compositionstart: function (e) {
            e.target.isNeedPrevent = true;
        },
        compositionend: function (e) {
            e.target.isNeedPrevent = false;
        }
    });
});

function response() {
    if (!$value) {
        $('#btn-search').prop("type", "button");
        defaultValue();
    } else {
        $.ajax({
            type: 'get',
            url: '/search',
            data: {
                'search': $value,
            },
            success: function (data) {
                result = "";
                // console.log(data.ids);
                if ((data.ids).length != 0 && (data.names).length != 0) {
                    $('#btn-search').prop("type", "submit");
                    searchResult(data.ids, data.names);
                } else {
                    result += "<li>無此商品，請輸入其他關鍵字<li>";
                }
                $('#search-result').html(result);

            },
            error: function (data) {
                // console.log(data);
            }
        });
    }

}

function defaultValue() {
    var result = "";
    result +=
        "<li><a href='/tour/tour-list/search/?country=日本&sort=default' class='btn btn-light btn-block text-left'><img src='/img/site/star.svg' class='mb-1' width='16px' height='20px'> 日本 <span class='text-muted' style='color: #232931;'>| 大阪，北海道，九州...</span></i></a></li>";
    result +=
        "<li><a href='/tour/tour-list/search/?country=韓國&sort=default' class='btn btn-light btn-block text-left'><img src='/img/site/star.svg' class='mb-1' width='16px' height='20px'> 韓國 <span class='text-muted' style='color: #232931;'>| 首爾，釜山，濟州島...</span></i></a></li>";
    result +=
        "<li><a href='/tour/tour-list/search/?country=泰國&sort=default' class='btn btn-light btn-block text-left'><img src='/img/site/star.svg' class='mb-1' width='16px' height='20px'> 泰國 <span class='text-muted' style='color: #232931;'>| 曼谷，清邁，蘇美島...</span></i></a></li>";
    // console.log(result);
    $('#search-result').html(result);
}

function searchResult(ids, names) {
    for (let i = 0; i < ids.length; i++) {
        result += "<li><a href='/tour/" + ids[i] + "' class='btn btn-light btn-block text-left'>" + names[i] +
            "</a></li>";
    }

    // console.log(result);
}
