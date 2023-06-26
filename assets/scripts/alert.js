function logout() {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger",
    },
    buttonsStyling: false,
  });

  swalWithBootstrapButtons
    .fire({
      title: "Logout CBT?",
      text: "",
      icon: "warning",
      showCancelButton: false,
      confirmButtonText: "Keluar",
      reverseButtons: true,
    })
    .then((result) => {
      if (result.isConfirmed) {
        window.location.href = "../../config/logout.php";
      }
    });
}