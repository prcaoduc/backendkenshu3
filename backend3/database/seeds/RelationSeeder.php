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

        $journalist_role = Role::where('slug', 'journalist')->first();
        $editor_role = Role::where('slug', 'editor')->first();

        $user1 = factory(User::class)->create([
            'name'  =>  'ジャーナリスト 1',
            'email' =>  'jl1@test.test',
        ]);
        $user1->roles()->attach($journalist_role);

        $user2 = factory(User::class)->create([
            'name'  =>  'ジャーナリスト 2',
            'email' =>  'jl2@test.test',
        ]);
        $user2->roles()->attach($journalist_role);

        $user3 = factory(User::class)->create([
            'name'  =>  'エディター',
            'email' =>  'ed@test.test',
        ]);
        $user3->roles()->attach([$editor_role, $journalist_role]);
    }
}
