$(window).load(function(){
    function fixDiv() {
        var $multiselects = $('ul.multiselect-container');
        var $top = 0;
        $multiselects.each(function(){
            var $multiselect = $(this);
            var $filterInput = $multiselect.children('.input-group');
            $multiselect.scroll(function(){
                $top = $multiselect.scrollTop();
                if ($top > 1){
                    $filterInput.css({'position': 'absolute', 'top': $top+'px'});
                }
                else{
                    $filterInput.css({'position': 'relative', 'top': 'auto'});
                }
            });
        })
    }
    fixDiv();
});