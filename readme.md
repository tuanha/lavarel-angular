* - composer require barryvdh/laravel-debugbar

1. Su dung log:
    - luu log o file nhat dinh trong 1 function
    /var/www/html/laravel53/app/Http/Controllers/UsersController.php

2. Su dung transaction trong SQL
    /var/www/html/laravel53/app/Http/Controllers/UsersController.php

3. Notification
    php artisan vendor:publish --tag=laravel-notifications
    way 1:
        $user = User::find(31);
        $user->notify(new InvoicePaid());
    way 2
        Notification::send(User::all(),new InvoicePaid());

4. Mail
    $email = 'demo@demo.com';
    Mail::send('Mail.demo',[
        'email' => $email,
    ],function ($mail) use ($email){
        $mail->to($email)->subject('demo');
    });

5. CRUD
    https://laravel.com/docs/5.3/artisan
    /var/www/html/laravel53/app/Console/Commands/makeController.php
    https://laracasts.com/discuss/channels/tips/l5-artisan-command-makemodel?page=1

6. Show log sql
    DB::enableQueryLog();
        ##code query##
    dd(DB::getQueryLog());

7. Multi view with another device
    https://github.com/jenssegers/agent