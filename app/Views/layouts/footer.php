    <script src="<?=base_url('bootstrap/js/jquery-3.7.1.js');?>"></script>
    <script src="<?=base_url('bootstrap/js/dataTables.js');?>"></script>
    <script src="<?=base_url('bootstrap/js/dataTables.buttons.js');?>"></script>

    <script src="<?=base_url('bootstrap/js/buttons.dataTables.js');?>"></script>


    <script src="<?=base_url('bootstrap/js/jszip.min.js');?>"></script>

    <script src="<?=base_url('bootstrap/js/pdfmake.min.js');?>"></script>

    <script src="<?=base_url('bootstrap/js/vfs_fonts.js');?>"></script>

    <script src="<?=base_url('bootstrap/js/buttons.html5.min.js');?>"></script>


    <script src="<?=base_url('bootstrap/js/dataTables.bootstrap5.js');?>"></script>
    <script src="<?=base_url('bootstrap/js/bootstrap.bundle.min.js');?>"></script>
    <script src="https://kit.fontawesome.com/1e0bbd4af0.js" crossorigin="anonymous"></script>
    

    <script>
        window.BASE_URL = '<?= base_url(); ?>';
    </script>
    <?php
        if ($cargarJS) {
            echo '<script src="' . base_url('assets/js/' . $js) . '"></script>';
        }
    ?>

    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function togglePassword2() {
            const passwordInput = document.getElementById('confirm_password');
            const toggleIcon = document.getElementById('toggleIcon2');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function mostrarEye() {
            const passwordInput = document.getElementById('password');
            const toggleIconBtn = document.querySelector('.password-toggle');

            if (!passwordInput || !toggleIconBtn) return;

            if (passwordInput.value.trim() !== '') {
                toggleIconBtn.classList.remove('toggle-desaparecer');
            } else {
                toggleIconBtn.classList.add('toggle-desaparecer');
            }
        }

        function mostrarEye2() {
            const passwordInput = document.getElementById('confirm_password');
            const toggleIconBtn = document.querySelector('.password-toggle2');

            if (!passwordInput || !toggleIconBtn) return;

            if (passwordInput.value.trim() !== '') {
                toggleIconBtn.classList.remove('toggle-desaparecer');
            } else {
                toggleIconBtn.classList.add('toggle-desaparecer');
            }
        }


    </script>
</body>
</html>