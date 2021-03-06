<?php
require_once '../UploadFile.php';

if (!empty($_FILES['file']['error']) && $_FILES['file']['error'] === 1) {
    echo  404;
} else {
    $upload = new UploadFiles();
    echo json_encode($upload->process($_FILES));
}