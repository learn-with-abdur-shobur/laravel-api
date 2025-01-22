<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = Post::all();

        return response()->json( [
            'status'  => true,
            'message' => 'Get all post data',
            'data'    => $data,
        ] );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {

        // check valid
        $validation = Validator::make(
            $request->all(),
            [
                'title'       => 'required',
                'description' => 'required',
            ]
        );

        // if failed
        if ( $validation->fails() ) {
            return response()->json( [
                'status'  => false,
                'message' => 'validator error',
                'errors'  => $validation->errors()->all(),
            ], 401 );
        }

        try {
            $post = Post::create( [
                'title'       => $request->title,
                'description' => $request->description,
            ] );

            return response()->json( [
                'status'  => true,
                'message' => 'Create Success',
                'data'    => $post,
            ], 200 );
        } catch ( \Exception $e ) {
            return response()->json( [
                'status'  => false,
                'message' => 'An error occurred while creating the post.',
                'error'   => $e->getMessage(),
            ], 500 );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show( string $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {
        //
    }
}
