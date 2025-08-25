<?php

namespace App\Console\Commands;

use App\Models\CatTipoDeUsuario;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ProbarRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:roles {usuario_email?} {--todos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar el sistema de roles haciendo peticiones a las APIs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔥 PROBANDO SISTEMA DE ROLES 🔥');
        $this->newLine();

        if ($this->option('todos')) {
            $this->probarTodosLosUsuarios();
        } elseif ($this->argument('usuario_email')) {
            $this->probarUsuarioEspecifico($this->argument('usuario_email'));
        } else {
            $this->mostrarMenuInteractivo();
        }
    }

    private function mostrarMenuInteractivo()
    {
        $opcion = $this->choice(
            '¿Qué usuario quieres probar?',
            [
                'Administrador (angel.zavaleta@campeche.gob.mx)',
                'Supervisor (angel21zavaleta@gmail.com)',
                'Ciudadano (zava05utrera@gmail.com)',
                'Probar todos',
            ]
        );

        $emails = [
            'angel.zavaleta@campeche.gob.mx',
            'angel21zavaleta@gmail.com',
            'zava05utrera@gmail.com',
        ];

        if ($opcion === 'Probar todos') {
            $this->probarTodosLosUsuarios();
        } else {
            $index = array_search($opcion, [
                'Administrador (angel.zavaleta@campeche.gob.mx)',
                'Supervisor (angel21zavaleta@gmail.com)',
                'Ciudadano (zava05utrera@gmail.com)',
            ]);
            $this->probarUsuarioEspecifico($emails[$index]);
        }
    }

    private function probarTodosLosUsuarios()
    {
        $usuarios = [
            'angel.zavaleta@campeche.gob.mx' => 'Administrador',
            'angel21zavaleta@gmail.com' => 'Supervisor',
            'zava05utrera@gmail.com' => 'Ciudadano',
        ];

        foreach ($usuarios as $email => $rol) {
            $this->info("📋 PROBANDO: $rol ($email)");
            $this->probarUsuarioEspecifico($email, false);
            $this->newLine();
        }
    }

    private function probarUsuarioEspecifico(string $email, bool $mostrarHeader = true)
    {
        if ($mostrarHeader) {
            $this->info("📋 PROBANDO USUARIO: $email");
            $this->newLine();
        }

        // Obtener usuario y token
        $usuario = User::where('email', $email)->first();

        if (! $usuario) {
            $this->error("❌ Usuario no encontrado: $email");

            return;
        }

        $tipoUsuario = CatTipoDeUsuario::find($usuario->cat_tipo_usuario_id);
        $rol = $tipoUsuario?->tipo ?? 'Sin rol';

        // Generar token temporal
        $token = $usuario->createToken('test-command')->plainTextToken;

        $this->comment("👤 Rol: $rol");
        $this->comment('🔑 Token: '.substr($token, 0, 20).'...');
        $this->newLine();

        // Probar diferentes endpoints
        $endpoints = [
            'Acceso básico' => ['GET', '/api/mi-info', true],
            'Solo Admin' => ['GET', '/api/admin/test-solo-admin', $rol === 'Administrador'],
            'Admin + Supervisor' => ['GET', '/api/gestion/test-admin-supervisor', in_array($rol, ['Administrador', 'Supervisor'])],
            'Ciudadano + Colectivo' => ['GET', '/api/ciudadano/test-ciudadano-colectivo', in_array($rol, ['Ciudadano', 'Colectivo'])],
        ];

        foreach ($endpoints as $nombre => $config) {
            [$metodo, $url, $deberiaFuncionar] = $config;
            $this->probarEndpoint($nombre, $metodo, $url, $token, $deberiaFuncionar);
        }

        // Limpiar token temporal
        $usuario->tokens()->where('name', 'test-command')->delete();
    }

    private function probarEndpoint(string $nombre, string $metodo, string $url, string $token, bool $deberiaFuncionar)
    {
        try {
            $respuesta = Http::withHeaders([
                'Authorization' => "Bearer $token",
                'Accept' => 'application/json',
            ])->{strtolower($metodo)}(config('app.url').$url);

            $exitoso = $respuesta->successful();
            $codigo = $respuesta->status();

            if ($deberiaFuncionar) {
                if ($exitoso) {
                    $this->info("✅ $nombre: CORRECTO (HTTP $codigo)");
                } else {
                    $this->error("❌ $nombre: FALLÓ - Debería funcionar (HTTP $codigo)");
                }
            } else {
                if (! $exitoso && $codigo === 403) {
                    $this->info("✅ $nombre: CORRECTO - Acceso denegado como esperado (HTTP $codigo)");
                } elseif ($exitoso) {
                    $this->error("❌ $nombre: FALLÓ - No debería tener acceso pero sí lo tiene (HTTP $codigo)");
                } else {
                    $this->warn("⚠️  $nombre: Acceso denegado con código inesperado (HTTP $codigo)");
                }
            }
        } catch (\Exception $e) {
            $this->error("💥 $nombre: ERROR - ".$e->getMessage());
        }
    }
}
