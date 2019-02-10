<?php
class Hashmention {
    static public function parse($text) {
        $text = preg_replace('/(^|\s)@(\w+)/', '$1<a href="/user/$2">@$2</a>', $text);
        $text = preg_replace('/#(\w+)/', '<a href="/search?q=%23$1">#$1</a>', $text);

        return $text;
    }

	static public function getMention($text) {
        preg_match_all('/(^|\s)@(\w+)/', $text, $matches);

        $usernames = array();

        foreach($matches as $value) {
            foreach($value as $value) {
                $usernames[] = substr(trim($value), 1);
            }
        }

        return $usernames;
    }

    static public function notifyUser($users, $type, $postId) {
        $db = DB::getInstance();
        $user = new User();
        $post = new Post();

        if(count($users) > 0) {
            foreach($users as $u) {
                // Now see if you can insert the new hashtag, but if not just find that hashtag and add a number to it
                $check_user = $user->find($u);

                if($check_user) {
                    $notification = new Notification;
                    $notification->create($user->get($u)->id, $type, $postId);
                }
            }
        }
    }

    static public function getHashtags($text) {
        preg_match_all('/#\w+/', $text, $matches);

        $hashtags = array();

        foreach($matches as $value) {
            foreach($value as $value) {
                $hashtags[] = $value;
            }
        }

        return $hashtags;
    }

    static public function updateHashtag($tags) {
        $db = DB::getInstance();

        if(count($tags) > 0) {
            foreach($tags as $tag) {
                // Now see if you can insert the new hashtag, but if not just find that hashtag and add a number to it
                $check_hash = $db->get('hashtags', ['name', '=', $tag]);

                if($check_hash->count()) {
                    // means that hashtag already exist so just update it
                    $get_update = $check_hash->first()->posted;
                    $update = $get_update + 1;
                    $db->query("UPDATE hashtags SET posted = '{$update}' WHERE name = '{$tag}'");
                } else {
                    // Means it dosent exist, then insert it into there
                    $insert_hash = $db->insert('hashtags', ['name' => $tag, 'posted' => 1]);
                }
            }
        }
    }

    static public function displayHashtags() {
        $db = DB::getInstance();

        return $db->query("SELECT * FROM hashtags ORDER BY posted DESC LIMIT 5")->results();
    }

	
	// // This function right here is going to change any word begining with a '#' or '@' into a link. Then it will return the text.
	// static public function parseText($text) {        
 //        $arr = explode(" ", $text);
 //        $arrc = count($arr);
 //        $i = 0;
 //        $tags = array();
        
 //        while($i < $arrc) {
 //            if(substr($arr[$i], 0, 1) === "#") {
 //                $url = $arr[$i];
 //                $vowels = array("#");
 //                $onlyconsonants = str_replace($vowels, "", $url);
 //                if(strlen($url) >= 2) {
 //                    $arr[$i] = '<a href="/search?q=' . $onlyconsonants . '&type=hashtag">' . $arr[$i] . '</a>';
 //                }
 //            } else if(substr($arr[$i], 0, 1) === "@") {
 //                $url = $arr[$i];
 //                $vowels = array("@");
 //                $onlyconsonants = rtrim(str_replace($vowels, "", $url), ',');
 //                $user = new User();
 //                if($user->find(strtolower($onlyconsonants))) {
 //                    $arr[$i] = '<a href="/user/' . $onlyconsonants . '">' . $arr[$i] . '</a>';
 //                } else {
 //                    $arr[$i] = $arr[$i];
 //                }
 //            }
 //            $i++;
 //        }

 //        $text = implode(" ", $arr);
 //        return $text;
	// }
	
	// // This right here will return the array of hashtags back to you so you can insert them into the database
	// static public function getHashTags($text) {
	// 	$arr = explode(" ", $text);
	// 	$arrc = count($arr);
	// 	$i = 0;
	// 	$tags = array();
		
	// 	while($i < $arrc) {
	// 		if(substr($arr[$i], 0, 1) === "#") {
	// 			$tags[] = $arr[$i];
	// 		}
	// 		$i++;
	// 	}
	// 	return $tags;
	// }

	// This function will insert the hashtags into the database so you can allow users to search them or find the hashtag trends and stuff

 //    static public function getMention($text) {
 //        $arr = explode(" ", $text);
 //        $arrc = count($arr);
 //        $i = 0;
 //        $users = array();
        
 //        while($i < $arrc) {
 //            if(substr($arr[$i], 0, 1) === "@") {
 //                $users[] = $arr[$i];
 //            }
 //            $i++;
 //        }
 //        return $users;
 //    }


}
?>