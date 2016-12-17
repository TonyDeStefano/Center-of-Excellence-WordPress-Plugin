(function($){

    $(function(){

        $('.coe-filter-arrow').click(function(){
            var menu = $(this).data('menu');
            var display = $(this).data('display');
            if ( display == 'none' )
            {
                $(this)
                    .data('display','block')
                    .removeClass('fa-chevron-up')
                    .addClass('fa-chevron-down');
                $('.panel-body-'+menu).show();

            }
            else
            {
                $(this)
                    .data('display','none')
                    .removeClass('fa-chevron-down')
                    .addClass('fa-chevron-up');
                $('.panel-body-'+menu).hide();
            }
        })

    });

})(jQuery);
