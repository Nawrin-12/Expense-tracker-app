<?php

namespace App\Traits;

trait ApiResponses{
    protected function ErrorMessage(){
        return response()->json([
            'message' => 'Something went wrong. Please try again'
        ]);
    }
}

