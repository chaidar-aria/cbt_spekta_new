// Mengatur waktu akhir perhitungan mundur

var countDownDate = new Date("Jul 20, 2021 11:00:00").getTime();

// Memperbarui hitungan mundur setiap 1 detik
var x = setInterval(function () {
  // Untuk mendapatkan tanggal dan waktu hari ini
  var now = new Date().getTime();

  // Temukan jarak antara sekarang dan tanggal hitung mundur
  var distance = countDownDate - now;

  // Perhitungan waktu untuk hari, jam, menit dan detik
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Keluarkan hasil dalam elemen dengan id = "demo"
  document.getElementById("clock").innerHTML =
    hours + " : " + minutes + " : " + seconds;

  // Jika hitungan mundur selesai, tulis beberapa teks
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("clock").innerHTML = "WAKTU HABIS";
    Swal.fire({
      icon: "error",
      title: "WAKTU HABIS",
      text: "Waktu ujian telah habis",
      timer: 1000,
    }).then(function () {
      window.location.href = "../finish/";
    });
  }
}, 1000);
