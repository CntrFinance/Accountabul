<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script> 

<!-- Toastr -->
<script src="../plugins/toastr/toastr.min.js"></script>

<!-- SweetAlert2 -->
<script src="../plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- bs-custom-file-input -->
<script src="../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script type="text/javascript">
    // jQuery(function(){
    //     var url = window.location.pathname, urlRegExp = new RegExp(url.replace(/\/$/,'') + "$");
    //     jQuery('.nav .nav-item a').each(function(){
    //         if(urlRegExp.test(this.href.replace(/\/$/,''))){
    //             jQuery(this).addClass('active');
    //         }
    //     });
    // });
</script>

<script type="text/javascript">
    jQuery(function(){
        var url = window.location.pathname, urlRegExp = new RegExp(url.replace(/\/$/,'') + "$");
        jQuery('.nav .nav-item a').each(function(){
            if(urlRegExp.test(this.href.replace(/\/$/,''))){
                jQuery(this).addClass('active');
                if(jQuery(this).parent().parent().prev().attr("href") == "#")
                {
                    jQuery(this).parent().parent().prev().addClass('active');
                    jQuery(this).parent().parent().parent().addClass('menu-is-opening menu-open');
                    jQuery(this).parent().parent().css("style", "display:block;");
                }
            }
        });
    });
</script>