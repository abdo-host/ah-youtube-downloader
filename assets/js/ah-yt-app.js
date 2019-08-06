
/*
 * AH-YouTube Downloader 
 */

(function ($) {

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
                var url, search_items;
                var form = $(this);
                var input = $('input[name="ah-input"]', widget).val();
                var type = $('select[name="ah-select-type"]', widget).val();
                event.preventDefault();
                if (type == 'search') {
                    url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&order=viewCount&maxResults=10&q=' + input + '&type=video&key=' + widget.attr('data-apikey');
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: 'jsonp',
                        beforeSend: function (xhr) {
                            $('.ah-videos-list', widget).hide();
                            $('.ah-loader', form).show();
                        },
                        success: function (data) {
                            $('.ah-loader', form).hide();
                            console.log(data)
                            if (data && data.items) {
                                $.each(data.items, function (index, item) {
                                    search_items += ` <li data-video-id="${item.id.videoId}">
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
                } else if (type == 'video') {
                    input.attr('placeholder', input.attr('data-input-video'));
                }
            });

        });

    });

}(jQuery));