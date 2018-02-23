

<?php
$mi_pdf = '1517.pdf';
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="'. $mi_pdf .'"');
header('Content-Transfer-Encoding: binary');
header('Accept-ranges: bytes');
@readfile($mi_pdf);
?>