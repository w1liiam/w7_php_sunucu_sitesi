$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var formData = new FormData(this);
    var url = form.attr("action");
    var loadingBtnText = "";
    if(form.data("loading-button")) {
        loadingBtnText = $("#"+form.data("loading-button")).text();
        $("#"+form.data("loading-button")).text(form.data("loading"));
        $("#"+form.data("loading-button")).attr("disabled", "disabled");
    }
    try{
        CKEDITOR.instances["content"].updateElement();
        formData.append("content", CKEDITOR.instances["content"].getData());
    }catch(e){

    }
    $.ajax({
        type: form.attr("method"),
        url: url,
        data: formData,
        success: function(data)
        {
			if(data.success === undefined) {
				data = JSON.parse(data);
			} 
            if(data.success) {
              toastr.success(data.message);
                if(data.redirect !== undefined) {
                    setInterval(function() {
                        window.location = data.redirect;
                    }, 2000); 
                }
                else if(form.data("redirect")) {
                    setInterval(function() {
                        window.location = form.data("redirect");
                    }, 2000);
                }
            }
            else {
              toastr.error(data.message);
              try {grecaptcha.reset();}catch(e) {}
            }
            if(form.data("loading-button")) {
                $("#"+form.data("loading-button")).text(loadingBtnText);
                $("#"+form.data("loading-button")).attr("disabled", false);
            }
        },
        cache: false,
        contentType: false,
        processData: false
        });
    });