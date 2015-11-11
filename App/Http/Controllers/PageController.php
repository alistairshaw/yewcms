<?php namespace AlistairShaw\YewCMS\App\Http\Controllers;

use stdClass;
use View;

class PageController extends YewBaseController {

    public function page($slug)
    {
        $page = new stdClass;
        $page->title = 'Title';
        $page->meta_description = 'Meta Description';
        $page->meta_keywords = 'Meta Keywords';
        $page->slug = $slug;

        return View::make('yewcms::page', ['page' => $page]);
    }

}