$(document).ready(function(){
//ck editor
   ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );

$("#checkboxes").click(function(event){
	if(this.checked){

		$(".checkboxes").each(function(){
			this.checked=true;

		});
	}else{

		$(".checkboxes").each(function(){
			this.checked=false;

		});
	}
});

var div_box="<div id='load-screen'><div id='loading'></div></div>";
$("body").prepend(div_box);
$("#load-screen").delay(700).fadeOut(600,function(){
	this.remove();
});


});

function loadOnlineUsers(){

	$.get("functions.php?onlineUsers=result",function(data){

	$(".user-online").text(data);

	});
}


setInterval(function(){

loadOnlineUsers();

},500);
