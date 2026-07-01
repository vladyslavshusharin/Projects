<?php 
function uploadDoc($file){
    $target_dir = "../dokumenty/";

    if(isset($file["tmp_name"]) || $file["tmp_name"] !== ""){

    try{

        // Ověření, že soubor byl nahrán
        if(!isset($file["tmp_name"]) || $file["tmp_name"] === ""){
            throw new Exception("Nebyl vybrán žádný dokument.");
        }

        $tmp_path = $file['tmp_name'];
        $allowed_mime = "application/pdf";
        $file_type = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        // Validace MIME typu a přípony
        if(mime_content_type($tmp_path) !== $allowed_mime || $file_type !== 'pdf'){
            throw new Exception("Soubor musí být formátu PDF!");
        }

        // Validace velikosti
        if($file['size'] > 5 * 1000 * 1000){
            throw new Exception("Soubor je příliš velký. Maximální velikost je 5 MB.");
        }

        // Kontrola složky pro nahrávání
        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0755, true)) {
                throw new Exception("Nepodařilo se vytvořit složku pro nahrávání dokumentů.");
            }
        }

        // Unikátní název souboru
        $unique_name = uniqid("dokument_", true) . "." . $file_type;
        $target_file = $target_dir . $unique_name;

        //Uložení souboru

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Chyba při přesunu nahraného dokumentu do cílové složky.");
        }

        return [
            'success' => true,
            'message' => "Dokument byl úspěšně nahrán.",
            'path' => $target_file
        ];


    } catch(Exception $e){

        return [
            'success' => false,
            'message' => $e->getMessage(),
            'path' => null
        ];

    }

  }

}

?>