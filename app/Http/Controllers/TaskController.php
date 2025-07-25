<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request, Column $column ) {
        $data = $request->validate( [
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image',
            'due_date'    => 'nullable|date',
            'column_id'   => 'required|numeric',
        ] );

        if ( $request->hasFile( 'image' ) ) {
            $data['image'] = $request->file( 'image' )->store( 'tasks', 'public' );
        }

        $data['slug'] = Str::slug( $data['title'] );

        Task::create( $data );

        return back();
    }

    public function move( Request $request, Task $task ) {
        $request->validate( [
            'column_id' => 'required|exists:columns,id',
            'order'     => 'array',
            'order.*'   => 'integer',
        ] );

        $task->update( ['column_id' => $request->column_id] );

        // Update order if list of task IDs is provided
        if ( $request->has( 'order' ) ) {
            foreach ( $request->order as $index => $id ) {
                Task::where( 'id', $id )->update( ['order' => $index] );
            }
        }

        return response()->json( ['success' => true] );
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $id ) {
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
