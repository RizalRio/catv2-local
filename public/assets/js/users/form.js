var KTFormControls = (function () {
    var _initValidation = function () {
        FormValidation.formValidation(document.getElementById("kt_form"), {
            fields: { 
                fullname : { 
                    validators: { 
                        notEmpty: { 
                            message: "Nama pengguna harus diisi" 
                        } 
                    } 
                }, 
                email: { 
                    validators: { 
                        notEmpty: { 
                            message: "Email pengguna harus diisi" 
                        } 
                    } 
                },
                username: {
                    validators: {
                        notEmpty: {
                            message: "Username harus diisi"
                        }
                    }
                }
            },
            plugins: { 
                trigger: new FormValidation.plugins.Trigger(), 
                bootstrap: new FormValidation.plugins.Bootstrap(), 
                submitButton: new FormValidation.plugins.SubmitButton(), 
                defaultSubmit: new FormValidation.plugins.DefaultSubmit() 
            },
        });
    };
    return {
        init: function () {
            _initValidation();
        },
    };
})();

jQuery(document).ready(function () {
    KTFormControls.init()
});