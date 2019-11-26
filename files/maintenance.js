// global select2 apply
$('.select2').select2({allowClear:true});
$('.select2.multiple').select2({});

Date.prototype.formatDate = function (format = 'DD/MM/YYYY'){
	var dd = this.getDate();

	var mm = this.getMonth()+1; 
	var yyyy = this.getFullYear();
	if(dd<10) 
	{
	    dd='0'+dd;
	} 

	if(mm<10) 
	{
	    mm='0'+mm;
	}

	if(format == 'MM-DD-YYYY'){
		return strDate = mm+'-'+dd+'-'+yyyy;
	}else if(format == 'MM/DD/YYYY'){
		return strDate = mm+'/'+dd+'/'+yyyy;
	}else if(format == 'DD-MM-YYYY'){
		return strDate = dd+'-'+mm+'-'+yyyy;
	}else if(format == 'YYYY-MM-DD'){
		return strDate = yyyy+'-'+mm+'-'+dd;
	}else if(format == 'YYYY/MM/DD'){
		return strDate = yyyy+'/'+mm+'/'+dd;
	}else{
		return dd+'/'+mm+'/'+yyyy;
	}
};

/*
	To add active the sidebar
	Milan Soni
*/

$.fn.activeSidebar = function(el_class){
	//console.log($(el_class).closest("ul"));
	// if($(el_class).closest('.nav .nav-list').is("ul")){
		// $(el_class).addClass('active');
	// }else{
		// $(el_class).addClass('active').parents('li').addClass('active open');
	// }
}

$.fn.active = function(){
//pcoded-trigger
	
	if(this.closest('.pcoded-hasmenu').length){		
		this.closest('.pcoded-hasmenu').addClass('pcoded-trigger');
	}
	this.addClass('active');	
}

setInterval(function(){ 
	var url = $('body').data('check_activity');
	$.ajax({
		url: url,
		type: 'get',
		dataType: 'json',
		success: function(result){
			if(!result.redirect_url){
				if(result.start_timer === true){
					var oneMin = 59*1;
					var display = document.querySelector('#timers');
					$("#inactivity_logout").css('display', 'block');
					startTimer(oneMin, display);
				}
			}else{
				window.location.href = result.redirect_url;
			}			
		}
	});
}, 15000);

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}

// Function to get location
function getLocation(){
  navigator.geolocation.getCurrentPosition(function (pos) {
      var lat = pos.coords.latitude;
      console.log()
      var lng = pos.coords.longitude;
      if (lat == null) {
          alert("GPS not activated!");
      } else {
          alert("Latitude: "+ lat + " , Longitude: " + lng );
      }
  });
}

// forceNumeric() plug-in implementation
$.fn.forceNumeric = function () {
    return this.each(function () {
        $(this).keydown(function (e) {
            var key = e.which || e.keyCode;

            if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
            // numbers   
                key >= 48 && key <= 57 ||
            // Numeric keypad
                key >= 96 && key <= 105 ||
            // comma, period and minus, . on keypad
               key == 190 || key == 188 || key == 109 || key == 110 ||
            // Backspace and Tab and Enter
               key == 8 || key == 9 || key == 13 ||
            // Home and End
               key == 35 || key == 36 ||
            // left and right arrows
               key == 37 || key == 39 ||
            // Del and Ins
                key == 46 || key == 45)
                return true;

            return false;
        });
    });
}

// only integer values allowed in textbox
$.fn.forceInt = function () {
	return this.each(function () {
        $(this).keydown(function (e) {
            var key = e.which || e.keyCode;

            if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
            // numbers   
                key >= 48 && key <= 57 ||
            // Numeric keypad
                key >= 96 && key <= 105 ||
            // Backspace and Tab and Enter
               key == 8 || key == 9 || key == 13 ||
            // Home and End
               key == 35 || key == 36 ||
            // left and right arrows
               key == 37 || key == 39 ||
            // Del and Ins
                key == 46 || key == 45)
                return true;

            return false;
        });
    });
}

jQuery.validator.addMethod("notEqual", function(value, element, param) {
    return this.optional(element) || value != $(param).val();
   }, "This has to be different...");