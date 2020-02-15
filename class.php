<?php
//    ________                          ___  ____         _
//   |_   __  |                        |_  ||_  _|       / |_
//   | |_ \_| _ .--.  .---.  _ .--.    | |_/ /    _ .--.`| |-'
//   |  _| _ [ `/'`\]/ /__\\[ `.-. |   |  __'.   [ `/'`\]| |
//  _| |__/ | | |    | \__., | | | |  _| |  \ \_  | |    | |,
// |________|[___]    '.__.'[___||__]|____||____|[___]   \__/
/**
 * Class Yabancı Dizi Bot PHP / Class
 * @author Eren Kurt (ErenKrt)
 * @mail kurteren07@gmail.com
 * @İnstagram Ep.Eren
 * @date 28.12.2019
 * @update 15.02.2020
 */
namespace eperen;

include 'vendor/autoload.php';

use Spatie\Regex\Regex;
use \Curl\Curl;
use Exception;

class YabanciDizi
{
    function seflink($str, $options = array()){
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true
        );
        $options = array_merge($defaults, $options);
        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
        $str = trim($str, $options['delimiter']);
        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
      }

    public function ConvertTitle($yazi){
        return mb_convert_case(mb_strtolower($yazi),MB_CASE_TITLE, "UTF-8");
    }

    public $baseurl="https://www.dizibox.pw/";
    public $UserAgent;
    public $Cookie=array();

    public function __construct()
    {
        $this->UserAgent=\Campo\UserAgent::random([
            'os_type' => 'Windows',
            'device_type' =>'Desktop'
        ]);
        
    }
    
    private function Curl($uri = "",$ref="",$fullurl=0,$options = array())
    {
       
        if ($options == array()) {
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_ENCODING => "",
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FOLLOWLOCATION => true
            );
            
        }

        $Curl = new Curl();

        foreach ($options as $key => $value) {
            $Curl->setOpt($key, $value);
        }
        if($this->Cookie!=array()){
            foreach ($this->Cookie as $key => $value) {
                
                $Curl->setCookie($key, $value);
            }
        }
        $Curl->setUserAgent($this->UserAgent);
        if($ref!=""){
            $Curl->setReferer($this->baseurl.$ref);
        }
        if($fullurl){
            $Curl->get($uri);
        }else{
            $Curl->get($this->baseurl.$uri);
        }
        if ($Curl->error) {
            $Curl->close();
            throw new Exception($Curl->errorCode . ': ' . $Curl->errorMessage);
        }else{ 
          
            if(strpos($Curl->responseHeaders["content-type"],"jpeg")){
                return base64_encode($Curl->response);
            }else if(strpos($Curl->responseHeaders["content-type"],"png")){
                return base64_encode($Curl->response);
            }else if(strpos($Curl->responseHeaders["content-type"],"json")){
                return $Curl->response;
            }else{
                return str_replace(array("\n", "\r", "\t"), NULL, trim($Curl->response));
            }
        }
    }
    public function WithCookie(){
        $this->Cookie=array("dbxu",round(microtime(true) * 1000));
    }
    public function Image($uri){
        return $this->Curl($uri,$this->baseurl,1);
    }
    public function DiziSayfasi($dizi)
    {
        $dizi.=" izle";
        $dizi="diziler/".$this->seflink($dizi);
        
        $veri= $this->Curl($dizi);
        /* Alanlar / Belirlemeler */
        
        $DiziAlani= Regex::match('/<section id="single-diziler">(.*?)<\/section>/', $veri)->result();
        $TagAlan=Regex::match('/<div class="terms text-muted-dark text-overflow">(.*?)<\/div>/', $DiziAlani)->result();
        $TaglerHTML= Regex::matchAll('/<a href=".*?" rel="tag">(.*?)<\/a>/', $TagAlan)->results();
        $SezonlarAlani= Regex::match('/<div id="seasons-list" class=".*?">(.*?)<\/div>/', $DiziAlani)->result();
        $SezonlarHTML= Regex::matchAll('/<a .*?>(.*?)<\/a>/', $SezonlarAlani)->results();
        $BolumlerAlani= Regex::match('/<section id="category-posts" class=".*">(.*?)<\/section>/', $DiziAlani)->result();
        $BolumlerAltAlani= Regex::matchAll('/<div class="post-title">(.*?)<\/div>/', $BolumlerAlani)->results();
        
        /* Bulunanlar */
        $Fragman= Regex::match("/<iframe src='(.*?)' .*><\/iframe>/", $DiziAlani)->group(1);
        $isim= Regex::match('/<h1 class="pull-left m-b-0"><a href=".*?" class="link-unstyled">(.*?)<\/a><\/h1>/', $DiziAlani)->group(1);
        $Aciklama= Regex::match('/<div class="tv-story"><p>(.*?)<\/p><\/div>/', $DiziAlani)->group(1);
        
        
        $taglar=array();
        for ($i=0; $i <count($TaglerHTML) ; $i++) { 
            $taglar[$i]=$TaglerHTML[$i]->group(1);
        }

        $sezonlar=array();
        for ($i=0; $i <count($SezonlarHTML) ; $i++) { 
            $sezonlar[$i]=$SezonlarHTML[$i]->group(1);
        }
        
        $Bolumler= array();
        for ($i=0; $i <count($BolumlerAltAlani) ; $i++) { 
            $Bolum= Regex::match('/<a href=".*?" class="season-episode .*?">(.*?)<\/a>/', $BolumlerAltAlani[$i]->group(1))->group(1);
            $Tarih= Regex::match('/<small class="date text-muted-darker"><i class="icon icon-clock"><\/i> (.*?)<\/small>/', $BolumlerAltAlani[$i]->group(1))->group(1);
            
            $Bolumler[$i]=array("isim"=>$Bolum,"Tarih"=>$Tarih);
            
        }
        
        
        return(array("Fragman"=>$Fragman,"isim"=>$isim,"Aciklama"=>$Aciklama,"Kategoriler"=>$taglar,"Sezonlar"=>$sezonlar,"Sezonbolumleri"=>$Bolumler));

    }

    public function DiziBolumleri($dizi,int $sezon=1)
    {
        $dizi="dizi/".$this->seflink($dizi)."/".$this->seflink($sezon." sezon ".$dizi);
       
        $veri= $this->Curl($dizi);
        
        $SezonlarAlani= Regex::match('/<div id="seasons-list" class=".*?">(.*?)<\/div>/', $veri)->group(1);
        $SezonlarHTML= Regex::matchAll('/<a .*?>(.*?)<\/a>/', $SezonlarAlani)->results();
        $BolumlerAlani= Regex::match('/<div id="category-posts" class=".*">(.*?)<\/div>/', $veri)->result();
        $BolumlerAltAlani= Regex::matchAll('/<div class="post-title">(.*?)<\/div>/', $BolumlerAlani)->results();
        
        $sezonlar=array();

        for ($i=0; $i <count($SezonlarHTML) ; $i++) { 
            $sezonlar[$i]=$SezonlarHTML[$i]->group(1);
        }

        $Bolumler= array();
        for ($i=0; $i <count($BolumlerAltAlani) ; $i++) { 
            $Bolum= Regex::match('/<a href=".*?" class="season-episode .*?">(.*?)<\/a>/', $BolumlerAltAlani[$i]->group(1))->group(1);
            $Tarih= Regex::match('/<small class="date text-muted-darker"><i class="icon icon-clock"><\/i> (.*?)<\/small>/', $BolumlerAltAlani[$i]->group(1))->group(1);
            
            $Bolumler[$i]=array("isim"=>$Bolum,"Tarih"=>$Tarih);
            
        }

        return(array("Bolumler"=>$Bolumler,"BSezon"=>$sezon,"Sezonlar"=>$sezonlar));
    }

    private function KillTheProtocol($iframe,$ref="")
    {
        $url= parse_url($iframe);
        if(strripos($url["host"],"dizibox")){
            $veri= $this->Curl($iframe,$ref,1);
            
            if(Regex::match('/jwplayer.js/', $veri)->hasMatch()){ // Jw Player
                
                if(Regex::match('/file:"(.*?)"/', $veri)->hasMatch()){
                    
                    $mp4= Regex::match('/file:"(.*?)"/', $veri)->group(1);
                    
                }else if(Regex::match('/"file": "(.*?)"/', $veri)->hasMatch()){
                    $mp4= Regex::match('/"file": "(.*?)"/', $veri)->group(1);

                }else if(Regex::match('/<iframe src="(.*?)" .*?><\/iframe>/', $veri)->hasMatch()){
                    $mp4= Regex::match('/<iframe src="(.*?)" .*?><\/iframe>/', $veri)->group(1);
                }
                 return $mp4;
            }else{
                if(Regex::match('/atob/', $veri)->hasMatch()){
                    $sifveri= base64_decode(htmlspecialchars(urldecode(Regex::match('/unescape\("(.*?)"\)/', $veri)->group(1))));
                    $mp4= Regex::match('/<iframe src="(.*?)" .*?><\/iframe>/', $sifveri)->group(1);
                    return $mp4;
                }else{
                    $mp4= Regex::match('/<iframe src="(.*?)" .*?><\/iframe>/', $veri)->group(1);
                    return $mp4;
                }
            } 

        }else{
            return $iframe;
        }
        
    }

    public function Bolum($dizi,$bolum,$player=1)
    {
        $bolum= str_replace(array(" Sezon Finali"," Sezon Final"," Final"),"",$bolum);
        
       
        $uri= $this->seflink($dizi." ".$bolum." izle")."/".$player;
       
        $veri= $this->Curl($uri);
        
        $playerlarHTML= Regex::matchAll('/<option .*?>(.*?)<\/option>/', $veri)->results();
        
        $playerlar= array();
        $x=1;
        for ($i=0; $i <count($playerlarHTML); $i++) { 
            $playerlar[$i]= array("id"=>$x,"isim"=>$playerlarHTML[$i]->group(1));
            $x++;
        }
        $iframe= Regex::match('/<iframe src="(.*?)" .*?><\/iframe>/', $veri)->group(1);
        $iframe= $this->KillTheProtocol($iframe,$uri);
        return(array("dizi"=>$dizi,"bolum"=>$bolum,"cplayer"=>$player,"playerlar"=>$playerlar,"icerik"=>$iframe));
        
    }
    private function DiziRow($row)
    {
        $dizi= Regex::match("/<b class='series-name text-overflow'>(.*?)<\/b>/", $row)->group(1);
        $sezon= Regex::match('/<span class="season text-muted">(.*?)<\/span>/', $row)->group(1);
        $bolum= Regex::match('/<b class="episode primary-color">(.*?)<\/b>/', $row)->group(1);
        $gun= Regex::match('/<div class="publish-date .*?">(.*?)<\/div>/', $row)->group(1);
        $title= Regex::match('/<a href=".*?" class="episode-card-title .*?" title="(.*?)">/', $row)->group(1);
        $dil= Regex::match("/<img src='(.*?)' alt='Dil Seçeneği' class='language-flag .*?'>/", $row)->group(1);
        $resimler= Regex::matchAll("/<img src='(.*?)' alt='.*?'>/", $row)->results(1);

        $dil=$resimler[0]->group(1);
        $resim= $resimler[1]->group(1);
        
        return(array("Title"=>$title,"isim"=>$dizi,"Sezon"=>$sezon,"Bolum"=>$bolum,"YayinGun"=>$gun,"ceviri"=>$dil,"img"=>$this->Image($resim)));
        
    }
    public function PopulerSon($sayfa=1)
    {
       $uri= "tum-bolumler/page/".$sayfa."/?tip=populer";
       $veri= $this->Curl($uri);
       
       $DizilerHTML= Regex::matchAll('/<article class="article-episode-card pull-left grid-five .*?">(.*?)<\/article>/', $veri)->results();

       $diziler= array();
       for ($i=0; $i <count($DizilerHTML) ; $i++) { 
           $diziler[$i]=$this->DiziRow($DizilerHTML[$i]->group(1));
       }
       
       $pagination= Regex::match('/<div class="woca-pagination">(.*?)<\/div>/',$veri)->group(1);
       
       $sayfalar= Regex::match('/<span class="pages">(.*?)<\/span>/',$pagination)->group(1);
       
       $bol= explode('/',$sayfalar);
       $current= trim($bol[0]);
       $max= trim($bol[1]);
       
       return(array("Diziler"=>$diziler,"pagination"=>array("bulunan"=>$current,"maks"=>$max)));
    }

    public function YeniEklenen($sayfa=1)
    {
       $uri= "tum-bolumler/page/".$sayfa."/";
       $veri= $this->Curl($uri);
       
       $DizilerHTML= Regex::matchAll('/<article class="article-episode-card pull-left grid-five .*?">(.*?)<\/article>/', $veri)->results();

       $diziler= array();
       for ($i=0; $i <count($DizilerHTML) ; $i++) { 
           $diziler[$i]=$this->DiziRow($DizilerHTML[$i]->group(1));
       }

       $pagination= Regex::match('/<div class="woca-pagination">(.*?)<\/div>/',$veri)->group(1);
       $sayfalar= Regex::match('/<span class="pages">(.*?)<\/span>/',$veri)->group(1);
       $bol= explode('/',$sayfalar);
       $current= trim($bol[0]);
       $max= trim($bol[1]);
       
       return(array("Diziler"=>$diziler,"pagination"=>array("bulunan"=>$current,"maks"=>$max)));
    }
    public function Ara($key,$sayfa=1)
    {
       $uri= "page/".$sayfa."/?s=".\urlencode($key);
       $veri= $this->Curl($uri);
        
       $pagination= Regex::match('/<div class="woca-pagination">(.*?)<\/div>/',$veri)->group(1);
       $sayfalar= Regex::match('/<span class="pages">(.*?)<\/span>/',$veri)->group(1);
       $bol= explode('/',$sayfalar);
       $current= trim($bol[0]);
       $max= trim($bol[1]);

       $AramaAlani= Regex::match('/<section id="search" class="content-wrapper">(.*?)<\/section>/',$veri)->group(1,"Arama sonucu yok");
       $DizilerHTML= Regex::matchAll('/<article class="detailed-article">(.*?)<\/article>/', $veri)->results();

       $Diziler=array();
       for ($i=0; $i <count($DizilerHTML); $i++) { 
        $Adizi= $DizilerHTML[$i]->group(1);
        $Resim= Regex::match('/<img src="(.*?)" alt=".*?" class="main-cover" \/>/',$Adizi)->groupOr(1,"Resim yok");
        $isim= Regex::match('/<h3 class="m-b-0"><a href=".*?">(.*?)<\/a><\/h3>/',$Adizi)->group(1);
        
        $TaglerHTML= Regex::matchAll('/<span class="custom-field"><i class="icon icon-.*?"><\/i>(.*?)<\/span>/',$Adizi)->results();
        $taglar=array();
        for ($j=0; $j <count($TaglerHTML) ; $j++) { 
            $Atag= $TaglerHTML[$j]->group(1);
            $TBol=explode('|',$Atag);
            $taglar[$j]=trim(str_replace('&nbsp;','',$TBol[0]));
            
        }
        $Aciklama= Regex::match('/<div class="post-summary">(.*?)<\/div>/',$Adizi)->groupOr(1,"Açıklama yok");

        $Diziler[$i]=array("isim"=>$isim,"Resim"=>$Resim,"Tagler"=>$taglar,"Aciklama"=>$Aciklama);
        
       }
       return array("Diziler"=>$Diziler,"pagination"=>array("bulunan"=>$current,"maks"=>$max));
    }
    public function AutoComplete($key)
    {
        $uri='wp-admin/admin-ajax.php?s='.urlencode($key).'&action=dwls_search';
        $veri= $this->Curl($uri);
        $Diziler=array();
        for ($i=0; $i < count($veri->results) ; $i++) { 
            $dizi= $veri->results[$i];
            $Diziler[$i]=array("isim"=>$dizi->post_title,"Resim"=>$dizi->attachment_thumbnail,"Aciklama"=>htmlspecialchars($dizi->post_excerpt));
        }
        return $Diziler;
    }
}
