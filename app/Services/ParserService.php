<?

namespace App\Services;


class ParserService{

    private $validText = '';

    private function invalidTagsSearching(string $text)
    {
        $validTags = [
            '/<a href="https?:\/\/[\w\W.]+">[\w\W]+<\/a>/',
            '/<code>[\w\W]+<\/code>/',
            '/<i>[\w\W]+<\/i>/',
            '/<strong>[\w\W]+<\/strong>/'
        ];
        
        if (preg_match_all('/<([a-z]+)[^>]*>.*?<\/\1>/', $text, $matches)) {
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
        preg_match_all('/<([a-z]+)(?=[\s>])[^>]*>/', $text, $matches);

        foreach($matches[0] as $tag){
            if(str_contains('$tag', '<a')){
                $tag = str_replace('[\s][\w\W]+>', '>', $tag);

                if(substr_count($text, $tag) !== substr_count($text, str_replace('<', '</', $tag))){
                    return 'Wrong HTML';
                }
            }
        }

        return 1;
    }

    public function parsHTML(string $text)
    {
        $this->validText = $this->invalidTagsSearching($text);
        $this->validText = $this->closeOpenTagsParsing($text);

        return $this->validText;
    }

}