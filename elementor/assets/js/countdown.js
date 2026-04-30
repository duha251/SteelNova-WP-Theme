(function ($) {
    "use strict";

    function initCountdown($scope, $) {
        let $countdown = $scope.find('.cs-countdown');

        if (!$countdown.length) return;
        if ($countdown.hasClass('cs-countdown--initialized')) return;

        $countdown.addClass('cs-countdown--initialized');

        function formatTime(num) {
            num = Math.max(0, parseInt(num, 10) || 0);
            return num < 10 ? '0' + num : num.toString();
        }

        function splitTime($el, num, unit) {
            let html = '';

            if (!$el.hasClass('split')) return '';

            num = formatTime(num);

            let digits = num.split('');
            digits.forEach(function (digit) {
                html += '<span class="value">' + digit + '</span>';
            });

            if (unit !== '') {
                html += '<span class="unit">' + unit + '</span>';
            }

            return html;
        }

        function normalTime(num, unit) {
            let html = '<span class="value">' + formatTime(num) + '</span>';

            if (unit !== '') {
                html += '<span class="unit">' + unit + '</span>';
            }

            return html;
        }

        let get_date_time = $countdown.data('time');
        if (get_date_time === undefined) return;

        let count_down_date = new Date(get_date_time).getTime();

        let $days = $countdown.find('.days');
        let $hours = $countdown.find('.hours');
        let $minutes = $countdown.find('.minutes');
        let $seconds = $countdown.find('.seconds');

        let day_unit = $days.data('unit') || '';
        let hour_unit = $hours.data('unit') || '';
        let minute_unit = $minutes.data('unit') || '';
        let second_unit = $seconds.data('unit') || '';

        function updateCountdown() {
            let now = new Date().getTime();
            let distance = count_down_date - now;

            if (distance < 0) {
                clearInterval(timer);
                $countdown.addClass('expired').html('<span class="value">EXPIRED</span>');
                return;
            }

            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = $days.length
                ? Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
                : Math.floor(distance / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if ($days.length) {
                $days.html(
                    $days.hasClass('split')
                        ? splitTime($days, days, day_unit)
                        : normalTime(days, day_unit)
                );
            }

            if ($hours.length) {
                $hours.html(
                    $hours.hasClass('split')
                        ? splitTime($hours, hours, hour_unit)
                        : normalTime(hours, hour_unit)
                );
            }

            if ($minutes.length) {
                $minutes.html(
                    $minutes.hasClass('split')
                        ? splitTime($minutes, minutes, minute_unit)
                        : normalTime(minutes, minute_unit)
                );
            }

            if ($seconds.length) {
                $seconds.html(
                    $seconds.hasClass('split')
                        ? splitTime($seconds, seconds, second_unit)
                        : normalTime(seconds, second_unit)
                );
            }
        }

        updateCountdown(); // chạy ngay lần đầu để khỏi chờ 1 giây mới update
        let timer = setInterval(updateCountdown, 1000);
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/steelnova-countdown.default',
            initCountdown
        );
    });

})(jQuery);