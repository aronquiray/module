<?php

use Illuminate\Database\Seeder;
use DummyNameSpaceClass\Models\DummyClass\DummyClass as Model;
use DummyNameSpaceClass\Models\Core\Page\Page;
use HalcyonLaravel\History\Facades\History;
use App\Models\Auth\User;
use App\Models\Core\Menu\Menu;

/**
 * Class AuthTableSeeder.
 */
class DummyClassTableSeeder extends Seeder
{
    use DisableForeignKeys;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $user = User::skip(1)->first();

        // Page
        $page = Page::create([
            'title' => 'Dummy Class',
            'slug' => str_slug('dummy class'),
            'type' => 'dummy class',
            'status' => 'enable',
            'template' => Model::VIEW_FRONTEND_PATH . '.index'
            ]);
        $page->metable()->create([
            'name' => 'Dummy Class',
            'description' => 'List of all dummy classes',
            'keywords' => 'page,dummy-class',
            'user_id' => $user->id,
            ]);
        
        $pageCount = Page::count();
         
        foreach (Menu::all() as $menu) {
            $page->menuable()->create([
                'name' => $page->title,
                'slug' => $page->slug,
                'menu_id' => $menu->id,
                'order' => $pageCount++,
                'options' => '[]'
                ]);
        }

        History::created($page, $user);

        foreach (factory(Model::class, 20)->create() as $model) {
            $model->metable()->create([
                'name' => $model->title,
                'description' => $model->title,
                'keywords' => str_replace('-', ',', $model->slug),
                'user_id' => $user->id,
            ]);
            History::created($model, $user);
        }

        $this->enableForeignKeys();
    }
}
