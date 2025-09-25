<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Firestore;
use Kreait\Laravel\Firebase\Facades\Firebase;

class MigrateFirebaseUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:migrate-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrar usuarios de Firebase Auth a Firestore Database';

    protected $auth;
    protected $firestore;

    public function __construct()
    {
        parent::__construct();

        $this->auth = app('firebase.auth');
        $this->firestore = Firebase::firestore()->database();
    }

    public function handle()
    {
        $this->info("Obteniendo usuarios de Firebase Auth...");

        try {
            $users = $this->auth->listUsers();

            foreach ($users as $firebaseUser) {
                $uid = $firebaseUser->uid;
                $email = $firebaseUser->email ?? '';
                
                // Revisar si el nombre ya existe en Firestore
                $docRef = $this->firestore->collection('users')->document($uid);
                $doc = $docRef->snapshot();
                $nombre = $doc->exists() ? $doc->get('nombre') : '(Sin nombre)';

                // Guardar email y passwordHash en Firestore
                $docRef->set([
                    'nombre' => $nombre,
                    'email' => $email,
                    'passwordHash' => $firebaseUser->passwordHash ?? null
                ], ['merge' => true]);

                $this->info("Usuario migrado: $uid - $nombre");
            }

            $this->info("Migración completada ✅");

        } catch (\Throwable $e) {
            $this->error("Error al migrar: " . $e->getMessage());
        }
    }
}
