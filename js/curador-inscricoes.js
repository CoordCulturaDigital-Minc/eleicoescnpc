(function($) {

    $(document).ready(function() {
        var $eval_tabs = $("#evaluation-tabs");
        var $eval_area = $("#evaluation-area");

        var toggle_eval_bar = function() {
            if($eval_area.css('bottom') == '0px') {
                $eval_area.animate({'bottom': '-'+$eval_tabs.height()+'px'}).addClass('minimized');
                $eval_tabs.css('overflow','hidden');
            } else {
                $eval_area.animate({'bottom':'0px'}).removeClass('minimized');
                $eval_tabs.css('overflow','visible');
            }
        };

        $eval_tabs.tabs();

        $eval_area.find(".js-evaluation__toggle").click(function(e) {
            toggle_eval_bar();
        });

        $eval_tabs.find('input:checked').parent().addClass('checked');
        $eval_tabs.find('input').change(function(e) {
            $(this).parents('div.evaluation__score').find('.score-box').removeClass('checked');
            $(this).parent().addClass('checked');
        });
        if($.browser.msie) {
            $eval_tabs.find('.score-box label').click(function(e) {
                var $input = $('#'+$(this).attr('for'));
                if(!$input.attr('disabled')) {
                    $('#'+$(this).attr('for')).attr('checked',true).change();
                }
            });
        }
    });

})(jQuery);
