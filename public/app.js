$(document).ready(function() {
	$(".grid img").lazyload();
	$("input[type=file]").change(function() {
		$("#upload").find(".error").remove();
		if (this.files && this.files[0]) {
			if (this.files[0].size < 200e3 && this.files[0].type.match("image.*")) { // image < 200kb
				var reader = new FileReader();
				reader.onload = function(e) {
					$("#imagepreview img").attr("src", e.target.result);
					$("#imagepreview").show();
				}
				reader.readAsDataURL(this.files[0]);
			} else {
				$("#upload").prepend('<div class="alert error">Select an image under 200kb.</div>');
			}
		}
	});
	var canvas = $("#pasteprocessing canvas")[0], processingInstance;
	$("#pasteprocessing .run").click(function() {
		var pde = Processing.compile("background(0,0,0,0);"+$("#pasteprocessing textarea").val());
		pde.options.isTransparent = true;
		processingInstance = new Processing(canvas, pde);
		var data = canvas.toDataURL();
		$("#pasteprocessing input[name=pdecapture]").val(data);
		$("#imagepreview img").attr("src", data);
		$("#imagepreview").show();
		processingInstance.exit();
	});
	$("input[name=uploadtype]").change(function() {
		if ($("#uploadtype-code").is(":checked")) {
			$("#imagepreview img").attr("src", canvas.toDataURL());
		} else if ($("#uploadtype-image").is(":checked")) {
			var input = $("input[type=file]")[0];
			if (input.files && input.files[0]) {
				$("input[type=file]").change();
			} else {
				$("#imagepreview").hide();
				$("#imagepreview img").attr("src", "");
			}
		}
		$("#submitfile, #pasteprocessing").toggle();
	});
	$("#uploadtype-image").click(function() {
		if (!$("input[type=file]").is(":hidden")) $("input[type=file]").focus().click();
	});
	$("#uploadtype-code").click(function() {
		if (!$("#processingcode").is(":hidden")) $("#processingcode").focus().select();
	});
	$("input[name=license]").change(function() {
		$("#licensepreview span.link").toggle();
	});
	$("#upload #name").on("change keydown keyup keypress", function() {
		if ($(this).val().length > 0) {
			$("#licensepreview .name").text($(this).val());
		} else {
			$("#licensepreview .name").text("Work");
		}
	});
	if ($("#upload").length > 0) {
		$("#licensepreview .author").text($("#user").text().trim());
	}
	$("#upload").submit(function() {
		$(this).find(".error").remove();
		var file = $(this).find("input[type=file]")[0];
		if (!($("#name").val().length > 2 &&
			  $("#name").val().length <= 200 &&
			  $("#description").val().length <= 2000 && (
			( $("#uploadtype-image").is(":checked") && $("#file").val().length > 0 && file.files[0].size < 200e3 ) ||
			( $("#uploadtype-code").is(":checked") && $("#pdecapture").val().length > 0 ) )
		)) {
			$(this).prepend('<div class="alert error">Enter a name, add an image under 200kb, and keep the description under 2000 characters.</div>');
			return false;
		} else {
			$(this).find("button[type=submit]").addClass("submitting").attr("disabled", "disabled");
		}
	});
	$("form").not("#upload").each(function() {
		$(this).submit(function() {
			$(this).find("button[type=submit]").addClass("submitting").attr("disabled", "disabled");
		});
	});
	if ($(".grid").length > 0) {
		var grid = $(".grid").masonry({
			itemSelector: ".item",
			columnWidth: ".item",
			gutter: 5,
			isFitWidth: true
		});
		grid.imagesLoaded().progress(function() {
			grid.masonry('layout');
		});
	}
	$(".selectall").each(function() {
		$(this).on("click focus", function() {
			$(this).select();
		});
	});
	$("a.needsconfirm").each(function() {
		$(this).click(function() {
			if ($(this).text().indexOf("Really?") > -1) {
				$(this).html('<i class="icon-attention"></i> Absolutely!').attr("href", $(this).attr("data-href")).unbind("click");
			} else {
				$(this).html('<i class="icon-attention"></i> Really?').attr("href", "#seriously");
			}
			return false;
		}).attr("data-href", $(this).attr("href")).attr("href", "#confirm");
	});
	$("#user, #user a").click(function() {
		$("#user, #userdrop").toggleClass("dropped");
		return false;
	});
	if ($("form[action*='/auth/']").length > 0) {
		var form = $("form[action*='/auth/']"),
			user = form.find("input[name=username]"),
			pass = form.find("input[name=password]");
		if (user.val().length == 0) {
			user.focus();
		} else {
			pass.focus();
		}
	}
});
