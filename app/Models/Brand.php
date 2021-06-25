<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use CrudTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'brands';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = [ 'id' ];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    public function setImageAttribute($value)
    {
        if ($value) {
            $destination_path = "uploads/brand";

            // if the image was erased
            if ($value == null) {
                // delete the image from disk
                \Storage::disk('local')->delete($this->image);

                // set null in the database column
                $this->attributes['image'] = null;
            }

            // if a base64 was sent, store it in the db
            if (str_starts_with($value, 'data:image')) {
                // 0. Make the image
                $image = \Image::make($value);
                $ext = str_replace('image/', '', $image->mime());
                // 1. Generate a filename.
                $filename = md5($value . time()) . '.' . $ext;
                // 2. Store the image on disk.
                \Storage::disk('local')->put('public/' . $destination_path . '/' . $filename, $image->stream());
//            Storage::disk('local')->put('file.txt', 'Contents');
                // 3. Save the path to the database
                $this->attributes['image'] = 'storage/' . $destination_path . '/' . $filename;
            }
        }

        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
