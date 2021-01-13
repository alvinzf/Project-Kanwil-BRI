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
        $truncate = "TRUNCATE TABLE debitur";

        if ($mysqli->query($truncate) === TRUE) {
            $type = "eror";
            $message = "Data gagal diimport";
        }
        for ($i = 1; $i <= $sheetCount; $i++) {
            $periode = "";
            if (isset($spreadSheetAry[$i][0])) {
                $periode = $mysqli->real_escape_string($spreadSheetAry[$i][0]);
            }

            $nama_kanca = "";
            if (isset($spreadSheetAry[$i][1])) {
                $nama_kanca = $mysqli->real_escape_string($spreadSheetAry[$i][1]);
            }

            $kode_kanca = "";
            if (isset($spreadSheetAry[$i][2])) {
                $kode_kanca = $mysqli->real_escape_string($spreadSheetAry[$i][2]);
                $kode_kanca_length = strlen($kode_kanca);
                if ($kode_kanca_length == 1) {
                    $fixing = "000";
                    $fixing .= $kode_kanca;
                    $kode_kanca_baru = $fixing;
                }
                if ($kode_kanca_length == 2) {
                    $fixing = "00";
                    $fixing .= $kode_kanca;
                    $kode_kanca_baru = $fixing;
                }
                if ($kode_kanca_length == 3) {
                    $fixing = "0";
                    $fixing .= $kode_kanca;
                    $kode_kanca_baru = $fixing;
                }
                if ($kode_kanca_length == 4) {
                    $kode_kanca_baru = $kode_kanca;
                }
            }

            $norek = "";
            if (isset($spreadSheetAry[$i][3])) {
                $norek = $mysqli->real_escape_string($spreadSheetAry[$i][3]);
                $norek_length = strlen($norek);
                if ($norek_length == 12) {
                    $fixing = "000";
                    $fixing .= $norek;
                    $norek_baru = $fixing;
                }
                if ($norek_length == 13) {
                    $fixing = "00";
                    $fixing .= $norek;
                    $norek_baru = $fixing;
                }
                if ($norek_length == 14) {
                    $fixing = "0";
                    $fixing .= $norek;
                    $norek_baru = $fixing;
                }
                if ($norek_length == 15) {
                    $norek_baru = $norek;
                }
            }
            // echo 'customer_note === '.$customer_note."<br>";

            $nama_debitur = "";
            if (isset($spreadSheetAry[$i][4])) {
                $nama_debitur = $mysqli->real_escape_string($spreadSheetAry[$i][4]);
            }


            $plafond = "";
            if (isset($spreadSheetAry[$i][5])) {
                $plafond = $mysqli->real_escape_string($spreadSheetAry[$i][5]);
                $plafond_baru = str_replace(',', '', $plafond);
            }

            $os = "";
            if (isset($spreadSheetAry[$i][6])) {
                $os = $mysqli->real_escape_string($spreadSheetAry[$i][6]);
                $os_baru = str_replace(',', '', $os);
            }

            $cif = "";
            if (isset($spreadSheetAry[$i][7])) {
                $cif = $mysqli->real_escape_string($spreadSheetAry[$i][7]);
            }


            $pn_ao = "";
            if (isset($spreadSheetAry[$i][8])) {
                $pn_ao = $mysqli->real_escape_string($spreadSheetAry[$i][8]);
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


            $nama_ao = "";
            if (isset($spreadSheetAry[$i][9])) {
                $nama_ao = $mysqli->real_escape_string($spreadSheetAry[$i][9]);
            }

            $kol_adk = "";
            if (isset($spreadSheetAry[$i][10])) {
                $kol_adk = $mysqli->real_escape_string($spreadSheetAry[$i][10]);
            }


            $query = "INSERT INTO debitur(periode, kode_kanca, nama_kanca, cif, norek, nama_debitur, plafond, os, pn_ao, nama_ao, kol_adk)
                VALUES ('$periode', '$kode_kanca_baru', '$nama_kanca', '$cif', '$norek_baru', '$nama_debitur', '$plafond_baru', '$os_baru', '$pn_ao_baru', '$nama_ao', '$kol_adk')";

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
