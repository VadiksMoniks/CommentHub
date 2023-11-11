<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\FileService;

class Comments extends Model
{
    use HasFactory;

    protected $table = 'comments';
    public $timestamps = false;
    protected $fillable = ['text', 'username', 'created_at', 'answer_to'];
    private $validText = '';
    private $capcha = [
        'capcha1' => '2b827',
        'capcha2' => '2g7nm',
        'capcha3' => '22d5n',
        'capcha4' => '25m6p',
        'capcha5' => '25w53',
        'capcha6' => '226md',
        'capcha7' => '243mm',
        'capcha8' => '244e2',
        'capcha9' => '253dc',
        'capcha10' => '268g2'
    ];

    private function checkCapcha($capchaName, $text)
    {
        if($this->capcha[$capchaName] != $text){
            return 'Wrong capcha';
        }
        else{
            return 1;
        }
    }

    private function invalidTagsSearching(string $text)
    {
        $validTags = [
            '/<a href="https?:\/\/[\w\W.]+">/',
            '/<code>/',
            '/<i>/',
            '/<strong>/',
        ];
        
        if (preg_match_all('/<([a-z]+)[^>]*>/', $text, $matches)) {
            foreach ($matches[0] as $match) {
                $isValid = false;
                for ($i=0; $i<4; $i++) {
                    if (preg_match($validTags[$i] , $match)) {
                        $isValid = true;
                        break;
                    }
                }
                if (!$isValid) {
                    return "Invalid HTML tag";
                }
            }
        }
        
        return 1;
    }

    private function closeOpenTagsParsing(string $text)
    {
        preg_match_all('/<([a-z]+)(?=[\s>])[^>]*>/', $text, $openTags);
        preg_match_all('/<\/([a-z]+)(?=[\s>])[^>]*>/', $text, $closeTags);
        
        if(count($openTags[0]) !== count($closeTags[0])){
            return 'Wrong HTML';
        }

        for ($i = count($openTags[0]) - 1; $i >= 0; $i--) {
            if(str_contains($openTags[0][$i], '<a')){
                $openTags[0][$i] = str_replace('[\s][\w\W]+>', '>', $openTags[0][$i]);
            }

            if(str_replace('<', '</', $openTags[0][$i]) === $closeTags[0][$i]){
                array_pop($openTags[0]);
            }
        }

        if(count($openTags[0]) !== 0){
            return 'Wrong HTML';
        }

        return 1;
    }

    private function parsHTML(string $text)
    {
        $this->validText = $this->invalidTagsSearching($text);
        if($this->validText != 1)
        {
            return $this->validText;
        }

        $this->validText = $this->closeOpenTagsParsing($text);

        if($this->validText != 1)
        {
            return $this->validText;
        }

        return 1;
    }

    private function storeFiles(array $files)
    {
        $paths = [];
        try{
            foreach($files as $key => $file){
    
                $paths[$key] =  $files[$key]->storeAs('media', bin2hex(random_bytes(3)).'-'.$files[$key]->getClientOriginalName());
            }
    
            return $paths;
        }
        catch(\Exception $e){
            $this->deleteUnstoredFiles($files);

            if($paths != []){
                $this->deleteStoredFiles($paths);
            }

            return $e;
        }
    }

    private function deleteStoredFiles(array $files)
    {
        foreach($files as $file){
            $filePath = storage_path('app/' . $file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
         }
    }

    private function deleteUnstoredFiles(array $files)
    {
        foreach($files as $file){
            if (file_exists($file->path())) {
                unlink($file->path());
            }
         }
    }

    public function generateCapcha()
    {
        return 'capcha'.mt_rand(1, 10);
    }


    public function store(Request $request)
    {
        $request->validate([
            'comment' => ['required'],
            'username' => ['required'],
            'document' => ['mimes:txt', 'max:100'],
            'image' => ['image','mimes:jpeg,png,jpg,gif'],
            'capcha' => ['required'],
            'textFromCapcha' => ['required']
        ]);

        $capchaverification = $this->checkCapcha($request->capcha, $request->textFromCapcha);

        if($capchaverification != 1){
            return response()->json(['message' => $capchaverification], 422);
        }

        $files = [];
        //$fileService = new FileService();

        if($request->hasFile('document')){
            $files['document'] = $request->file('document');
        }

        if($request->hasFile('image')){
            $files['image'] = $request->file('image');
        }

        $commentValidation = self::parsHTML($request->comment);

        if($commentValidation != 1)
        {
            $this->deleteUnstoredFiles($files);
            return response()->json(['message' => $commentValidation], 422);
        }

        $comment = new Comments();
        $comment->text = $request->comment;
        $comment->username = $request->username;
        $comment->created_at = date('Y-m-d H:i:s');

        $paths = $this->storeFiles($files);

        if(gettype($paths) != 'array'){
            return response()->json(['message' => $paths], 422);
        }

        if(array_key_exists('document', $paths)){
            $comment->document = $paths['document'];
        }
        if(array_key_exists('image', $paths)){
            $comment->image = $paths['image'];
        }

        try{
            $comment->save();
            $this->deleteUnstoredFiles($files);
            if($request->answer_to){
                DB::table('answers')->insert([
                    'comment_id' => $comment->id,
                    'answer_comment_id' => $request->answer_to
                ]);
            }

            return response()->json(['message' => 'Your comment was added'], 200);
        }
        catch(\PDOException $e){
            $this->deleteStoredFiles($paths);
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function deleteComment($commentId)
    {
        $comment = Comments::where('comments.id', $commentId)->first(['document', 'image']); 
    
        $paths = [];
    
        if ($comment->document != null) {
            $paths['document'] = $comment->document;
        }
        if ($comment->image != null) {
            $paths['image'] = $comment->image;
        }
    
        if ($paths != []) {
            $this->deleteStoredFiles($paths);
        }

        $responses = DB::table('answers')->where('answer_comment_id', $commentId)->get(['comment_id']);
    
        if (!$responses->isEmpty()) {
            foreach ($responses as $comment_id) {
                $this->deleteComment($comment_id->comment_id);
            }
        }
    
        try {
            Comments::where('id', $commentId)->delete();
            DB::table('answers')->where('answer_comment_id', $commentId)->delete();
            DB::table('answers')->where('comment_id', $commentId)->delete();
            return response()->json(['message' => 'Your comment was deleted'], 200);
        } catch (\PDOException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function checkResponses($commentId)
    {
        $responses = DB::table('answers')
            ->where('answer_comment_id', $commentId)
            ->get();
    
        return !$responses->isEmpty();
    }


    public function pagination($filters = [], $page = 1, $perPage = 3)
    {

        $comments = null;
        $hasResponses = [];
        if($filters === []){
            $comments = DB::table('comments')
            ->select('comments.id', 'comments.username', 'comments.text', 'comments.created_at', 'accounts.avatar', 'comments.document', 'comments.image')
            ->leftJoin('accounts', 'comments.username', '=', 'accounts.username')
            ->whereNotIn('comments.id', function($query) {
                $query->select('comment_id')->from('answers');
            })
            ->orderBy('comments.id', 'DESC')
                ->paginate($perPage, ['*'], 'page', $page);
    
            foreach($comments as $comment){

                $hasResponses[$comment->id] = DB::table('answers')->where('answer_comment_id', $comment->id)->count();

                if($comment->document != null){
                    $comment->document = file_get_contents(getcwd().'/../storage/app/'.$comment->document);
                }
            }

        }
        else{
            $comments = DB::table('comments')
            ->select('comments.id', 'comments.username', 'comments.text', 'comments.created_at', 'accounts.avatar', 'comments.document', 'comments.image')
            ->leftJoin('accounts', 'comments.username', '=', 'accounts.username')
            ->whereNotIn('comments.id', function($query) {
                $query->select('comment_id')->from('answers');
            })
            ->orderBy($filters['column'], $filters['type'])
                ->paginate($perPage, ['*'], 'page', $page);
                $comments->appends(['column' => $filters['column'], 'type' => $filters['type']]);
            foreach($comments as $comment){

                $hasResponses[$comment->id] = DB::table('answers')->where('answer_comment_id', $comment->id)->count();

                if($comment->document != null){
                    $comment->document = file_get_contents(getcwd().'/../storage/app/'.$comment->document);
                }
            }
        }
        
        return response()->json(['comments' => $comments, 'hasResponses' => $hasResponses]);
    }

    public function loadResponses($commentId)
    {

        $hasResponses = [];
        $responses =  DB::table('comments')
        ->select('comments.id', 'comments.username', 'comments.text', 'comments.created_at', 'accounts.avatar', 'comments.document', 'comments.image')
        ->leftJoin('accounts', 'comments.username', '=', 'accounts.username')
        ->leftJoin('answers', 'comments.id', '=', 'answers.comment_id')
        ->where('answers.answer_comment_id', $commentId)->orderBy('comments.created_at', 'ASC')->get();

        foreach($responses as $response){
            $hasResponses[$response->id] = DB::table('answers')->where('answer_comment_id', $response->id)->count();

            if($response->document != null){
                $response->document = file_get_contents(getcwd().'/../storage/app/'.$response->document);
            }

         }
         return response()->json(['responses' => $responses, 'hasResponses' => $hasResponses]);
    }
}



  /*  */