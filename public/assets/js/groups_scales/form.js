var KTFormControls = (function () {
  var _initValidation = function () {
    FormValidation.formValidation(document.getElementById("kt_form"), {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: "Nama metode harus diisi",
            },
          },
        },
        description: {
          validators: {
            notEmpty: {
              message: "Deskripsi metode harus diisi",
            },
          },
        },
      },

      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap(),
        submitButton: new FormValidation.plugins.SubmitButton(),
        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
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
  KTFormControls.init();
  autosize($('[name=description]'));
});