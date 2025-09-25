<?php
require 'vendor/autoload.php';

putenv('GOOGLE_CLOUD_PHP_GRPC_ENABLED=true'); // prueba gRPC
// putenv('GOOGLE_CLOUD_PHP_GRPC_ENABLED=false'); // prueba REST

use Google\Cloud\Firestore\FirestoreClient;

try {
    $firestore = new FirestoreClient([
        'projectId' => 'motos-fabb6',
    ]);

    $doc = $firestore->collection('users')->document('test')->snapshot();

    if ($doc->exists()) {
        echo "Documento encontrado: " . $doc->get('name');
    } else {
        echo "El documento no existe.";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
