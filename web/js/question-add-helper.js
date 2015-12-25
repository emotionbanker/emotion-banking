$(window).load(function(){
    var questions = [], existingQuestions = [];
    var $modal = $('#myModal');

    function applyQuestionsAdding(){
        var $questionary = $('#form-reihenfolge').val();
        existingQuestions = getExisting($questionary).concat(questions);
        $('.question-add.btn-warning').each(function(){
            var $questionId = $(this).data('question');
            if(existingQuestions.indexOf($questionId)!==-1){
                $(this).removeClass('btn-warning');
            }else{
                $(this).removeClass('btn-warning').addClass('btn-warning');
            }
        });
        $('.question-add.btn-warning').on('click', function(){
            var $questionId = $(this).data('question');
            $(this).removeClass('btn-warning').off('click');
            questions.push($questionId);
        });
    }

    function getExisting(questionary){
        var existing = [];
        if(questionary != ''){
            existing = questionary.split(';');
            for(var i=0; i < existing.length; i++){
                if(isNaN(existing[i] = parseInt(existing[i]))){
                    existing.splice(i,1);
                    i--;
                }
            }
        }
        return existing;
    }


    $(document).on('ready pjax:success', function() {
        applyQuestionsAdding();
    });

    $modal.on('hide.bs.modal', function (e) {
        questions = [];
    });

    $('#addQuestion').on('click', function (e) {
        var $questionary = $('#form-reihenfolge').val();
        existingQuestions = getExisting($questionary).concat(questions);
        $('.question-add').each(function(){
            var $questionId = $(this).data('question');
            if(existingQuestions.indexOf($questionId)!==-1){
                $(this).removeClass('btn-warning');
                $(this).off('click');
            }else{
                if(!$(this).hasClass('btn-warning')){
                    $(this).addClass('btn-warning');
                    $(this).on('click', function(){
                        $(this).removeClass('btn-warning').off('click');
                        questions.push($questionId);
                    });
                }
            }
        });
    });

    $('#reinfolge-save').bind('click', function(){
        if(questions.length != 0){
            var $questionary = $('#form-reihenfolge').val();
            $questionary = $questionary + questions.join(';') + ';';
            $('#form-reihenfolge').val($questionary);
        }
    });

    $('#openURL').bind('click', function(){
        var url = $('#questionnaireURL').val();
        var bezeichnung = $('select[name="Form[bank]"]').val();
        window.open(url.replace('bezeichnung', bezeichnung), '_blank');
        return false;
    });

    applyQuestionsAdding();
});