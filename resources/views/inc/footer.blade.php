<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; <?php
        $fromYear = 2015; 
        $thisYear = (int)date('Y'); 
        echo $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '');
    ?> <a href="https://quadcorn.co.ke" target="_blank">Quadcorn Business Solutions</a>.</strong>
    All rights reserved.
</footer>