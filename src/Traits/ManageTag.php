<?php

namespace Fpaipl\Panel\Traits;

use PhpParser\Node\Expr\Cast\Bool_;

trait ManageTag
{
    public function manageTag(array $data): bool
    {
        if(!empty($data['_token'])){
            unset($data['_token']);
        }
        if(!empty($data['image'])){
            unset($data['image']);
        }
        if(!empty($data['images'])){
            unset($data['images']);
        }
        $this->tags = implode(",", $data);
        if($this->save()) return true; else return false;
    }

   
}
