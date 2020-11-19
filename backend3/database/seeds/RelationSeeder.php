<?php

use Illuminate\Database\Seeder;
use App\Enums\ThumbnailStatus;

class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = DB::table('articles')->get();
        foreach($articles as $article){

            $random_tags = DB::table('tags')->inRandomOrder()->take(2)->get();
            DB::table('article_tag')->insert([
                    [
                        'article_id'    => $article->id,
                        'tag_id'        => $random_tags[1]->id,
                    ],
                    [
                        'article_id'    => $article->id,
                        'tag_id'        => $random_tags[0]->id,
                    ]
                ]
            );

            $i= 0;
            while($i<4){
                $image = factory(App\Image::class)->create([
                    'user_id' => $article->author_id,
                ]);
                $isThumbnail = ( ($i == 0) ? ThumbnailStatus::isThumbnail : ThumbnailStatus::isNotThumbnail );
                DB::table('article_image')->insert(
                    [
                        'article_id'    => $article->id,
                        'image_id'      => $image->id,
                        'isThumbnail'   => $isThumbnail

                    ],
                );
                $i++;
            }
        }
    }
}
