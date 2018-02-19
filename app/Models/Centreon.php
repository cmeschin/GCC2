<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centreon extends Model
{
    protected $connection = 'centreon';
    
    protected $table = 'servicegroup';
    
    
    
    public function prestations()
    {
        
        $prestations = $this->all('sg_name');
        return $prestations;
    }
    
}
