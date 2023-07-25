<?php

use App\Models\User;
use Illuminate\Support\Str;

function getLongName(): string
{
    return Str::repeat(string: 'name', times: rand(min: 30, max: 50));
}

function getATakenEmail(): string
{
    $takenEmail = 'taken@example.com';
    User::factory()->create(['email' => $takenEmail]);
    return $takenEmail;
}

dataset(name: 'validation-rules', dataset: [
    'name is required' => ['name', '', fn() => __(key: 'validation.custom.name.required')],
    'name be a string' => ['name', ['array'], fn() => __(key: 'validation.custom.name.string')],
    'name not too short' => ['name', 'ams', fn() => __(key: 'validation.custom.name.min')],
    'name not too long' => ['name', getLongName(), fn() => __(key: 'validation.custom.name.max')],

    'email is required' => ['email', '', fn() => __(key: 'validation.custom.email.required')],
    'email be valid' => ['email', 'esthernjerigmail.com', fn() => __(key: 'validation.custom.email.email')],
    'email not too long' => ['email', fn() => getLongName() . '@gmail.com', fn() => __(key: 'validation.custom.email.max')],
    'email be unique' => ['email', fn() => getATakenEmail(), fn() => __(key: 'validation.custom.email.unique')],

    'password is required' => ['password', '', fn() => __(key: 'validation.custom.password.required')],
    'password be >=8 chars' => ['password', 'Hf^gsg8', fn() => __(key: 'validation.custom.password.min')],
    'password be uncompromised' => ['password', 'password', 'The given password has appeared in a data leak. Please choose a different password.'],
    'password not too long' => ['password', fn() => getLongName(), fn() => __(key: 'validation.custom.password.max')],
]);


it(
    description: 'can validate user inputs',
    closure: function (string $field, string|array $value, string $message) {

    $data = [
        'name' => fake()->name(),
        'email' => fake()->unique()->email(),
        'password' => fake()->password(minLength: 8),
    ];

    $response = $this->post(
        uri: route(name: 'register'),
        data: [...$data, $field => $value]
    );

    $response->assertSessionHasErrors(keys: [$field => $message]);

    $this->assertGuest();
})->with('validation-rules');
