<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSection extends Model
{
    protected $table = 'video_sections';

    protected $primaryKey = 'video_section_id';

    public $timestamps = false;

    protected $fillable = ['video_section_title','video_section_image','video_section_status','video_section_added_on','video_section_role','video_section_added_by','video_section_updated_on','video_section_updated_by'];

    public static function getDetails($where)
    {
        $video_section = new VideoSection;

        return $video_section->select('*')
                        ->where($where)
                        ->orderby('video_section_id','desc')
                        ->get();
    }

}
