<?php

namespace Database\Factories\Task;

use App\Models\Task\Task;
use App\Models\Task\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'deadline' => '2023-12-29 23:59:59',
            'start_date' => '2023-10-31 00:00:00',
            'end_date' => '2023-11-30 23:59:59',
            'status' => 'pendding',
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'task_type_id' => function () {
                return Type::factory()->create()->id;
            },
        ];
    }
}
