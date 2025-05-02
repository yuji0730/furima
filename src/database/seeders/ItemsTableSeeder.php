<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
        'name' => 'Alice',
        'email' => 'alice@example.com',
        'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
        'name' => 'Bob',
        'email' => 'bob@example.com',
        'password' => bcrypt('password'),
        ]);

        DB::table('items')->insert([
            [
                'user_id' => $user1->id,
                'name' => '腕時計',
                'price' => '15000',
                'image' => 'Armani+Mens+Clock.jpg',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition' => '1'
            ],
            [
                'user_id' => $user1->id,
                'name' => 'HDD',
                'price' => '5000',
                'image' => 'HDD+Hard+Disk.jpg',
                'description' => '高速で信頼性の高いハードディスク',
                'condition' => '2'
            ],
            [
                'user_id' => $user1->id,
                'name' => '玉ねぎ3束',
                'price' => '300',
                'image' => 'iLoveIMG+d.jpg',
                'description' => '新鮮な玉ねぎ3束のセット',
                'condition' => '3'
            ],
            [
                'user_id' => $user1->id,
                'name' => '革靴',
                'price' => '4000',
                'image' => 'Leather+Shoes+Product+Photo.jpg',
                'description' => 'クラシックなデザインの革靴',
                'condition' => '4'
            ],
            [
                'user_id' => $user1->id,
                'name' => 'ノートPC',
                'price' => '45000',
                'image' => 'Living+Room+Laptop.jpg',
                'description' => '高性能なノートパソコン',
                'condition' => '1'
            ],
            [
                'user_id' => $user2->id,
                'name' => 'マイク',
                'price' => '8000',
                'image' => 'Music+Mic+4632231.jpg',
                'description' => '高音質のレコーディング用マイク',
                'condition' => '2'
            ],
            [
                'user_id' => $user2->id,
                'name' => 'ショルダーバッグ',
                'price' => '3500',
                'image' => 'Purse+fashion+pocket.jpg',
                'description' => 'おしゃれなショルダーバッグ',
                'condition' => '3'
            ],
            [
                'user_id' => $user2->id,
                'name' => 'タンブラー',
                'price' => '500',
                'image' => 'Tumbler+souvenir.jpg',
                'description' => '使いやすいタンブラー',
                'condition' => '4'
            ],
            [
                'user_id' => $user2->id,
                'name' => 'コーヒーミル',
                'price' => '4000',
                'image' => 'Waitress+with+Coffee+Grinder.jpg',
                'description' => '手動のコーヒーミル',
                'condition' => '1'
            ],
            [
                'user_id' => $user2->id,
                'name' => 'メイクセット',
                'price' => '2500',
                'image' => '外出メイクアップセット.jpg',
                'description' => '便利なメイクアップセット',
                'condition' => '2'
            ],
        ]);
    }
}
