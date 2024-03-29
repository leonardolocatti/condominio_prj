<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

    <footer>
        <nav class="navbar fixed-bottom">
            <p class="h6 m-auto text-center">
                Desenvolvido na disciplina Projeto de Sistemas - IFSP Câmpus São Carlos
            </p>
        </nav>
    </footer>

    <!-- jQuery JS -->
    <script src="<?php echo base_url('application/assets/jquery/jquery-3.4.1.js') ?>"></script>

    <!-- jQuery Mask Plugin -->
    <script src="<?php echo base_url('application/assets/jquery/plugins/mask_plugin/jquery.mask.js') ?>"></script>

    <!-- DataTables JS -->
    <script src="<?php echo base_url('application/assets/datatables/datatables.js') ?>"></script>

    <!-- Bootstrap JS -->
    <script src="<?php echo base_url('application/assets/bootstrap/js/bootstrap.bundle.js') ?>"></script>
    
    <!-- Full Calendar -->
    <script src="<?php echo base_url('application/assets/fullcalendar/packages/core/main.js') ?>"></script>
    <script src="<?php echo base_url('application/assets/fullcalendar/packages/daygrid/main.js') ?>"></script>

    <!-- Arquivo principal de JS -->
    <script src="<?php echo base_url('application/assets/personalizado/js/principal.js') ?>"></script>


    <!-- Arquivos JS personalizados -->
    <?php foreach ($js_array as $js) { ?>
        <script src="<?php echo $js ?>"></script>
    <?php } ?>

    <!-- Variáveis úteis -->
    <script>
        var base_url = '<?php echo base_url() ?>';
        var site_url = '<?php echo site_url() ?>';
    </script>

</body>
</html>
