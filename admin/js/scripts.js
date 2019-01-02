$(document).ready(function(){
    
    $('#selectAllBoxes').click(function(event){
        if(this.checked) {
            $('.checkBoxes').each(function(){
               this.checked = true; 
            });
        }
        else {
            $('.checkBoxes').each(function(){
               this.checked = false; 
            });
        }
    });
    
    $("body").prepend("<h1>Jami</h1>");
    
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    
    $("body").prepend(div_box);
    
    $('#load-screen').delay(0).fadeOut(100, function(){
       $this.remove(); 
    });
    
     // ckeditor editor
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
    
    
    
});