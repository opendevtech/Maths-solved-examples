var imported = document.createElement('script');
imported.src = 'js/jquery.min.js';
document.head.appendChild(imported);

var imported1 = document.createElement('script');
imported.src = 'js/jquery-1.8.js';
document.head.appendChild(imported1);

var count = 0;
var scount = 1;

function saveq(pageid,action){
    var qsn_name = document.getElementById("id_qname").value;
    var qsntext = document.getElementById("id_summary_editor").value;
	var encoded = encodeURIComponent(qsntext);
	var qsn_wtg = document.getElementById("id_queweightage").value;
	var qsn_date = document.getElementById("id_date").value;
	
	if(qsn_name == '' || qsntext == '' ){
		
		        var hide_delay = 2500; 
                var hide_next = 800;  
                $(".alert-danger").slideDown().each( function(index,el) {
                window.setTimeout( function(){
                $(el).slideUp();  
                 }, hide_delay + hide_next*index);
			    });   
	}
	else{
		if(action=='add'){
			document.getElementById('method').style.display = "block";
			 $(document).ready(function(){
			$.ajax({
				type: "POST",
				url: "addquestion.php",
				data :'que_name='+qsn_name+'&que_text='+encoded+' &que_wtg='+ qsn_wtg+'&que_date='+qsn_date,
				cache: true,
				success: function(html){
				 $('#showalert').fadeIn();
                 $(".alert").fadeOut(3000 );
				}  
			});
			});
			document.getElementById('que').style.display = "none";
			 
		}
		else if(action == 'editq')
		{
		    var qsn_id = document.getElementById("id_que_id").value; 
			$.ajax({
				type: "POST",
				url: "addquestion.php",
				data :'que_name='+qsn_name+'&que_text='+encoded+'&que_wtg='+ qsn_wtg+'&que_date='+qsn_date+'&qstn_id='+qsn_id,
				cache: true,
				success: function(html){
				$('#questionupdate').fadeIn();
                $(".alert").fadeOut(3000 );
				}  
			});
			window.open("view.php?page="+pageid,"mywindow");
		}
	}
};

function method1(){
  document.getElementById('step').style.display = "block";
  count++;
  scount = 1; 
  document.getElementById("meth_count").innerHTML = count;
  document.getElementById("hidden1").value = count;
  document.getElementById("step_count").innerHTML = scount;
  document.getElementById("hidden2").value = scount;
  
};

function  savestp(action){

	var methodcount = count;
	var stepcount = scount;
	var steps = document.getElementById("id_textfield_editor").value;
	var encodedsteps = encodeURIComponent(steps);
	var step_desc = document.getElementById("id_introduction").value;
	var stepwet = document.getElementById("id_stepweightage").value;
	if(steps == ''|| step_desc == '' ){
		var hide_delay = 2500;  
        var hide_next = 800;  
        $("#stepalert").slideDown().each( function(index,el) {
        window.setTimeout( function(){
        $(el).slideUp(); 
        }, hide_delay + hide_next*index);
		});
	}
	else{
		scount++;
		if(action == 'add'){
			document.getElementById("hidden2").value = scount;
			document.getElementById("step_count").innerHTML = ""+ scount + "";
			$.ajax({
				type: "POST",
				url: "addstep.php",
				data :'method_count='+methodcount+'&step_count='+stepcount+'&step='+encodedsteps+'&stepdesc='+step_desc+'&step_wtg='+stepwet,
				cache: true,
				success: function(html){
				    $('#stepsuccessalert').fadeIn();
                    $(".alert").fadeOut(3000 );  
				document.getElementById('id_textfield_editor').value='';
				document.getElementById('id_introduction').value='';
				document.getElementById('id_stepweightage').value='';
				}  
			});
		}
		else if(action == 'edit'){
			var qsnid = document.getElementById("id_que_id").value; 
			var stepid = document.getElementById("id_step_id").value; 
			var meth_no = document.getElementById("id_mno").value; 
			var stp_no = document.getElementById("id_sno").value; 
			
			$.ajax({
				type: "POST",
				url: "addstep.php",
				data :'action='+action+'&step='+encodedsteps+'&stepdesc='+step_desc+'&step_wtg='+stepwet+'&q_id='+qsnid+'&s_id='+stepid+'&m_no='+meth_no+'&s_no='+stp_no,
				cache: true,
				success: function(html){
				} 
             }); 
			$('#stepupdatealert').fadeIn();
            $(".alert").fadeOut(3000 );
			window.open("showstep.php");
		}
	}
};

function show_step(){
var x;
    if (confirm("Have you added all steps???") == true) {
      window.open("showstep.php");
    } else {
       
    }
};
function view_que(){

  window.open("view.php");

}
	
$(function() 
    {
	 $( "#button" ).click(function()
        {
            $( "div.container div.invisible" ).first().addClass( "visible" ).removeClass("invisible");
        });
});
$(function() 
    {
	  $( "#animate" ).click(function()
	    {
		    setTimeout("setToBlack()",3000); 
        });
	});
function setToBlack ( )
{
	$( "div.container div.invisible" ).first().addClass( "visible" ).removeClass("invisible");
	setTimeout("setToBlack()",3000); 
	  
};  
function ResetSteps(){
   location.reload();
};
