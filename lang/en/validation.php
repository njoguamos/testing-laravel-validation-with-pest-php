<?php

declare(strict_types=1);

return [

    'custom' => [
        'name' => [
            'required' => 'Please enter your name.',
            'string' => 'Your name is missing.',
            'min' => 'Name is too short. Try your first and last name.',
            'max' => 'Name is too long. Please shorten your name and try again.',
        ],
        'email' => [
            'required' => 'Email address is required.',
            'email' => 'Enter a valid email e.g yourname@gmail.com.',
            'max' => 'Email is too long. Please shorten your email and try again.',
            'unique' => 'Email is already registered. Try another one or reset password.',
        ],
        'password' => [
            'required' => 'Enter a password.',
            'min'      => 'Password should be at least 8 characters. Add a word or two.',
            'max'      => 'Password needs to be less than 128 characters. Please enter a short one.'
        ],
    ],
];
