<html>
<body>
<table width="100%">
    <?php
    if (!empty($qr_data)) {
        for($i=1; $i<=count($qr_data); $i+=2) {

            $k = $i-1;
            $l = $i;
            $str = "";
            if(isset($qr_data[$l])){
                $str= "<tr>
                    <td width='50%' style='text-align: center;'>
                    <img src='".base_url()."qr/".$qr_data[$k]['qr']."'/>
                    </td>
                    <td width='50%' style='text-align: center;'>
                    <img src='".base_url()."qr/".$qr_data[$l]['qr']."'/>
                    </td>
                </tr>";
            }else{
                $str= "<tr>
                    <td width='50%' style='text-align: center;'>
                    <img src='".base_url()."qr/".$qr_data[$k]['qr']."'/>
                    </td>
                    <td width='50%' style='text-align: center;'>
                    </td>
                </tr>";
            }


            echo $str;
        }
    }
    ?>

</table>
<script>
    window.onload = function(){
        window.print();
    }
</script>
</body>
</html>