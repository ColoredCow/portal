console.log('report module');
$(document).ready(function(){
    if($('.show-modal')){
        $(".show-modal").modal('show');
    }
    $('.report').click(()=>{
        alert("button is clicked");
    })
});