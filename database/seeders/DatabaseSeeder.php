<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            //nombre y correo aleatorio para el usuario de prueba
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);

        //crear categorias
        $categorias= Category::factory(10)->create([
            'nombre' => fake()->word(),
            'descripcion' => fake()->sentence(),
        ]);
        
        //crear tareas
        Task::factory(50)->create([
            'user_id' => $user->id,
            'category_id' => $categorias->random()->id,
        ]);
    }
}
