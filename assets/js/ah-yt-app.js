
/*
 * AH-YouTube Downloader 
 */

(function ($) {

    function youtube_parser(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }

    function get_video(url, widget, form, search_items) {
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'jsonp',
            beforeSend: function (xhr) {
                $('.ah-videos-list', widget).hide().find('>ul').html('');
                $('.ah-download-table', widget).hide().html('');
                $('.ah-loader', form).show();
            },
            success: function (data) {
                $('.ah-loader', form).hide();
                if (data && data.items) {
                    $.each(data.items, function (index, item) {
                        search_items += `<li data-video-id="${item.id.videoId}">
                                                        <span></span>
                                                        <img src="${item.snippet.thumbnails.default.url}" alt="">
                                                        <h5>${item.snippet.title}</h5>
                                                      </li>`;
                    });
                    $('.ah-videos-list', widget).show().find('>ul').html(search_items);
                } else {
                    alert('No data found')
                }
            },
            error: function (error) {
                console.log(error)
            }
        });
    }

    $(document).ready(function () {

        $('.widget-ah-youtube').each(function () {

            var widget = $(this);

            $('select[name="ah-select-type"]', widget).on('change', function () {
                var type = $(this).val();
                var input = $('input[name="ah-input"]', widget);
                if (type == 'search') {
                    input.attr({
                        'placeholder': input.attr('data-input-search'),
                        'type': 'text'
                    });
                } else if (type == 'video') {
                    input.attr({
                        'placeholder': input.attr('data-input-video'),
                        'type': 'url'
                    });
                }
            });

            $('form', widget).on('submit', function (event) {
                var url = '';
                var search_items = '';
                var form = $(this);
                var input = $('input[name="ah-input"]', widget);
                var type = $('select[name="ah-select-type"]', widget).val();
                event.preventDefault();
                if (type == 'search') {
                    url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&order=viewCount&maxResults=10&q=' + input.val() + '&type=video&key=' + widget.attr('data-apikey');
                    get_video(url, widget, form, search_items);

                } else if (type == 'video') {
                    input.attr('placeholder', input.attr('data-input-video'));
                    url = 'https://www.googleapis.com/youtube/v3/videos?id=' + youtube_parser(input.val()) + '&part=snippet&key=' + widget.attr('data-apikey');
                    get_video(url, widget, form, search_items);
                }
            });

            $('.ah-videos-list > ul', widget).on('click', 'li', function () {
                var id = $(this).attr('data-video-id');
                var table = '';
                var rows = '';
                $.ajax({
                    type: "GET",
                    url: 'https://www.ytapi.tatwerat.com/video/' + id,
                    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                    beforeSend: function (xhr) {
                        $('.ah-videos-list', widget).hide().find('>ul').html('');
                        $('.ah-loader', widget).show();
                    },
                    success: function (data) {
                        $('.ah-loader', widget).hide();
                        if (data && Object.keys(data).length) {
                            $.each(data, function (index, item) {
                                if (item.data.length) {
                                    $.each(item.data, function (i, link) {
                                        if (link.type)
                                            rows += `<tr>
                                                    <td>${link.type} [ ${link.resolution} ]</td>
                                                    <td><a href="${link.url}" download class="ah-download-link">${$('.ah-download-table', widget).attr('data-ah-download')}</a></td>
                                                </tr>`;
                                    });
                                }
                                table += `<table>
                                            <thead>
                                                <tr><th colspan="2">${$('.ah-download-table', widget).attr('data-ah-' + index)}</th></tr>
                                            </thead>
                                            <tbody>
                                                ${rows}
                                            </tbody>
                                        </table>`;
                            });
                            $('.ah-download-table', widget).show().html(table);
                        } else {
                            $('.ah-download-table', widget).show().html(`<p style="color:#c00">This video not available to download</p>`);
                        }
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            });

        });

    });

}(jQuery));