<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category();
        $category->title =  "CSS chuyên sâu";
        $category->slug = Str::slug("css in depth").".html";
        $category->description = "Danh mục css";
        $category->parent_id = 0;
        $category->save();

        $user = new User();
        $user->name = "Nhat Nguyen";
        $user->email = "nhat@gmail.com";
        $user->password = Hash::make("12345678");
        $user->save();

        if($category && $user){
            $category_id = $category->id;
            $user_id = $user->id;
            
            if($category_id && $user_id) {
                $post = new Post();
                $post->title = "Responsive giao diện cực đỉnh với Container Queries";
                $post->slug = Str::slug("Responsive giao diện với Container Queries");
                $post->summary = "Đối với Frontend Developer thì việc tối ưu giao diện Responsive là điều hiển nhiên rồi.";
                $post->content = "Đối với Frontend Developer thì việc tối ưu giao diện Responsive là điều hiển nhiên rồi. Và chúng ta thông thường từ trước đến giờ là dùng Media Queries để làm việc đó. Đối với font-size thì mình đã giới thiệu cho các bạn cách làm ở bài viết sử dụng hàm clamp trong CSS rồi.";
                $post->user_id =  $user_id;
                $post->category_id = $category_id;
                $post->save();
            }
        }
    }
}
