<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Firestore;

class FirebaseUserController extends Controller
{
    protected $auth;
    protected $firestore;

    public function __construct(FirebaseAuth $auth, Firestore $firestore)
    {
        $this->auth = $auth;
        $this->firestore = $firestore;
    }

    public function index()
    {
        // Obtener usuarios de Authentication
        $users = [];
        foreach ($this->auth->listUsers() as $firebaseUser) {
            // Buscar nombre en Firestore usando uid
            $doc = $this->firestore
                ->database()
                ->collection('users') // nombre de tu colección en Firestore
                ->document($firebaseUser->uid)
                ->snapshot();

            $name = $doc->exists() ? $doc->get('name') : '(Sin nombre)';

            $users[] = [
                'uid' => $firebaseUser->uid,
                'email' => $firebaseUser->email,
                'name' => $name,
            ];
        }

        return view('admin.users.index', compact('users'));
    }
}
