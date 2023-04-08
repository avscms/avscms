<?php
defined('_VALID') or die('Restricted Access!');

require $config['BASE_DIR']. '/classes/filter.class.php';
require $config['BASE_DIR']. '/include/compat/json.php';
require $config['BASE_DIR']. '/include/adodb/adodb.inc.php';
require $config['BASE_DIR']. '/include/dbconn.php';

$filter         = new VFilter();
$search_type    = $filter->get('search_type');
if ( $search_type != 'videos' && $search_type != 'photos' && $search_type != 'users' ) {
    $search_type    = 'videos';
}
$search_title   = $lang['ajax.ADVANCED'].' ' .$lang['ajax.search_'.$search_type]. ' '.$lang['ajax.SEARCH'];

$sql            = 'SELECT CHID, name FROM channel ORDER BY name ASC';
$rs             = $conn->execute($sql);
$categories     = $rs->getrows();
$sql            = 'SELECT category_id, category_name FROM game_categories ORDER BY category_name ASC';
$rs             = $conn->execute($sql);
$game_categs    = $rs->getrows();

$data           = array('status' => 0, 'code' => '');
$response       = NULL;

ob_start();
ob_implicit_flush(0);
?>
<div class="btitle">
    <div class="btitlel"><h2 id="advanced_search_title"><?php echo $search_title; ?></h2></div>
    <div class="btitler"><a href="#close_advanced_search" id="close_advanced_search"><?php echo $lang['global.close']; ?></a></div>
    <div class="clear"></div>
</div>
<br />
<div id="search_tabs">
<ul>
    <li><a href="#search_videos" id="search_tab_videos"<?php if($search_type == 'videos'){echo ' class="active"';} ?>><?php echo $lang['ajax.search'].' '.$lang['global.videos']; ?></a></li>
    <?php if ( $config['photo_module'] == '1' ) { ?><li><a href="#search_photos" id="search_tab_photos"<?php if($search_type == 'photos'){echo ' class="active"';} ?>><?php echo $lang['ajax.search'].' '.$lang['global.photos']; ?></a></li><?php } ?>
    <li><a href="#search_users" id="search_tab_users"<?php if($search_type == 'users'){echo ' class="active"';} ?>><?php echo $lang['ajax.search'].' '.$lang['global.users']; ?></a></li>
    <?php if ( $config['game_module'] == '1' ) { ?><li><a href="#search_games" id="search_tab_games"<?php if($search_type == 'games'){echo ' class="active"';} ?>><?php echo $lang['ajax.search'].' '.$lang['global.games']; ?></a></li><?php } ?>
</ul>
<div class="clear_left"></div>
</div>
<div id="search_tabs_delimiter"></div>
<div id="search_videos"<?php if ($search_type != 'videos') {echo ' style="display: none;"';} ?>>
    <form name="search_videos_advanced" id="search_advanced_form" method="get" action="<?php echo $config['BASE_URL']; ?>/search">
        <input name="search_type" type="hidden" value="videos" />
        <div class="search_left">
            <div class="separator">
                <label for="search_query_advanced"><?php echo $lang['ajax.search_for']; ?>:</label>
                <input name="search_query" type="text" id="search_query_advanced" />
            </div>
            <div class="separator">
                <label for="search_category"><?php echo $lang['global.category']; ?>:</label>
                <select name="c" id="search_category">                            
                    <option value=""><?php echo $lang['global.all']; ?></option>
                    <?php foreach ( $categories as $category ): ?>
                    <option value="<?php echo $category['CHID']; ?>"><?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="separator">
                <label for="type"><?php echo $lang['global.type']; ?>:</label>
                <select name="type" id="type">
                    <option value=""><?php echo $lang['global.all']; ?></option>
                    <option value="public"><?php echo $lang['global.public']; ?></option>
                    <option value="private"><?php echo $lang['global.private']; ?></option>
                </select>                            
            </div>
        </div>
        <div class="search_right">
            <div class="separator">
                <label for="search_rating"><?php echo $lang['ajax.search_rating_higher']; ?>:</label>
                <select name="r" id="search_rating">
                    <option value=""><?php echo $lang['ajax.search_dont_care']; ?></option>
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4</option>
                    <option value="4.5">4.5</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="separator">
                <label for="search_min_length"><?php echo $lang['ajax.search_min_length']; ?>:</label>
                <select name="min_length" id="search_min_length">
                    <option value=""><?php echo $lang['ajax.search_dont_care']; ?></option>
                    <option value="1">1 hour</option>
                    <option value="50">50 mins</option>
                    <option value="40">40 mins</option>
                    <option value="30">30 mins</option>
                    <option value="20">20 mins</option>
                    <option value="10">10 mins</option>
                    <option value="5">5 mins</option>
                </select>
            </div>
            <div class="separator">
                <label for="search_max_length"><?php echo $lang['ajax.search_max_length']; ?>:</label>
                <select name="max_length" id="search_max_length">
                    <option value=""><?php echo $lang['ajax.search_dont_care']; ?></option>
                    <option value="1">1 hour</option>
                    <option value="50">50 mins</option>
                    <option value="40">40 mins</option>
                    <option value="30">30 mins</option>
                    <option value="20">20 mins</option>
                    <option value="10">10 mins</option>
                    <option value="5">5 mins</option>
                </select>
            </div>
        </div>
        <div class="clear"></div>
        <div class="center">
            <input type="submit" value="<?php echo $lang['ajax.search_advanced']; ?>" class="button" /><br /><br />
        </div>
    </form>
</div>
<div id="search_photos"<?php if ($search_type != 'photos') {echo ' style="display: none;"';} ?>>
    <form name="search_photos_advanced" id="search_photos_advanced_form" method="get" action="<?php echo $config['BASE_URL']; ?>/search">
        <input name="search_type" type="hidden" value="photos" />
        <div class="search_left">
            <div class="separator">
                <label for="search_query_advanced"><?php echo $lang['ajax.search_for']; ?>:</label>
                <input name="search_query" type="text" id="search_query_advanced" />
            </div>
            <div class="separator">
                <label for="search_category"><?php echo $lang['global.category']; ?>:</label>
                <select name="c" id="search_category">                            
                    <option value=""><?php echo $lang['global.all']; ?></option>
                    <?php foreach ( $categories as $category ): ?>
                    <option value="<?php echo $category['CHID']; ?>"><?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="separator">
                <label for="type"><?php echo $lang['global.type']; ?>:</label>
                <select name="type" id="type">
                    <option value=""><?php echo $lang['global.all']; ?></option>
                    <option value="public"><?php echo $lang['global.public']; ?></option>
                    <option value="private"><?php echo $lang['global.private']; ?></option>
                </select>                            
            </div>
        </div>
        <div class="search_right">
            <div class="separator">
                <label for="search_rating"><?php echo $lang['ajax.search_rating_higher']; ?>:</label>
                <select name="r" id="search_rating">
                    <option value=""><?php echo $lang['ajax.search_dont_care']; ?></option>
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4</option>
                    <option value="4.5">4.5</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>
        <div class="clear"></div>
        <div class="center">
            <input type="submit" value="<?php echo $lang['ajax.search_advanced']; ?>" class="button" /><br /><br />
        </div>
    </form>
</div>
<div id="search_users"<?php if ($search_type != 'users') {echo ' style="display: none;"';} ?>>
    <form name="search_users_advanced" id="search_users_advanced_form" method="get" action="<?php echo $config['BASE_URL']; ?>/search">
        <input name="search_type" type="hidden" value="users" />
        <div class="search_left">
            <div class="separator">
                <label for="search_query_advanced"><?php echo $lang['ajax.search_for']; ?>:</label>
                <input name="search_query" type="text" id="search_query_advanced" />
            </div>
            <div class="separator">
                <label for="search_gender"><?php echo $lang['global.gender']; ?>:</label>
                <select name="g" id="search_gender">
                    <option value=""><?php echo $lang['global.any']; ?></option>
                    <option value="Male"><?php echo $lang['global.male']; ?></option>
                    <option value="Female"><?php echo $lang['global.female']; ?></option>
                </select>
            </div>
            <div class="separator">
                <label for="search_interested"><?php echo $lang['global.interested']; ?>:</label>
                <select name="i" id="search_interested">
                    <option value=""><?php echo $lang['global.any']; ?></option>
                    <option value="Guys"><?php echo $lang['global.guys']; ?></option>
                    <option value="Girls"><?php echo $lang['global.girls']; ?></option>
                    <option value="Guys+Girls"><?php echo $lang['global.guys_girls']; ?></option>
                </select>
            </div>
        </div>
        <div class="search_right">
            <div class="separator">
                <label for="search_rating"><?php echo $lang['ajax.search_rating_higher']; ?>:</label>
                <select name="r" id="search_rating">
                    <option value=""><?php echo $lang['ajax.search_dont_care']; ?></option>
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4</option>
                    <option value="4.5">4.5</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="separator">
                <label for="search_online"><?php echo $lang['global.online']; ?>: </label>
                <select name="u" id="search_online">
                    <option value=""><?php echo $lang['ajax.search_dont_care']; ?></option>
                    <option value="yes"><?php echo $lang['global.yes']; ?></option>
                    <option value="no"><?php echo $lang['global.no']; ?></option>
                </select>
            </div>
        </div>
        <div class="clear"></div>
        <div class="center">
            <input type="submit" value="<?php echo $lang['ajax.search_advanced']; ?>" class="button" /><br /><br />
        </div>
    </form>
</div>
<div id="search_games"<?php if ($search_type != 'games') {echo ' style="display: none;"';} ?>>
    <form name="search_games_advanced" id="search_games_advanced_form" method="get" action="<?php echo $config['BASE_URL']; ?>/search">
        <input name="search_type" type="hidden" value="games" />
        <div class="search_left">
            <div class="separator">
                <label for="search_query_advanced"><?php echo $lang['ajax.search_for']; ?>:</label>
                <input name="search_query" type="text" id="search_query_advanced" />
            </div>
            <div class="separator">
                <label for="search_category"><?php echo $lang['global.category']; ?>:</label>
                <select name="c" id="search_category">                            
                    <option value=""><?php echo $lang['global.all']; ?></option>
                    <?php foreach ( $game_categs as $category ): ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo htmlspecialchars($category['category_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="separator">
                <label for="type"><?php echo $lang['global.type']; ?>:</label>
                <select name="type" id="type">
                    <option value=""><?php echo $lang['global.all']; ?></option>
                    <option value="public"><?php echo $lang['global.public']; ?></option>
                    <option value="private"><?php echo $lang['global.private']; ?></option>
                </select>                            
            </div>
        </div>
        <div class="search_right">
            <div class="separator">
                <label for="search_rating"><?php echo $lang['ajax.search_rating_higher']; ?>:</label>
                <select name="r" id="search_rating">
                    <option value=""><?php echo $lang['ajax.search_dont_care']; ?></option>
                    <option value="1">1</option>
                    <option value="1.5">1.5</option>
                    <option value="2">2</option>
                    <option value="2.5">2.5</option>
                    <option value="3">3</option>
                    <option value="3.5">3.5</option>
                    <option value="4">4</option>
                    <option value="4.5">4.5</option>
                    <option value="5">5</option>
                </select>
            </div>
        </div>
        <div class="clear"></div>
        <div class="center">
            <input type="submit" value="<?php echo $lang['ajax.search_advanced']; ?>" class="button" /><br /><br />
        </div>
    </form>
</div>
<?php
$response   = ob_get_contents();
ob_end_clean();

echo $response;
die();
?>
