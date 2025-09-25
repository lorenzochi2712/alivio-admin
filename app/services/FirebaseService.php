<?php

namespace App\Services;

use Google\Cloud\Firestore\FirestoreClient;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\File; // ✅ correcto

class FirebaseService
{
    protected $firebase;
    protected $auth;
    protected $firestore;

    public function __construct()
    {
        // Ruta del archivo JSON de credenciales de Firebase
        $serviceAccount = base_path(env('FIREBASE_CREDENTIALS')); 

        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri("https://" . env('FIREBASE_PROJECT_ID') . ".firebaseio.com");

        $this->auth = $this->firebase->createAuth();

        // Firestore usando SDK de Google
        $this->firestore = new FirestoreClient([
            'projectId' => env('FIREBASE_PROJECT_ID'),
            'keyFilePath' => $serviceAccount,
        ]);
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }

    public function getFirestore(): FirestoreClient
    {
        return $this->firestore;
    }
    public function register()
{
    $this->app->singleton(\App\Services\FirebaseService::class, function ($app) {
        return new \App\Services\FirebaseService();
    });
}

}
