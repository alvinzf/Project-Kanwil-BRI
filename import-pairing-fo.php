<?php
if (isset($_POST["import"])) {

    $allowedFileType = [
        'application/vnd.ms-excel',
        'text/xls',
        'text/xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {

        $targetPath = 'uploads/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadSheet = $Reader->load($targetPath);
        $excelSheet = $spreadSheet->getActiveSheet();
        $spreadSheetAry = $excelSheet->toArray();
        // print_r($spreadSheetAry); exit;
        $sheetCount = count($spreadSheetAry);
        $truncate = "TRUNCATE TABLE `pairing-fo`";

        if ($mysqli->query($truncate) === TRUE) {
            $type = "eror";
            $message = "Data gagal diimport";
        }

        for ($i = 1; $i <= $sheetCount; $i++) {
            $pn_ao = "";
            if (isset($spreadSheetAry[$i][0])) {
                $pn_ao = $mysqli->real_escape_string($spreadSheetAry[$i][0]);
                $pn_ao_length = strlen($pn_ao);
                if ($pn_ao_length == 5) {
                    $fixing = "000";
                    $fixing .= $pn_ao;
                    $pn_ao_baru = $fixing;
                }
                if ($pn_ao_length == 6) {
                    $fixing = "00";
                    $fixing .= $pn_ao;
                    $pn_ao_baru = $fixing;
                }
                if ($pn_ao_length == 7) {
                    $fixing = "0";
                    $fixing .= $pn_ao;
                    $pn_ao_baru = $fixing;
                }
                if ($pn_ao_length == 8) {
                    $pn_ao_baru = $pn_ao;
                }
            }
            // echo 'customer_note === '.$customer_note."<br>";

            $nama_ao = "";
            if (isset($spreadSheetAry[$i][1])) {
                $nama_ao = $mysqli->real_escape_string($spreadSheetAry[$i][1]);
            }
            // echo 'customer_username === '.$customer_username."<br>";

            $jg_ao = "";
            if (isset($spreadSheetAry[$i][2])) {
                $jg_ao = $mysqli->real_escape_string($spreadSheetAry[$i][2]);
            }

            $nama_kanca = "";
            if (isset($spreadSheetAry[$i][3])) {
                $nama_kanca = $mysqli->real_escape_string($spreadSheetAry[$i][3]);
            }

            $nama_uker = "";
            if (isset($spreadSheetAry[$i][4])) {
                $nama_uker = $mysqli->real_escape_string($spreadSheetAry[$i][4]);
            }


            $pn_fo = "";
            if (isset($spreadSheetAry[$i][5])) {
                $pn_fo = $mysqli->real_escape_string($spreadSheetAry[$i][5]);
                $pn_fo_length = strlen($pn_fo);
                if ($pn_fo_length == 5) {
                    $fixing = "000";
                    $fixing .=  $pn_fo;
                    $pn_fo_baru = $fixing;
                }
                if ($pn_fo_length == 6) {
                    $fixing = "00";
                    $fixing .= $pn_fo;
                    $pn_fo_baru = $fixing;
                }
                if ($pn_fo_length == 7) {
                    $fixing = "0";
                    $fixing .=  $pn_fo;
                    $pn_fo_baru = $fixing;
                }
                if ($pn_fo_length == 8) {
                    $pn_fo_baru =  $pn_fo;
                }
            }
            // echo 'quantity === '.$quantity."<br>";

            $nama_fo = "";
            if (isset($spreadSheetAry[$i][6])) {
                $nama_fo = $mysqli->real_escape_string($spreadSheetAry[$i][6]);
            }

            $jg_fo = "";
            if (isset($spreadSheetAry[$i][7])) {
                $jg_fo = $mysqli->real_escape_string($spreadSheetAry[$i][7]);
            }


            $query = "INSERT INTO `pairing-fo`(nama_kanca, nama_uker, pn_ao, nama_ao, jg_ao, pn_fo, nama_fo, jg_fo)
                VALUES ('$nama_kanca', '$nama_uker', '$pn_ao_baru', '$nama_ao', '$jg_ao', '$pn_fo_baru', '$nama_fo', '$jg_fo')";
            //    echo 'query === '.$query; exit;
            if ($mysqli->query($query) === TRUE) {
                $type = "success";
                $message = "Data berhasil diimport";
            } else {
                $type = "error";
                $message = "Terjadi kesalahan, silahkan coba lagi";
            }
        }
    } else {
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
    }
}
