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
        });

        $('.coe-cb').click(function(){

            $(this).toggleClass('coe-cb-checked');
            $(this).find('i')
                .toggleClass('fa-check-square-o')
                .toggleClass('fa-square-o');

            doCoeFilter();
        });

    });

})(jQuery);

function doCoeFilter()
{
    var categories = [];
    var cities = [];
    var colleges = [];
    var c;
    var x;
    var y;

    jQuery('.coe-cb-category').each(function(){
        if( jQuery(this).hasClass('coe-cb-checked') )
        {
            categories.push(jQuery(this).data('id'));
        }
    });

    jQuery('.coe-cb-city').each(function(){
        if( jQuery(this).hasClass('coe-cb-checked') )
        {
            cities.push(jQuery(this).data('id'));
        }
    });

    jQuery('.coe-cb-college').each(function(){
        if( jQuery(this).hasClass('coe-cb-checked') )
        {
            colleges.push(jQuery(this).data('id'));
        }
    });

    if ( categories.length + cities.length + colleges.length == 0 )
    {
        for (c = 0; c < coe_colleges.length; c++)
        {
            if (coe_colleges[c].map == 1)
            {
                coe_colleges[c].marker.setMap(coe_map);
            }
        }

        jQuery('.panel-coe-college').each(function(){
            jQuery(this).show();
        });
    }
    else
    {
        for (c = 0; c < coe_colleges.length; c++)
        {
            if (coe_colleges[c].map == 1)
            {
                coe_colleges[c].marker.setMap(null);
            }
        }

        jQuery('.panel-coe-college').each(function(){
            jQuery(this).hide();
        });

        if ( colleges.length > 0 )
        {
            for (c = 0; c < colleges.length; c++)
            {
                jQuery('#coe-college-'+colleges[c]).show();

                for (x = 0; x < coe_colleges.length; x++)
                {
                    if ( colleges[c] == coe_colleges[x].city )
                    {
                        coe_colleges[x].marker.setMap(coe_map);
                        break;
                    }
                }
            }
        }

        if ( cities.length > 0 )
        {
            for (c = 0; c < cities.length; c++)
            {
                for (x = 0; x < coe_colleges.length; x++)
                {
                    if ( cities[c] == coe_colleges[x].city )
                    {
                        jQuery('#coe-college-'+coe_colleges[x].id).show();
                        coe_colleges[x].marker.setMap(coe_map);
                    }
                }
            }
        }

        if ( categories.length > 0 )
        {
            for (c = 0; c < categories.length; c++)
            {
                for (x = 0; x < coe_colleges.length; x++)
                {
                    for (y = 0; y < coe_colleges[x].categories.length; y++)
                    {
                        if ( categories[c] == coe_colleges[x].categories[y] )
                        {
                            jQuery('#coe-college-'+coe_colleges[x].id).show();
                            coe_colleges[x].marker.setMap(coe_map);
                            break;
                        }
                    }
                }
            }
        }
    }
}
