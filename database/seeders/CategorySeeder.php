<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'title' => 'HTML',
                'slug' => 'html',
                'description' => 'HTML adalah singkatan dari Hypertext Markup Language',
                'thumbsnail' => 'noimage.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
            ],
            [
                'title' => 'HTML basic',
                'slug' => 'html-basic-1',
                'description' => 'HTML tingkat dasar',
                'thumbsnail' => 'noimage.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => 1
            ],
            [
                'title' => 'HTML advanced',
                'slug' => 'html-advanced-1',
                'description' => 'HTML tingkat dasar',
                'thumbsnail' => 'noimage.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => 1
            ],
            [
                'title' => 'CSS',
                'slug' => 'css',
                'description' => 'CSS atau Cascading Style Sheets adalah salah satu topik yang harus diketahui dalam pengembangan website.',
                'thumbsnail' => 'noimage.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
            ],
            [
                'title' => 'Javascript',
                'slug' => 'javascript',
                'description' => 'JavaScript adalah salah satu bahasa pemrograman yang sering digunakan oleh website programmer atau website developer.',
                'thumbsnail' => 'noimage.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
            ],
            [
                'title' => 'PHP',
                'slug' => 'php',
                'description' => 'Hypertext Preprocessor adalah bahasa skrip yang dapat ditanamkan atau disisipkan ke dalam HTML. PHP banyak dipakai untuk memprogram situs web dinamis. PHP dapat digunakan untuk membangun sebuah CMS.',
                'thumbsnail' => 'noimage.jpg',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'parent_id' => null
            ],
        ]);
    }
}
