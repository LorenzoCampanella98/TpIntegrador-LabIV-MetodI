<?php
ob_clean();
ob_end_flush();
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename=documento.pdf");
readfile("pdf/nombre_del_archivo.pdf");

?>