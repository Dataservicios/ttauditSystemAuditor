<?php
namespace Auditor\Repositories;

use Auditor\Entities\Media;


class MediaRepo extends BaseRepo{

    public function getModel()
    {
        return new Media();
    }

    public function photosPollStore($poll_id="0",$store_id="0")
    {
        $photos = \DB::table('medias')->where('poll_id', $poll_id)->where('store_id', $store_id)->where('tipo', 1)->get();
        return $photos;
    }

    public function photosPublicityStore($publicity_id="0",$store_id="0")
    {
        $photos = \DB::table('medias')->where('publicities_id', $publicity_id)->where('store_id', $store_id)->where('tipo', 1)->get();
        return $photos;
    }

} 