$(document).ready(function () {
  $('#changePassword').on('click', function (e) {
    e.preventDefault();
    removeValidationFeedback();
    const form = $("#formChangePasswordUser")[0];
    const fv = setupFormValidationChangePassword(form);
    const formData = new FormData(form);

    fv.validate().then(function (status) {
      if (status === 'Valid') {
        postFormData(setURLWorker + "/save-worker", formData)
          .done(onSaveWorkerSuccess)
          .fail(handleAjaxSaveError);
      }
    });
  });
});

function setupFormValidationChangePassword(form) {
  const validators = {
    notEmpty: message => ({
      validators: {
        notEmpty: { message }
      }
    }),
  };
  const validationRules = {
    employee_id: validators.notEmpty('เลือกข้อมูล พนักงาน'),
    use_tag: validators.notEmpty('เลือกข้อมูล ฝ่ายที่ปฏิบัติงาน'),
    status_tag: validators.notEmpty('เลือกข้อมูล สถานะ'),
  };

  return FormValidation.formValidation(formElement, {
    fields: validationRules,
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: '.col-md-6'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    },
  });
}

function onSaveActionSuccess(response) {

  if (response.status === 200) {
    Swal.fire({
      icon: 'success',
      text: 'บันทึกข้อมูลสำเร็จ',
      confirmButtonText: 'ตกลง'
    }).then((result) => {
      window.location.reload();
    });
  } else {
    Swal.fire({
      icon: 'error',
      text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
    })
  }
}

function reTable() {

}