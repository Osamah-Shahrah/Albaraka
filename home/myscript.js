//table users in  mang_user

// التحقق من تحميل jQuery
document.addEventListener("DOMContentLoaded", function () {
  const items = []; // تخزين العناصر مؤقتًا
  let count = 0; // عداد الصفوف






  // وظيفة لإضافة عنصر إلى الجدول
  document.getElementById("qw").addEventListener("click", function () {
      const name_mess_type = document.getElementById("name_mess_type").value;
      const weight_item = document.getElementById("weight_item").value;
      const cost_message = document.getElementById("cost_message").value;
      const item_details = document.getElementById("item_details").value;




      // التحقق من الحقول
      if (!name_mess_type || !weight_item || !cost_message ) {
        toastr.warning("يرجى ملء جميع الحقول!");
          return;
      }

      // إضافة العنصر إلى المصفوفة
      items.push({
          name_mess_types: name_mess_type,
          weight_items: parseFloat(weight_item),
          cost_messages: parseFloat(cost_message),
          item_detailss: item_details,
      });

      // تحديث الجدول
      const tableBody = document.getElementById("item_table_order").querySelector("tbody");
      const row = document.createElement("tr");
      row.innerHTML = `
          <td>${++count}</td>
          <td>${name_mess_type}</td>
          <td>${weight_item}</td>
          <td>${cost_message}</td>
          <td>${item_details}</td>
          <td><button type="button" class="remove-btn">حذف</button></td>
      `;
      tableBody.appendChild(row);

      
      // تفريغ الحقول
      document.getElementById("name_mess_type").selectedIndex=0;
      document.getElementById("weight_item").selectedIndex=0;
      document.getElementById("cost_message").value = "";
      document.getElementById("item_details").value = "";

      
        

      
  });

  // وظيفة لحذف عنصر من الجدول
  document.getElementById("item_table_order").addEventListener("click", function (e) {
      if (e.target.classList.contains("remove-btn")) {
          const row = e.target.parentElement.parentElement;
          const index = row.rowIndex - 1; // الحصول على الفهرس
          items.splice(index, 1); // حذف من المصفوفة
          row.remove(); // حذف من الجدول
      }
  });

  // إرسال البيانات إلى الخادم
  document.getElementById("messageForm").addEventListener("submit", function (e) {
      e.preventDefault();

      //to check the table
      if (items.length === 0) {
        toastr.error("يرجى إضافة عناصر إلى الرسالة قبل الإرسال!");
        return;
  }
        
    
      const formData = new FormData(this);
      formData.append("items", JSON.stringify(items));

      fetch("IIihjndiuh", {
          method: "POST",
          body: formData,
      })
          .then((response) => response.text())
          .then((data) => {
            if (data.includes("1")) {
              toastr.success('تم العملية بنجاح!');

                window.location.reload();
            } else {
              
                toastr.warning(data);

               
            }
        })

          
        .catch((error) => {
          console.error("حدث خطأ:", error);
          toastr.error('فشل الإرسال. يرجى المحاولة مرة أخرى.');

      });
      
  });







});












// التحقق من تحميل jQuery
document.addEventListener("DOMContentLoaded", function () {
  const items = []; // تخزين العناصر مؤقتًا
  let count = 0; // عداد الصفوف
  
  
  
  
  
  
  // وظيفة لإضافة عنصر إلى الجدول
  document.getElementById("edit_qw").addEventListener("click", function () {
  const edit_name_mess_type = document.getElementById("edit_name_mess_type").value;
  const edit_weight_item = document.getElementById("edit_weight_item").value;
  const edit_cost_message = document.getElementById("edit_cost_message").value;
  const edit_item_details = document.getElementById("edit_item_details").value;
  

  // التحقق من الحقول
  if (!edit_name_mess_type || !edit_weight_item || !edit_cost_message ) {
    toastr.warning("يرجى ملء جميع الحقول!");
  return;
  }
  
  // إضافة العنصر إلى المصفوفة
  items.push({
  name_mess_types: edit_name_mess_type,
  weight_items: parseFloat(edit_weight_item),
  cost_messages: parseFloat(edit_cost_message),
  item_detailss: edit_item_details,
  });
  
  // تحديث الجدول
  const tableBody = document.getElementById("edit_item_table_order").querySelector("tbody");
  const row = document.createElement("tr");
  row.innerHTML = `
  <td>${++count}</td>
  <td>${edit_name_mess_type}</td>
  <td>${edit_weight_item}</td>
  <td>${edit_cost_message}</td>
  <td>${edit_item_details}</td>
  <td><button type="button" class="remove-btn">حذف</button></td>
  `;
  tableBody.appendChild(row);
  
  
  // تفريغ الحقول
  document.getElementById("edit_name_mess_type").selectedIndex=0;
  document.getElementById("edit_weight_item").selectedIndex=0;
  document.getElementById("edit_cost_message").value = "";
  document.getElementById("edit_item_details").value = "";

  });
  

  // وظيفة لحذف عنصر من الجدول
  document.getElementById("edit_item_table_order").addEventListener("click", function (e) {
  if (e.target.classList.contains("remove-btn")) {
  const row = e.target.parentElement.parentElement;
  const index = row.rowIndex - 1; // الحصول على الفهرس
  items.splice(index, 1); // حذف من المصفوفة
  row.remove(); // حذف من الجدول
  }
  });
  
  // إرسال البيانات إلى الخادم
  document.getElementById("edit_messageForm").addEventListener("submit", function (e) {
  e.preventDefault();

  //to check the table
 //if (items.length === 0) {
 //toastr.error("يرجى إضافة عناصر إلى الرسالة قبل الإرسال!");
 //return;
 //}
  
  
  const formData = new FormData(this);
  formData.append("items", JSON.stringify(items));
  
  fetch("IIihjndiuh", {
  method: "POST",
  body: formData,
  })
  .then((response) => response.text())
  .then((data) => { 
  if (data.includes("1")) {
  toastr.success('تم العملية بنجاح!');
  edit_clearFields();
  edit_clearTable();
  window.location.reload();
  } else {
  
  toastr.warning(data);
  
  
  }
  })
  
  
  .catch((error) => {
  console.error("حدث خطأ:", error);
  toastr.error('فشل الإرسال. يرجى المحاولة مرة أخرى.');
  //edit_clearFields();
  //edit_clearTable();
  });
  
  });
  
  
  
  
  function edit_clearFields() {
  
  document.getElementById("edit_name_mess_type").selectedIndex=0;
  document.getElementById("edit_weight_item").selectedIndex=0;
  document.getElementById("edit_cost_message").value = "";
  document.getElementById("edit_item_details").value = "";
  //sender data
  document.getElementById("sender_name").value = "";
  document.getElementById("sender_phone").value = "";
  document.getElementById("cus_sen_id_card").value = "";
  document.getElementById("sender_imag_card").value = "";
  document.getElementById("cus_send_whatsapp").value = "";
  document.getElementById("sen_note").value = "";
  //recev data
  document.getElementById("recipient_name").value = "";
  document.getElementById("recipient_phone").value = "";
  document.getElementById("cus_rec_address").value = "";
  document.getElementById("rec_note").value = "";
  //trans data
  document.getElementById("gov").value = "";
  document.getElementById("id_branch_rec").value = "";
  document.getElementById("verify_message").checked = false;
  document.getElementById("money_received").value = "";
  document.getElementById("receive_image_sender").value = "";
  document.getElementById("order_note").value = "";
  
  const container1 = document.getElementById("imag_sender_imag_card");
  container1.querySelectorAll("img").forEach(img => img.remove());
  
  const container2 = document.getElementById("imag_receive_image_sender");
  container2.querySelectorAll("img").forEach(img => img.remove());
  }
  
  function clearTable() {
  const tableBody = document.getElementById("edit_item_table_order").querySelector("tbody");
  tableBody.innerHTML = ""; // تفريغ محتوى الجدول
  items.length = 0; // إعادة تعيين المصفوفة
  count = 0; // إعادة تعيين العداد
  }


  });













//form message show
$(function() {
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });

  $('.swalDefaultSuccess').click(function() {
    Toast.fire({
      type: 'success',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.swalDefaultInfo').click(function() {
    Toast.fire({
      type: 'info',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.swalDefaultError').click(function() {
    Toast.fire({
      type: 'error',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.swalDefaultWarning').click(function() {
    Toast.fire({
      type: 'warning',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.swalDefaultQuestion').click(function() {
    Toast.fire({
      type: 'question',
      title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });

  $('.toastrDefaultSuccess').click(function() {
    toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
  });
  $('.toastrDefaultInfo').click(function() {
    toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
  });
  $('.toastrDefaultError').click(function() {
    toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
  });
  $('.toastrDefaultWarning').click(function() {
    toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
  });

  $('.toastsDefaultDefault').click(function() {
    $(document).Toasts('create', {
      title: 'Toast Title',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultTopLeft').click(function() {
    $(document).Toasts('create', {
      title: 'Toast Title',
      position: 'topLeft',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultBottomRight').click(function() {
    $(document).Toasts('create', {
      title: 'Toast Title',
      position: 'bottomRight',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultBottomLeft').click(function() {
    $(document).Toasts('create', {
      title: 'Toast Title',
      position: 'bottomLeft',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultAutohide').click(function() {
    $(document).Toasts('create', {
      title: 'Toast Title',
      autohide: true,
      delay: 750,
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultNotFixed').click(function() {
    $(document).Toasts('create', {
      title: 'Toast Title',
      fixed: false,
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultFull').click(function() {
    $(document).Toasts('create', {
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
      title: 'Toast Title',
      subtitle: 'Subtitle',
      icon: 'fas fa-envelope fa-lg',
    })
  });
  $('.toastsDefaultFullImage').click(function() {
    $(document).Toasts('create', {
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
      title: 'Toast Title',
      subtitle: 'Subtitle',
      image: '../../dist/img/user3-128x128.jpg',
      imageAlt: 'User Picture',
    })
  });
  $('.toastsDefaultSuccess').click(function() {
    $(document).Toasts('create', {
      class: 'bg-success', 
      title: 'Toast Title',
      subtitle: 'Subtitle',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultInfo').click(function() {
    $(document).Toasts('create', {
      class: 'bg-info', 
      title: 'Toast Title',
      subtitle: 'Subtitle',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultWarning').click(function() {
    $(document).Toasts('create', {
      class: 'bg-warning', 
      title: 'Toast Title',
      subtitle: 'Subtitle',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultDanger').click(function() {
    $(document).Toasts('create', {
      class: 'bg-danger', 
      title: 'Toast Title',
      subtitle: 'Subtitle',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
  $('.toastsDefaultMaroon').click(function() {
    $(document).Toasts('create', {
      class: 'bg-maroon', 
      title: 'Toast Title',
      subtitle: 'Subtitle',
      body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    })
  });
});


$(function () {
  $("#users_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});


//table users in  mange_permission
$(function () {
  $("#users_table_perm").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});




//table for the order not complait insert data  from staff used in  send_me
$(function () {
  $("#show_all_order_not_complait").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});


//table for the order complait insert data  from staff used in  send_me
$(function () {
  $("#show_all_order_complait_send").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});





$(function () {
  $("#export_mes_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});


$(function () {
  $("#show_all_order").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});




$(function () {
  $("#page_prem").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});





$(function () {
  $("#cancel_or_back_order").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});



$(function () {
  $("#check_order_cancel").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});


$(function () {
  $("#check_order_compang").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

$(function () {
  $("#check_order_back").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});



$(function () {
  $("#all_check_order").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});


//table currency in myaccount page
$(function () {
  $("#currency_tab").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

//table jobs_table in myaccount page
$(function () {
  $("#jobs_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

//table mess_type in myaccount page
$(function () {
  $("#mess_type").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

//table branch in myaccount page
$(function () {
  $("#branch").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

//table to show the branch have mess dont send it in  mes_export
$(function () {
  $("#mes_export_branch_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

//table to show user type job driver have mess dont send it in  mes_export
$(function () {
  $("#mes_export_driver_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

//table to show user the order give driver use in  mes_export
$(function () {
  $("#show_order_giv_the_driver").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});




//table to show the branch and count mes give them use in  Driver_Receives
$(function () {
  $("#Driver_Receives_branch_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});






//table to show the branch and count mes the driver have use in  Delivery_Driver
$(function () {
  $("#Delivery_Driver_branch_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});



//table to show mess and can check the mess to give the branch use in  Delivery_Driver
$(function () {
  $("#check_Delivery_Driver_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});









//table to show the branch have messg use in  mes_import
$(function () {
  $("#mes_import_branch_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});


//table to show the user have messg from branch use in  mes_import
$(function () {
  $("#mes_import_driver_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});


//table to show mess accpeted and import fro the branch use in  mes_import
$(function () {
  $("#mes_import_show_order_giv_the_driver").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});







//table to show the the mess and number the items for all mess chocs use in  Driver_Receives
$(function () {
  $("#check_Driver_Receives_table").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

//table to show the messg for the reports for the user or branch use in show_re
$(function () {
  $("#show_order_for_report").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});

//table to show the messg complait recev for the customer use in mes_delivery
$(function () {
  $("#show_all_order_complait_recev").DataTable();
  $('#example2').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
  });
});



//script to  butoon swetch for enable or disbale the user  this cod used on page mange_user

$(document).ready(function () {
  $(document).on('change', 'input[name="user_status"]', function (event) {
    var user_status = $(this).val();
    var ste = (user_status === '1') ? 2 : 1;
    var comide = $(this).closest('tr').find('input[name="id_user"]').val();

    var r = window.confirm("هل تريد حقاً تغيير حالة المستخدم؟");

    if (r) {

      //alert("STE:"+ste);

      $.ajax({
        type: 'POST',
        url: 'IIihjndiuh',
        data: {
          stop_user: 1,
          stop_user_stat: ste,
          id_user_stop_stat: comide
        },
        success: function (data, status) {
          // Handle success response
          if (status === 'success') {
            window.location.reload();
          }
        },
        error: function (req, status) {
          // Handle error response
          console.log(req);
        }
      });
    }
  });
});








//script to  butoon swetch for enable or disbale the page permission  this cod used on page mange_permission

$(document).ready(function () {
  $(document).on('change', 'input[name="user_pages_status_per"]', function (event) {
    var user_pages_status_per = $(this).val();
    var ste = (user_pages_status_per === '1') ? 0 : 1;
    var id_page_per = $(this).closest('tr').find('input[name="id_page_per"]').val();
    var userid = $(this).closest('tr').find('input[name="id_user_page_per"]').val();

    var r = window.confirm("هل تريد حقاً تغيير حالة الصلاحية.");

    if (r) {

      //alert("STE:"+ste);


      $.ajax({
        type: 'POST',
        url: 'IIihjndiuh',
        data: {
          user_per_file: 1,
          stop_pre_stat: ste,
          id_page_stat: id_page_per,
          id_user_stat: userid
        },
        success: function (data, status) {
          // Handle success response
          if (status === 'success') {
            window.location.reload();
          }
        },
        error: function (req, status) {
          // Handle error response
          console.log(req);
        }
      });
    }
  });
});



//script to  butoon swetch for enable or disbale the message this cod used on page mes_export
$(document).ready(function () {
  // عند تغيير حالة checkbox

  $(document).on('click', 'button[name="driver_mess_status"]', function (event) {
    // الحصول على قيمة id_mess من الخاصية "value"
    var id_mess = $(this).attr('value'); // استخدام attr للحصول على القيمة من button
    var userid = $(this).closest('tr').find('input[name="driver_id_select"]').val();

    // إرسال البيانات عبر AJAX
    $.ajax({
      type: 'POST',
      url: 'IIihjndiuh',
      data: {
        driver_mess: 1,
        id_mess_stat: id_mess,
        id_user_stat: userid
      },
      success: function (response, status) {
        if (status === 'success') {

          // عرض رسالة نجاح
          showSuccessMessage('تم تنفيذ العملية بنجاح');
                    // تحديث بيانات الجدول فقط
                    updateTable();
        }
      },
      
      error: function (req, status) {
        console.log(req);
        // عرض رسالة خطأ
        showErrorMessage('حدث خطأ أثناء تنفيذ العملية');
      }
    });
  });

  // وظيفة لتحديث بيانات الجدول فقط
  function updateTable(id) {
    window.location.reload();
  }

  // وظيفة لعرض رسالة نجاح
  function showSuccessMessage(message) {
    // مثال باستخدام Toastr.js
    toastr.success(message);

  }

  // وظيفة لعرض رسالة خطأ
  function showErrorMessage(message) {
    toastr.error(message);
    
  }
});




//script to  butoon to reject the mess use in Driver Receives
$(document).ready(function () {
  // عند النقر على الزر الذي يحتوي على الاسم "reject_the_mess"
  $(document).on('click', 'button[name="reject_the_mess"]', function (event) {
    // الحصول على قيمة id_mess من الخاصية "value"
    var id_mess = $(this).attr('value'); // استخدام attr للحصول على القيمة من button


    // إرسال البيانات عبر AJAX
    $.ajax({
      type: 'POST',
      url: 'IIihjndiuh',
      data: {
        reject_driver_mess: 1,
        id_mess_stat: id_mess
       
      },
      success: function (response, status) {
        if (status === 'success') {

          // عرض رسالة نجاح
          showSuccessMessage('تم تنفيذ العملية بنجاح');
                    // تحديث بيانات الجدول فقط
                    updateTable();
        }
      },
      
      error: function (req, status) {
        console.log(req);
        // عرض رسالة خطأ
        showErrorMessage('حدث خطأ أثناء تنفيذ العملية');
      }
    });
  });

  // وظيفة لتحديث بيانات الجدول فقط
  function updateTable(id) {
    window.location.reload();
  }

  // وظيفة لعرض رسالة نجاح
  function showSuccessMessage(message) {
    // مثال باستخدام Toastr.js
    toastr.success(message);

  }

  // وظيفة لعرض رسالة خطأ
  function showErrorMessage(message) {
    toastr.error(message);
    
  }
});




//script to  butoon to Accept the mess use in Driver Receives
$(document).ready(function () {
  // عند النقر على الزر الذي يحتوي على الاسم "reject_the_mess"
  $(document).on('click', 'button[name="accept_the_mess"]', function (event) {
    // الحصول على قيمة id_mess من الخاصية "value"
    var id_mess = $(this).attr('value'); // استخدام attr للحصول على القيمة من button


    // إرسال البيانات عبر AJAX
    $.ajax({
      type: 'POST',
      url: 'IIihjndiuh',
      data: {
        accept_driver_mess: 1,
        id_mess_stat: id_mess
       
      },
      success: function (response, status) {
        if (status === 'success') {

          // عرض رسالة نجاح
          showSuccessMessage('تم تنفيذ العملية بنجاح');
                    // تحديث بيانات الجدول فقط
                    updateTable();
        }
      },
      
      error: function (req, status) {
        console.log(req);
        // عرض رسالة خطأ
        showErrorMessage('حدث خطأ أثناء تنفيذ العملية');
      }
    });
  });

  // وظيفة لتحديث بيانات الجدول فقط
  function updateTable(id) {
    window.location.reload();
  }

  // وظيفة لعرض رسالة نجاح
  function showSuccessMessage(message) {
    // مثال باستخدام Toastr.js
    toastr.success(message);

  }

  // وظيفة لعرض رسالة خطأ
  function showErrorMessage(message) {
    toastr.error(message);
    
  }
});




//script to  butoon to export the mess use in Driver Receives
$(document).ready(function () {
  // عند النقر على الزر الذي يحتوي على الاسم "reject_the_mess"
  $(document).on('click', 'button[name="export_mess_to_bra"]', function (event) {
    // الحصول على قيمة id_mess من الخاصية "value"
    var id_mess = $(this).attr('value'); // استخدام attr للحصول على القيمة من button


    // إرسال البيانات عبر AJAX
    $.ajax({
      type: 'POST',
      url: 'IIihjndiuh',
      data: {
        export_mess_to_bra: 1,
        id_mess_stat: id_mess
       
      },
      success: function (response, status) {
        if (status === 'success') {

          // عرض رسالة نجاح
          showSuccessMessage('تم تنفيذ العملية بنجاح');
                    // تحديث بيانات الجدول فقط
                    updateTable();
        }
      },
      
      error: function (req, status) {
        console.log(req);
        // عرض رسالة خطأ
        showErrorMessage('حدث خطأ أثناء تنفيذ العملية');
      }
    });
  });

  // وظيفة لتحديث بيانات الجدول فقط
  function updateTable(id) {
    window.location.reload();
  }

  // وظيفة لعرض رسالة نجاح
  function showSuccessMessage(message) {
    // مثال باستخدام Toastr.js
    toastr.success(message);

  }

  // وظيفة لعرض رسالة خطأ
  function showErrorMessage(message) {
    toastr.error(message);
    
  }
});


//script to  butoon to export all the mess use in Driver Receives
$(document).ready(function () {
  
  // عند النقر على الزر الذي يحتوي على الاسم "export_all_mess_to_br"
  $(document).on('click', 'button[name="export_all_mess_to_br"]', function (event) {
    // الحصول على قيمة id_mess من الخاصية "value"
    var id_branch_selected = $(this).attr('value'); // استخدام attr للحصول على القيمة من button
    toastr.success("fghf");
    showSuccessMessage('تم تنفيذ العملية بنجاح');
    // إرسال البيانات عبر AJAX
    $.ajax({
      type: 'POST',
      url: 'IIihjndiuh',
      data: {
        export_all_mess_to_br: 1,
        id_branch_select_for_all: id_branch_selected
       
      },
      success: function (response, status) {
        if (status === 'success') {

          // عرض رسالة نجاح
          showSuccessMessage('تم تنفيذ العملية بنجاح');
                    // تحديث بيانات الجدول فقط
                    updateTable();
        }
      },
      
      error: function (req, status) {
        console.log(req);
        // عرض رسالة خطأ
        showErrorMessage('حدث خطأ أثناء تنفيذ العملية');
      }
    });
  });

  // وظيفة لتحديث بيانات الجدول فقط
  function updateTable(id) {
    window.location.reload();
  }

  // وظيفة لعرض رسالة نجاح
  function showSuccessMessage(message) {
    // مثال باستخدام Toastr.js
    toastr.success(message);

  }

  // وظيفة لعرض رسالة خطأ
  function showErrorMessage(message) {
    toastr.error(message);
    
  }
});



//script to  butoon to reject the mess use in mes_import
$(document).ready(function () {
  // عند النقر على الزر الذي يحتوي على الاسم "reject_the_mess"
  $(document).on('click', 'button[name="reject_the_mess_mes_import"]', function (event) {
    // الحصول على قيمة id_mess من الخاصية "value"
    var id_mess = $(this).attr('value'); // استخدام attr للحصول على القيمة من button


    // إرسال البيانات عبر AJAX
    $.ajax({
      type: 'POST',
      url: 'IIihjndiuh',
      data: {
        reject_branch_mess: 1,
        id_mess_stat: id_mess
       
      },
      success: function (response, status) {
        if (status === 'success') {

          // عرض رسالة نجاح
          showSuccessMessage('تم تنفيذ العملية بنجاح');
                    // تحديث بيانات الجدول فقط
                    updateTable();
        }
      },
      
      error: function (req, status) {
        console.log(req);
        // عرض رسالة خطأ
        showErrorMessage('حدث خطأ أثناء تنفيذ العملية');
      }
    });
  });

  // وظيفة لتحديث بيانات الجدول فقط
  function updateTable(id) {
    window.location.reload();
  }

  // وظيفة لعرض رسالة نجاح
  function showSuccessMessage(message) {
    // مثال باستخدام Toastr.js
    toastr.success(message);

  }

  // وظيفة لعرض رسالة خطأ
  function showErrorMessage(message) {
    toastr.error(message);
    
  }
});




//script to  butoon to Accept the mess use in mes_import
$(document).ready(function () {
  // عند النقر على الزر الذي يحتوي على الاسم "reject_the_mess"
  $(document).on('click', 'button[name="accept_the_mess_mes_import"]', function (event) {
    // الحصول على قيمة id_mess من الخاصية "value"
    var id_mess = $(this).attr('value'); // استخدام attr للحصول على القيمة من button


    // إرسال البيانات عبر AJAX
    $.ajax({
      type: 'POST',
      url: 'IIihjndiuh',
      data: {
        accept_branch_mess: 1,
        id_mess_stat: id_mess
       
      },
      success: function (response, status) {
        if (status === 'success') {

          // عرض رسالة نجاح
          showSuccessMessage('تم تنفيذ العملية بنجاح');
                    // تحديث بيانات الجدول فقط
                    updateTable();
        }
      },
      
      error: function (req, status) {
        console.log(req);
        // عرض رسالة خطأ
        showErrorMessage('حدث خطأ أثناء تنفيذ العملية');
      }
    });
  });

  // وظيفة لتحديث بيانات الجدول فقط
  function updateTable(id) {
    window.location.reload();
  }

  // وظيفة لعرض رسالة نجاح
  function showSuccessMessage(message) {
    // مثال باستخدام Toastr.js
    toastr.success(message);

  }

  // وظيفة لعرض رسالة خطأ
  function showErrorMessage(message) {
    toastr.error(message);
    
  }
});


