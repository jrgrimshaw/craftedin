<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';

$keyword = escape(Input::get('keyword'));
$db = DB::getInstance();

$queryHashtags = $db->query("SELECT * FROM hashtags WHERE (name LIKE '%{$keyword}%') ORDER BY name ASC LIMIT 0, 5");

if($queryHashtags->count()) {
    foreach ($queryHashtags->results() as $item) {
        $searchHashtag = str_ireplace($keyword, '<span style="font-weight:800">' . $keyword . '</span>', escape($item->name));
        // add new option
        echo '
            <a href="/search?q=' . urlencode(escape($item->name)) . '">
                <li>
                    <span class="name">' . $searchHashtag . '</span>
                </li>
            </a>';
    }
    echo '<div class="dropdown-spacer"></div>';
}

$query = $db->query("SELECT * FROM users WHERE (username LIKE '%{$keyword}%') OR (name LIKE '%{$keyword}%') ORDER BY name ASC LIMIT 0, 5");

if(!$query->count() && !$queryHashtags->count()) {
    echo '
        <a>
            <li>
                <img><span class="name">No users match "' . $keyword . '"</span>
            </li>
        </a>';
} else {
    foreach ($query->results() as $item) {
        // put in bold the written text
        $searchName = str_ireplace($keyword, '<span style="font-weight:800">' . $keyword . '</span>', escape($item->name));
        $searchUsername = str_ireplace($keyword, '<span style="font-weight:600">' . $keyword . '</span>', escape($item->username));
        if($item->page == 1): $type = 'page'; else: $type = 'user'; endif;
        // add new option
        echo '
            <a href="/' . $type . '/' . escape($item->username) . '">
                <li>
                    <img src="' . USER_AVATAR_DIR . $item->avatar . '"><span class="name">' . $searchName . '</span><span class="username">@' . $searchUsername . '</span>
                </li>
            </a>';
    }
}

echo '<div class="dropdown-spacer"></div>';

echo '
    <a href="/search?q=' . urlencode($keyword) . '" class="view-all">
        <li>
            <span class="ion-android-search"></span> View All Results
        </li>
    </a>';