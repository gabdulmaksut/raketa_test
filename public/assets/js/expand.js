function expand(link, type, width, height, ajax, token) {
    document.getElementById("layout").style.width="0px";
    document.getElementById("layout").style.height="0px";
    var div_width = width;
    var div_height = height;

    if (type == 'video' && height < 400)
    {
        div_width = (400 / height) * width;
        div_height = 400;
    }

    if (type == 'image' && height < 100)
    {
        div_width = (100 / height) * width;
        div_height = 100;
    }


    if (div_width > div_height) {
        if (width > 900 || screen.width < 600) {
            div_width = Math.min(screen.width , 900);
            div_height = (div_width / width) * height;
        }
    }
    else {
        if (height > 400 || screen.width < 400) {
            div_height = Math.min(screen.width, 400);
            div_width = (div_height / height) * width;
        }
    }

    $("#contentbox").css("width", div_width + "px");
    $("#contentbox").css("margin-left", ( - div_width / 2 ) + "px");
    $("#contentbox").css("height", div_height + "px");
    $("#contentbox").css("margin-top", ( - div_height / 2 ) + "px");

    if (link) {
        $.ajax({
                url: ajax,
                data: {
                    'link': link,
                    'type': type,
                    '_token': token
                },
                type: 'POST',
                async: 'false',
                success: function (result) {
                    $("#contentbox").html(result);

                    if ($('#content').attr("preload") == 'metadata') {

                        $('#content').click(function(e) {
                            e.stopPropagation();
                        });

                        setTimeout(function () {
                            $("#contentbox").css("width", $("#content").css("width"));
                            $("#contentbox").css("height", $("#content").css("height"));

                        }, 1000)
                    }
                    $("#layout").show();
                    $(".black-overlay").show();

                    /*
                    $('#contentbox').bind('wheel mousewheel', function (e) {

                        e.stopPropagation();

                        if ($('#content').attr("preload") == 'metadata') var h = 250; else var h = 100;

                        $("#contentbox").css("width", $("#content").css("width"));
                        $("#contentbox").css("height", $("#content").css("height"));

                        var delta;

                        if (e.originalEvent.wheelDelta !== undefined)
                            delta = e.originalEvent.wheelDelta;
                        else
                            delta = e.originalEvent.deltaY * -1;

                        var width_coef = $('#contentbox').height() / $('#contentbox').width();


                        if (delta > 0) {
                            if ($('#contentbox').height() < 3000) {
                                $('#contentbox').css({
                                    width: function (index, value) {
                                        return parseFloat(value) + 40;
                                    },
                                    height: function (index, value) {
                                        return parseFloat(value) + 40 * width_coef;
                                    }
                                });
                                var margin_left = -parseInt($('#contentbox').css("width"), 10) / 2;
                                $('#contentbox').css("margin-left", margin_left + "px");
                                var margin_top = -parseInt($('#contentbox').css("height"), 10) / 2;
                                $('#contentbox').css("margin-top", margin_top + "px");
                            }
                        }
                        else {
                            if ($('#contentbox').height() > h) {
                                $('#contentbox').css({
                                    width: function (index, value) {
                                        return parseFloat(value) - 40;
                                    },
                                    height: function (index, value) {
                                        return parseFloat(value) - 40 * width_coef;
                                    }
                                });
                                var margin_left = -parseInt($('#contentbox').css("width"), 10) / 2;
                                $('#contentbox').css("margin-left", margin_left + "px");
                                var margin_top = -parseInt($('#contentbox').css("height"), 10) / 2;
                                $('#contentbox').css("margin-top", margin_top + "px");
                            }
                        }

                        return false;

                    }); */

                }
        });
    }

}
