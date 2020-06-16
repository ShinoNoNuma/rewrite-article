<?php
App::uses('AppController', 'Controller');
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
public $uses = array();

//explod function with multiple options in $delimiter = array();
private function multiexplode($delimiters,$string) {
	$ready = str_replace($delimiters, $delimiters[0], $string);
	$launch = explode($delimiters[0], $ready);
	return  $launch;
}

private function array_values_recursive($array){
	$tmp = array();
	foreach ($array as $key => $value) {
		if (is_numeric($key)) {
			$tmp[] = is_array($value) ? $this->array_values_recursive($value) : $value;
		} else {
			$tmp[$key] = is_array($value) ? $this->array_values_recursive($value) : $value;
		}
	}
	return $tmp;
}

private function combination($array, array &$results, $str = '') {
	$current = array_shift($array);
	if(count($array) > 0) {
		foreach($current as $element) {
			$this->combination($array, $results,  $str.$element);
		}
	}
	else{
		foreach($current as $element) {
			$results[] = $str.$element;
		}
	} 
}

//Find Synonym by word on thesaurus.com
private function findSynonymOnWeb($word){
	$url = 'https://www.thesaurus.com/browse/'.$word;
	$ch = curl_init();
	$timeout = 30;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$html = curl_exec($ch);
	curl_close($ch);
	if (!$html) {
		return NULL;
	}

	$dom = new DOMDocument();
	@$dom->loadHTML($html);
	$xpath = new DOMXPath($dom);

	//QUERY FOR THE OLD VERSION (2018) (LET's KEEP IT IN CASE)
	$synonyms = $xpath->query("//div[@class='synonyms'][1]/div[@class='filters']/div[@class='relevancy-block']/div[@class='relevancy-list']/ul/li/a/span[@class='text']");
	if ($synonyms['length'] == 0) {
		//QUERY FOR THE NEW VERSION 2020
		$synonyms = $xpath->query("//div[@id='root'][1]/div/div/div/main/section/section/div/ul/li/span");
	}
	$synonymList = array();
	foreach ($synonyms as $key => $synonym) {
		$synonymList[$key] = $synonym->nodeValue;
	}
	return json_encode($synonymList);
}


private function getSentenceFromText($text){
	$separator = array('.',',');
	return array_filter(array_map('trim',$this->multiexplode($separator, str_replace(array('(',')'), '', mb_strtolower($text)))),'strlen');
}

private function getWordBySentences($sentences){
	for ($a=0; $a < count($sentences); $a++) { 
		if(!empty($sentences[$a])) {
			$words[$a] = explode(' ',$sentences[$a]);
		}
	}
	return $words;
}

private function verifyValidWord($word_to_verify){
			$dic_folder = IMAGES.'dict_files';
			if (!is_dir($dic_folder)){
				$dic_folder = "dict_files";
			}
			$d = opendir($dic_folder) or die($php_errormsg);
			$validity_count = 0;
			while (false !== ($f = readdir($d))){
				if (preg_match('@\.(dic|txt)$@i', $f)){
					$dic_file = file_get_contents($dic_folder.DS.$f);
					if (strpos($dic_file, $word_to_verify) !== false){
						$validity_count += 1;
					}
					else if (strpos($dic_file, ucfirst($word_to_verify)) !== false){
						$validity_count += 1;
					}
					else if (strpos($dic_file, strtolower($word_to_verify)) !== false){
						$validity_count += 1;
					}
					else if (strpos($dic_file, strtoupper($word_to_verify)) !== false){
						$validity_count += 1;
					}
				}
			}
			closedir($d);
			if ($validity_count > 0){
				//word valid
				return 1;
			}
			else{
				//word invalid
				return 0;
			}
		}
		//open the file 'pos-list.txt' which contains
		//a numerable amount of commonly used english
		//words and their corresponding part of speech
private function posList(){
	$handle = fopen(IMAGES.'dict_files'.DS.'pos-list.txt', 'r');
			if ($handle){
				$posList = array();
		   	while (($line = fgets($handle)) !== false){
		        	$posList[] = $line;
		    	}
				fclose($handle);
				return $posList;
			}
}

private function findWordAttribute($word,$posList){
			$poses = array('N' => "noun", 'p' => 'Plural', 'h' => 'Noun Phrase', 'V' => 'verb (us. participle)', 't' => 'verb (us. Transitive)', 'i' => 'verb (us. intransitive)', 'A' => 'adjective', 'v' => 'adverb', 'C' => 'conjunction', 'P' => 'preposition', '!' => 'interjection', 'r' => 'pronoun', 'D' => 'definite article', 'I' => 'indefinite article', 'o' => 'nominative');
				$pos = preg_grep("/^($word)(\\\\)/is", $posList);
					$character_str = array();
				foreach ($pos as $key => $value)
				{
					$explode = explode("\\", $pos[$key]);
					$real_pos = trim($explode[1]);
					$real_totl = strlen($real_pos);
					$counter;
					for ($counter = 0; $counter < $real_totl; $counter++)
					{
						$character = $poses[$real_pos[$counter]];
						array_push($character_str,$character);
					}
			}
			return $character_str;
		}
//level (nb char)= 4 high, 5 normal, 6 soft
private function getSynonymByWord($words,$sentences,$level){
	$data['Synonym'] = array();
	$wordss    = array();
	$synonymss = array();
	$phrases = array();
	//load all attribut from file (verb, noun etc..)
	$posList = $this->posList();
	$this->loadModel('Synonym');
	for($a=0; $a < count($sentences); $a++){
		for($b=0; $b < count($words[$a]); $b++){
		//Don't need to find sysnonyms for the words with less than 4 chars (by default) can be changed by the user
			if(strlen($words[$a][$b]) < intval($level)) {
				continue;
			}
			if ($this->verifyValidWord($words[$a][$b]) == 0) {
				continue;
			}
			$checkWordExist = $this->Synonym->wordExist($words[$a][$b]);
			if($checkWordExist == 0){
				$listOfSynonym[$a][$b] = $this->findSynonymOnWeb($words[$a][$b]);
				if(!empty($listOfSynonym[$a][$b]) && $listOfSynonym[$a][$b] != '[]' && $listOfSynonym[$a][$b] != 'NULL' && $listOfSynonym[$a][$b] != NULL){
					$attributes = $this->findWordAttribute($words[$a][$b],$posList);
					array_push($data['Synonym'],array('word' => $words[$a][$b],'value' => $listOfSynonym[$a][$b],'attribute' => json_encode($attributes)));
					$wordss[$a][$b] = $words[$a][$b];
					$synonymss[$a][$b] = json_decode($listOfSynonym[$a][$b]);

					$phrases[$a] = array(
						'sentence' => $sentences[$a],
						'words' => $wordss[$a],
						'synonyms' => $synonymss[$a],
						);
				}
			}else{
			//If the synonym of the word is already in database
				$synonym = $this->Synonym->findSynonymInDatabase($words[$a][$b]);
				$wordss[$a][$b] = $synonym['Synonym']['word'];
				$synonymss[$a][$b] = json_decode($synonym['Synonym']['value']);

				$phrases[$a] = array(
					'sentence' => $sentences[$a],
					'words'    => $wordss[$a],
					'synonyms' => $synonymss[$a],
					);
			}
		}
	}
	//Save new synonym in database
	if(!empty($data['Synonym'])){
		$this->Synonym->saveAll($data['Synonym']);
	}
	return $this->array_values_recursive($phrases);
}

//Will upgrade this function in the future for get better result (like try to analyze the context etc..) 
private function createSentenceWithSynonyms($synonyms){
	$newSentences = array();
	for($i=0; $i < count($synonyms); $i++) { 
		for ($j=0; $j < count($synonyms[$i]['words']); $j++) { 
			for ($k=0; $k < count($synonyms[$i]['synonyms'][$j]); $k++) { 
				if($j == 0){
					$newSentences[$i][$j][$k] = str_replace($synonyms[$i]['words'][$j], $synonyms[$i]['synonyms'][$j][$k], $synonyms[$i]['sentence']);
				}else{
					for ($l=0; $l < count($newSentences[$i][$j-1]); $l++) { 
						if(isset($synonyms[$i]['synonyms'][$j][$l])){
							$newSentences[$i][$j][$l] = str_replace($synonyms[$i]['words'][$j], $synonyms[$i]['synonyms'][$j][$l], $newSentences[$i][$j-1][$l]);
						}
					}
				}
			}
		}
	}
	return $newSentences;
}

private function rewriteArticle($newSentences){
	$article = NULL;
	for ($i=0; $i < count($newSentences); $i++) { 
		$article .= ucfirst(end($newSentences[$i])[array_rand(end($newSentences[$i]))]).". ";
	}
	return $article;
}

private function findDiff($originalArticle,$rewriteArticle){
		$a1 = explode(" " , str_replace(array('.',',','. ',', '), '', mb_strtolower($originalArticle)));
		$a2 = explode(" ", str_replace(array('.',',','. ',', '), '', mb_strtolower($rewriteArticle)));
		$diffWords = $this->array_values_recursive(array_diff($a1, $a2));
		$htmlSynonymsByWord = array();
		if(!empty($diffWords)){
			$this->loadModel('Synonym');
			for ($i=0; $i < count($diffWords); $i++) { 
				$synonyms = $this->Synonym->findSynonymInDatabase($diffWords[$i]);
				if(!empty($synonyms['Synonym']['value'])){
					$allSynonymByWord = json_decode($synonyms['Synonym']['value']);
					shuffle($allSynonymByWord);
					$html = NULL;
					for ($j=0; $j < count($allSynonymByWord); $j++) { 
						if($j==0){
							$html .= '<select><option value="'.($j+1).'" selected>'.$allSynonymByWord[$j].'</option>';
						}else{
							$html .= '<option value="'.($j+1).'">'.$allSynonymByWord[$j].'</option>';	
						}

						if($j == max(array_keys($allSynonymByWord))){
							$html .= '</select>';
						}
						$htmlSynonymsByWord[$i] = $html;
					}
				}
			}
			if(count($htmlSynonymsByWord) == count($diffWords)){
				//don't forget bug with this str_replace when anhother synonym is in another word in DB
			return str_replace($diffWords, $htmlSynonymsByWord, mb_strtolower($originalArticle));
			}
		}else{
			return $rewriteArticle;
		}
}
public function home() {
	ini_set('memory_limit', '-1');
	set_time_limit(0);
	if ($this->request->is('post')) {
		if(empty($this->request->data['text']) || empty($this->request->data['level'])){
			$ajax = array('response' => 'error', 'message' => 'Text empty, please try again.');
				echo json_encode($ajax);
				exit;
			}
			//array of sentences
			$sentences = $this->getSentenceFromText($this->request->data['text']);
			//array of words for each sentence
			$wordsBySentence = $this->getWordBySentences($sentences);
			$synonyms = $this->getSynonymByWord($wordsBySentence,$sentences,$this->request->data['level']);
			$newSentences = $this->createSentenceWithSynonyms($synonyms);

			if($this->request->data['alternate'] == 0){
				//No synonym propostion on the final result
				$rewriteArticle = $this->rewriteArticle($newSentences);
			}elseif($this->request->data['alternate'] == 1){
				$rewriteArticle = $this->rewriteArticle($newSentences);
				//[OPTIONAL] $rewrite work well BUT now we allow the customer to change the synonym by himself
				$rewriteArticle = $this->findDiff($this->request->data['text'],$rewriteArticle); 
			}else{
				$ajax = array('response' => 'error', 'message' => 'An error has occurred, please try again.');
				echo json_encode($ajax);
				exit;
			}


			if (!empty($rewriteArticle)) {
				$ajax = array('response' => 'success', 'rewriteArticle' => $rewriteArticle, 'synonyms' => $synonyms);
				echo json_encode($ajax);
				exit;
			} else {
				$ajax = array('response' => 'error', 'message' => 'An error has occurred, please try again.');
					echo json_encode($ajax);
					exit;
				}
		// var_dump($synonyms);
		// die;

			}
		}
}
