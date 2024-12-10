// Configure Toastr globally for reuse
function configure_toastr() {
  toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
  };
}

// Show notification for adding a user
function show_add() {
  configure_toastr();
  toastr["info"]("User added successfully", "Add User");
}

// Show notification for deleting a user
function show_del() {
  configure_toastr();
  toastr["error"]("User deleted successfully", "Delete User");
}

// Show notification for updating a user
function show_update() {
  configure_toastr();
  toastr["success"]("User updated successfully", "Update User");
}

// Confirm delete action
function confirm_delete(id) {
  let del = confirm("Do you want to delete the user?");
  if (del) {
      console.log("Delete action confirmed for ID:", id);
      window.location.href = "index.php?action=del&id=" + id; // Fixed URL concatenation
  }
}

// Redirect to edit page for updating user details
function edit(id) {
  console.log("Edit action triggered for ID:", id);
  window.location.href = "add_user.php?action=update&id=" + id; // Fixed URL concatenation
}
