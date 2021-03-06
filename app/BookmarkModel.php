<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BookmarkModel extends Model
{
    function scopeGetIduser($query, $iduser)
    {
        return DB::table('bookmark')
        ->where('bookmark.id', $iduser)
        ->orderBy('bookmark.idbookmark', 'desc')
        ->limit(1)
        ->value('idbookmark');
    }
    function scopeAdd($query, $data)
    {
    	return DB::table('bookmark')->insert($data);
    }
    function scopeRemove($query, $idimage, $id)
    {
    	return DB::table('bookmark')
    	->where('idimage', $idimage)
    	->where('id', $id)
    	->delete();
    }
    function scopeCheck($query, $idimage, $id)
    {
    	return DB::table('bookmark')
    	->where('idimage', $idimage)
    	->where('id', $id)
    	->value('idbookmark');
    }
    function scopeTotal($query, $id)
    {
    	return DB::table('bookmark')
    	->where('id', $id)
    	->count('idbookmark');
    }
}
