<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;


class CommentsController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Comments(); 
    }

    public function index()
    {
        if(request()->has('page')){
            return $this->model->pagination([], request('page'));
        }
        else{
            return $this->model->pagination([]);  
        }
        
    }

    public function filterComments()
    {
        if(request()->has('column') && request()->has('type')){
             if(request()->has('page')){
                return $this->model->pagination([
                    'column' => request('column'),
                    'type' => request('type')
                ],request('page'));
             }
             else{
                return $this->model->pagination([
                    'column' => request('column'),
                    'type' => request('type')
                ]);  
             }
        }
        else{
            $this->index();
        }
    }

    public function loadResponses($commentId)
    {
        return $this->model->loadResponses($commentId);
    }

    public function getCapcha()
    {
        return response()->json(['capcha' => $this->model->generateCapcha()]);
    }

    public function getResponses($commentId){
        return response()->json(['responseComments' => $this->model->getResponses($commentId)]);
    }

    public function store(Request $request)
    {
        return $this->model->store($request);
    }

    public function delete($commentId)
    {
        return $this->model->deleteComment($commentId);
    }
}
