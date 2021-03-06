<?php
require_once '../upload.php';

if (!empty($_FILES['file']['error']) && $_FILES['file']['error'] === 1) {
    return 'There was an error uploading your file';
} else {
    $upload = new UploadFiles();
    return $upload->process($_FILES);
}