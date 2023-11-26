<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class Attachment extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function fileDelete(Request $request, $taskId){
        $attach = Attachment::find($taskId);

        if ($attach){
         if (file_exists($attach->path)){
           unlink($attach->path);
         }
          $attach->delete();
        }

        die();

    }
}
