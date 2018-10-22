<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //生成假数据
        $users = factory(\App\Models\User::class)->times(10)->make()->each(function ($u) {
            //遍历进行调整
        });

        //使隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password','remember_token'])->toArray();

        \App\Models\User::insert($user_array);

        $user = \App\Models\User::find(1);
        $user->name = '何佳农';
        $user->email = 'jianonghe@gmail.com';
        $user->phone_number = '18780260029';
        $user->qq_number = '405745000';
        $user->password = bcrypt('hejiang335200');
        $user->save();
        $user->assignRole(['Founder']);

        $user = \App\Models\User::find(2);
        $user->name = '田';
        $user->email = '1451850833@qq.com';
        $user->phone_number = '17760489695';
        $user->qq_number = '1451850833';
        $user->password = bcrypt('123456');
        $user->save();
        $user->assignRole('Founder');

        $user = \App\Models\User::find(3);
        $user->assignRole('Maintainer');
    }
}
