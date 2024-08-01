$("#mn-departamento").on('click',function(){routing("departamento")});


function routing(route){
    $('#main-container').load('.../resource/views/'+route+'.blade.php');
}
