<html>


<body>
    <?php $arreglo = array();
    array_push($arreglo,"Lorenzo1");
    array_push($arreglo,"Lorenzo2");
    array_push($arreglo,"Lorenzo3");
    array_push($arreglo,"Lorenzo4");
    array_push($arreglo,"Lorenzo5");
     ?>
    <table border="1">
        <tr>
            <td>Nombre</td>
        </tr>
        <tr>
            <?php foreach($arreglo as $value) { ?>
            <td><?php echo $value?></td>
           <?php } ?>
        </tr>
    </table>
</body>
</html>