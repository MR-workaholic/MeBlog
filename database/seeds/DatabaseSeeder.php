<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        $this->call('TagTableSeeder');
        $this->call('PostTableSeeder');
        

        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}

// class PostTableSeeder extends Seeder
// {
// 	public function run()
// 	{
// 		Post::truncate();
// 		factory(Post::class, 20)->create();
// 	}
// }
