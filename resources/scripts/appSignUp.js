var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    saveButton = wrapper.querySelector("[data-action=save]"),
    canvas = document.getElementById("canvas"),
    canvas1 = document.getElementById("canvas1"),
    canvas2 = document.getElementById("canvas2"),
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
	
	canvas1.width = canvas1.offsetWidth * ratio;
    canvas1.height = canvas1.offsetHeight * ratio;
    canvas1.getContext("2d").scale(ratio, ratio);
	
	canvas2.width = canvas2.offsetWidth * ratio;
    canvas2.height = canvas2.offsetHeight * ratio;
    canvas2.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas);
signaturePad1 = new SignaturePad(canvas1);
signaturePad2 = new SignaturePad(canvas2);

clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
    signaturePad1.clear();
    signaturePad2.clear();
});

saveButton.addEventListener("click", function (event) {
	//alert("OK");
	var testEmail = document.getElementById('email');
	//alert("Email : "+testEmail.value);
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
    if (signaturePad.isEmpty()) {
        //alert("Please provide Bearth Operator signature first.");
    }
	 else if (signaturePad1.isEmpty()) {
       // alert("Please provide Freight Forwarder signature first.");
    }
	 else if (signaturePad2.isEmpty()) {
        //alert("Please provide CPA signature first.");
    }
	else {
		//alert(canvas.toDataURL());
		//alert(document.getElementById('email').value);
		document.getElementById('my_hidden').value = canvas.toDataURL();
		document.getElementById('my_hidden_ff').value = canvas1.toDataURL();
		document.getElementById('my_hidden_cpa').value = canvas2.toDataURL();
		//alert(document.getElementById('my_hidden').value);
		//document.forms["frm3"].submit();
		document.className = 'close';
	    //window.open(signaturePad.toDataURL());
    }
});

