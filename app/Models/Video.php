<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $primaryKey = 'video_id';

    public $timestamps = false;

    protected $fillable = ['video_section','video_title','video_image','video_description','video_date','video_time','video_vimeo','video_youtube','video_file','video_status','video_featured','video_role','video_added_on','video_added_by','video_updated_on','video_updated_by'];

    public static function getDetails($where)
    {
        $video = new Video;

        return $video->select('*')
                        ->join('video_sections','video_sections.video_section_id','videos.video_section')
                        ->where($where)
                        ->orderby('video_id','desc')
                        ->get();
    }

}
