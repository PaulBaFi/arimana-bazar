<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("logoutBtn")?.addEventListener("click", function() {
        Swal.fire({
            title: "¿Cerrar sesión?",
            text: "Tu sesión actual se cerrará.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, salir",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "logout.php";
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Cliente eliminado correctamente',
                showConfirmButton: false,
                timer: 1500
            });
        } else if (status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Error al eliminar el cliente',
                text: 'Intente nuevamente más tarde.',
            });
        } else if (status === 'no_encontrado') {
            Swal.fire({
                icon: 'error',
                title: 'Cliente o tipo cliente no encontrado',
                text: 'Intente nuevamente más tarde.',
            });
        }
    });
</script>