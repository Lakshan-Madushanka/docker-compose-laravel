<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class Test extends Controller
{
    public function __invoke()
    {
        $this->testMysqlConnection();
        $this->testMailHogConnection();
        $this->testRedisConnection();
    }

    public function testMysqlConnection()
    {
        $faker = Container::getInstance()->make(Generator::class);
        try {
            DB::table('users')->insert([
                'name'     => 'lakshan',
                'email'    => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);
            echo 'Mysql connection status : succeeded !<br/><br/><hr/>';
        } catch (QueryException $exception) {
            echo 'Mysql connection status : Error <br/><br/><hr/>';
            echo 'Info '.$exception->getMessage(). "<br/><br/><hr/>";
        };
    }

    public function testMailHogConnection()
    {
        try {
            Mail::to('test@mail.com')->send(new TestMail());
            echo "MailHog connection status : succeeded !<br/><br/><hr/>";
        } catch (\Exception $exception) {
            echo 'MailHog connection status : Error <br/><br/><hr/>';
            echo 'Info '.$exception->getMessage(), '<br/><br/><hr/>';
        }
    }

    public function testRedisConnection()
    {
       try{
            Redis::connection();
            echo "Redis connection status : succeeded !<br/><br/><hr/>";
        }catch (\Exception $exception) {
            echo 'Redis connection status : Error <br/><br/><hr/>';
            echo 'Info '.$exception->getMessage(), '<br/><br/><hr/>';
        }
    }
}
