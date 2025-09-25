<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FirebaseUserController extends Controller
{
    protected $projectId;
    protected $apiKey;

    public function __construct()
    {
        $this->projectId = env('FIREBASE_PROJECT_ID');
        $this->apiKey = env('FIREBASE_API_KEY');
    }

    /**
     * Listar usuarios con paginación
     */
    public function index(Request $request)
    {
        try {
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users";
            $response = Http::get($url, ['key' => $this->apiKey]);
            $data = $response->json();

            $allUsers = [];
            foreach ($data['documents'] ?? [] as $doc) {
                $fullId = $doc['name'] ?? '';
                $uid = substr(strrchr($fullId, '/'), 1);

                $allUsers[] = [
                    'uid' => $uid,
                    'nombre' => $doc['fields']['nombre']['stringValue'] ?? '(Sin nombre)',
                    'email' => $doc['fields']['email']['stringValue'] ?? '(Sin email)',
                ];
            }

            // Si es búsqueda en vivo (AJAX)
            if ($request->ajax()) {
                $search = strtolower($request->get('search', ''));
                $filtered = array_filter($allUsers, function ($user) use ($search) {
                    return str_contains(strtolower($user['nombre']), $search);
                });
                return response()->json(array_values($filtered));
            }

            // Paginación manual
            $perPage = 10;
            $currentPage = $request->get('page', 1);
            $offset = ($currentPage - 1) * $perPage;
            $users = new \Illuminate\Pagination\LengthAwarePaginator(
                array_slice($allUsers, $offset, $perPage),
                count($allUsers),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return view('admin.users.index', compact('users'));
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'No se pudo conectar con Firestore REST',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($uid)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users/{$uid}";
        $response = Http::get($url, ['key' => $this->apiKey]);

        if (!$response->successful()) {
            return redirect()->route('users.index')->with('error', 'Usuario no encontrado');
        }

        $data = $response->json();

        $user = [
            'uid' => $uid,
            'nombre' => $data['fields']['nombre']['stringValue'] ?? '',
            'email' => $data['fields']['email']['stringValue'] ?? '',
        ];

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, $uid)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users/{$uid}?key={$this->apiKey}";

        $body = [
            "fields" => [
                "nombre" => ["stringValue" => $request->nombre],
                "email" => ["stringValue" => $request->email],
            ]
        ];

        $response = Http::patch($url, $body);

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
        }

        return redirect()->route('users.index')->with('error', 'No se pudo actualizar el usuario');
    }

    /**
     * Eliminar usuario
     */
    public function destroy($uid)
    {
        $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users/{$uid}?key={$this->apiKey}";
        $response = Http::delete($url);

        if ($response->successful()) {
            return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
        }

        return redirect()->route('users.index')->with('error', 'No se pudo eliminar el usuario');
    }
}
