jQuery(document).ready(function() {
	jQuery(".next").click(function(){
		var current_fs = jQuery(this).parent();
		var next_fs = jQuery(this).parent().next();

		// Activate next step on progressbar using the index of next_fs
		jQuery("#progressbar li").eq(jQuery("fieldset").index(next_fs)).addClass("active");

		// Show the next fieldset
		next_fs.show(); 
		// Hide the current fieldset
		current_fs.hide();
	});

	jQuery(".previous").click(function(){
		var current_fs = jQuery(this).parent();
		var previous_fs = jQuery(this).parent().prev();

		// De-activate current step on progressbar
		jQuery("#progressbar li").eq(jQuery("fieldset").index(current_fs)).removeClass("active");

		// Show the previous fieldset
		previous_fs.show(); 
		// Hide the current fieldset
		current_fs.hide();
	});

	// jQuery(".submit").click(function(){
	// 	return true;
	// });
	
	template_show();
	change_preview_img();

	jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	jQuery("#msform").validate({
		rules:{
			name:"required",
			phone:{required : true,minlength:10},
			email:{email: true,required: true},
			zip:"required",
		},

		messages: {
			name:"Name is required.",
			phone:{
				minlength:"Phone is not valid.",
				required:"Phone is required."
			},
			email:{
				email:"E-mail is not valid.",
				required:"Email is required."
			},
			zip:"Name is required.",
		},

		submitHandler: function(form){
			jQuery.ajax({
				url: form.action,
				type: form.method,
				data: $(form).serialize(),
				success: function(response) {
					if( response.status = 'success' ) { 
						jQuery("#message").text(response.message);
						jQuery(".submitted-alert.alert.alert-success").fadeIn();
						jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
						form.reset();
					}
				}            
			});		
		}
	});
});

//***************************************** Step 1 

jQuery(document).on('change', 'input[name="style"]', function() {
	template_show();
});

jQuery(document).on('change', 'input[name="door_type"]', function() {
	template_show();
});

jQuery(document).on('change', 'input[name="template"]', function() {
	jQuery('.gotostep2').click();
});

function template_show() {
	let style = jQuery('input[name="style"]:checked').data('value');
	let door_type = jQuery('input[name="door_type"]:checked').data('value');

	jQuery(".templates div").hide();
	jQuery(".templates ."+style+"."+door_type).show();
}

jQuery(document).on('click', '.gotostep2', function() {
	// generate number of fields.
	let measurements_field = jQuery('input[name="template"]:checked').data('measurements_field');
	var container = document.getElementById('field_container');
	var alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
	for (var i = 0; i < measurements_field; i++) {

		// Create a new input element
        var input = document.createElement('input');
        input.type = 'text';
        input.name = 'measurements['+i+']';
        input.id = alphabet[i];
        input.className = 'form-control';
        input.placeholder = 'Enter value for ' + alphabet[i];
        
        // Create a label for the input
        var label = document.createElement('label');
        label.htmlFor = alphabet[i];
        label.textContent = alphabet[i];
        
        // Create a container for the input and label
        var inputContainer = document.createElement('div');
        inputContainer.className = 'form-group';
        inputContainer.appendChild(label);
        inputContainer.appendChild(input);

        // Append the new input container to the main container
        container.appendChild(inputContainer);
    }

    // load image on 2 step
	let measurements_img = jQuery('input[name="template"]:checked').data('measurements_image');
	jQuery(".messurements_preview").attr('src', measurements_img);

	// load image on 3 step
	let src = jQuery('input[name="template"]:checked').parent().find('img').attr('src');
	jQuery(".glass_preview").attr('src', src);

});


//***************************************** Step 3 
jQuery(document).on('change', 'input[name="thickness"]', function() {
	change_preview_img();
});

jQuery(document).on('change', 'input[name="glass_type"]', function() {
	change_preview_img();
});

jQuery(document).on('change', 'input[name="hardware"]', function() {
	change_preview_img();
})

jQuery(document).on('change', 'input[name="handle"]', function() {
	change_preview_img();
});

function change_preview_img() {
	let thickness = jQuery('input[name="thickness"]:checked').data('value');
	let glass_type = jQuery('input[name="glass_type"]:checked').data('value');
	let hardware = jQuery('input[name="hardware"]:checked').data('value');
	let handle = jQuery('input[name="handle"]:checked').data('value');

	jQuery(".thicknesses div").hide();
	jQuery(".thicknesses ."+thickness).show();

	jQuery(".handles div").hide();
	jQuery(".handles ."+hardware).show();

	jQuery(".glass_previews img").hide();
	jQuery(".glass_previews img").removeClass('active');
	if( jQuery(".glass_previews img."+thickness+"."+glass_type+"."+hardware+"."+handle).length > 0 ) {
		jQuery(".glass_previews img."+thickness+"."+glass_type+"."+hardware+"."+handle).show();
		jQuery(".glass_previews img."+thickness+"."+glass_type+"."+hardware+"."+handle).addClass("active");
	} else {
		jQuery(".glass_previews img.glass_preview").show();
		jQuery(".glass_previews img.glass_preview").addClass("active");
	}
}

jQuery(document).on('click', '.gotostep4', function() {
	let src = jQuery(".glass_previews .active").attr('src');
	let img_id = jQuery(".glass_previews .active").data('id');
	let style = jQuery('input[name="style"]:checked').data('name');
	let hardware = jQuery('input[name="hardware"]:checked').data('name');
	let handle = jQuery('input[name="handle"]:checked').data('name');
	let door_type = jQuery('input[name="door_type"]:checked').data('name');
	let thickness = jQuery('input[name="thickness"]:checked').data('name');
	let glass_type = jQuery('input[name="glass_type"]:checked').data('name');

	jQuery(".dor_priview").attr('src', src);
	jQuery("#image_priview").val(img_id);
	jQuery('#style').text(style);
	jQuery('#hardware').text(hardware);
	jQuery('#handle').text(handle);
	jQuery('#hinge').text(door_type);
	jQuery('#glass-product').text(thickness+' '+glass_type);
});
//***************************************** Step 4