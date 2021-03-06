<?php
require_once '../UploadFile.php';

if (!empty($_FILES['file']['error']) && $_FILES['file']['error'] === 1) {
    echo http_response_code(500);
} else {
    try {
        $upload = new UploadFiles();
        echo json_encode($upload->process($_FILES));
    } catch(Exception $e){
        echo http_response_code(500);
    }
}