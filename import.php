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

        $truncate = "TRUNCATE TABLE simpanan";

        if ($mysqli->query($truncate) === TRUE) {
            $type = "eror";
            $message = "Data gagal diimport";
        }
        for ($i = 1; $i <= $sheetCount; $i++) {
            $cif = "";
            if (isset($spreadSheetAry[$i][0])) {
                $cif = $mysqli->real_escape_string($spreadSheetAry[$i][0]);
            }
            // echo 'customer_note === '.$customer_note."<br>";

            $nama_debitur = "";
            if (isset($spreadSheetAry[$i][1])) {
                $nama_debitur = $mysqli->real_escape_string($spreadSheetAry[$i][1]);
            }
            // echo 'customer_username === '.$customer_username."<br>";

            $produk_simpanan = "";
            if (isset($spreadSheetAry[$i][2])) {
                $produk_simpanan = $mysqli->real_escape_string($spreadSheetAry[$i][2]);
            }
            // echo 'item_name === '.$item_name."<br>";

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
            // echo 'quantity === '.$quantity."<br>";

            $instanding = "";
            if (isset($spreadSheetAry[$i][4])) {
                $instanding = $mysqli->real_escape_string($spreadSheetAry[$i][4]);
                $instanding_baru = str_replace(',', '', $instanding);
            }



            $query = "INSERT INTO simpanan(cif, nama_debitur, produk_simpanan, norek, instanding)
                VALUES ('$cif', '$nama_debitur', '$produk_simpanan', '$norek_baru', '$instanding_baru')";
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
