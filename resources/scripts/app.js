var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    saveButton = wrapper.querySelector("[data-action=save]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas);

clearButton.addEventListener("click", function (event) {
	//alert("OK");
    signaturePad.clear();
});

saveButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
		alert("Please provide signature first.");
		alert(document.getElementById('email').value);
    }else if(document.getElementById('email').value==null || document.getElementById('email').value==""){
		alert("Please provide Email ID first.");
	}else if(document.getElementById('fname').value==null || document.getElementById('fname').value==""){
		alert("Please provide FirstName first.");
		
	}else if(document.getElementById('lname').value==null || document.getElementById('lname').value==""){
		alert("Please provide LastName first.");
	}else if(document.getElementById('phoneno').value==null || document.getElementById('phoneno').value==""){
		alert("Please provide Phone No first.");
	}else if(document.getElementById('datepicker').value==null || document.getElementById('datepicker').value==""){
		alert("Please provide Reservation Date first.");
	}else if(document.getElementById('t_hours').value==null || document.getElementById('t_hours').value==""){
		alert("Please provide Reservation Time first.");
	}else if(document.getElementById('autocomplete').value==null || document.getElementById('autocomplete').value==""){
		alert("Please provide PickUp Location first.");
	}else if(document.getElementById('autocomplete2').value==null || document.getElementById('autocomplete2').value==""){
		alert("Please provide Destination Location first.");
	}else if(document.getElementById('town').value==null || document.getElementById('town').value==""){
		alert("Please provide City first.");
	}else if(document.getElementById('state').value==null || document.getElementById('state').value==""){
		alert("Please provide State first.");
	}else if(document.getElementById('zip').value==null || document.getElementById('zip').value==""){
		alert("Please provide Zip first.");
	}else if(document.getElementById('card_number').value==null || document.getElementById('card_number').value==""){
		alert("Please provide Credit Card No. first.");
	}else if(document.getElementById('card_code').value==null || document.getElementById('card_code').value==""){
		alert("Please provide CVV first.");
	}else if(document.getElementById('card_expiration_month').value==null || document.getElementById('card_expiration_month').value==""){
		alert("Please provide Card Expiration month first.");
	}else if(document.getElementById('card_expiration_year').value==null || document.getElementById('card_expiration_year').value==""){
		alert("Please provide Card Expiration Year first.");
	}else if(document.getElementById('datepicker2').value==null || document.getElementById('datepicker2').value==""){
		alert("Please provide Signature Date first.");
	}
	else {
		//alert(canvas.toDataURL());
		//alert(document.getElementById('email').value);
		document.getElementById('my_hidden').value = canvas.toDataURL();
		//alert(document.getElementById('my_hidden').value);
		document.forms["frm3"].submit();
		document.className = 'close';
	    //window.open(signaturePad.toDataURL());
    }
});

