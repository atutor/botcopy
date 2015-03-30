<?php
/*******
 * doesn't allow this file to be loaded with a browser.
 */
if (!defined('AT_INCLUDE_PATH')) { exit; }

/******
 * this file must only be included within a Module obj
 */
if (!isset($this) || (isset($this) && (strtolower(get_class($this)) != 'module'))) { exit(__FILE__ . ' is not a Module'); }

/*******
 * assign the instructor and admin privileges to the constants.
 */

define('AT_ADMIN_PRIV_BOTCOPY', $this->getAdminPrivilege());


/*******
 * add the admin pages when needed.
 */
if (admin_authenticate(AT_ADMIN_PRIV_BOTCOPY, TRUE) || admin_authenticate(AT_ADMIN_PRIV_ADMIN, TRUE)) {
	$this->_pages[AT_NAV_ADMIN] = array('mods/botcopy/index_admin.php');
	$this->_pages['mods/botcopy/index_admin.php']['title_var'] = 'botcopy';
	$this->_pages['mods/botcopy/index_admin.php']['parent']    = AT_NAV_ADMIN;
}

//////////
// ATSP Custom redirect for search bots

/**
 * Checks if a user agent is a search engine
 * @author	Pietra Arumaga, Greg Gay
 * @date	May 1, 2011
 * for more crallers see http://www.useragentstring.com/pages/Crawlerlist/
 */
function is_bot(){
    global $bots;
    $bots = array(
        'Googlebot', 'Google','Baiduspider', 'ia_archiver',
        'R6_FeedFetcher', 'NetcraftSurveyAgent', 'Sogou web spider',
        'bingbot', 'Yahoo! Slurp', 'facebookexternalhit', 'PrintfulBot',
        'msnbot', 'Twitterbot', 'UnwindFetchor',
        'urlresolver', 'Butterfly', 'TweetmemeBot' );
        
    foreach($bots as $b){
        if( stripos( $_SERVER['HTTP_USER_AGENT'], $b ) !== false ) return true;
    }
    return false;
}


if($_SERVER['HTTP_HOST'] == "atsp.atutorspaces.com" ){
    // Directory where the search bot friendly copy of ATutor exists
    // Created with HTTracks or some similar utility
    // 
    //$bot_friendly_path = preg_replace("#\.php#",".html", $_SERVER['PHP_SELF']);
    $bot_friendly_copy = "https://atsp.atutorspaces.com/botcopy/atsp.atutorspaces.com";
    //global $_custom_script;
    if(is_bot()){
       // is_bot() see include/lib/vitals.inc.php
       // header('Location: '.$bot_friendly_copy. $_SERVER['PHP_SELF'], TRUE,301);
       // exit;
 
    } else {
        global $bots, $_custom_script;
        $_custom_script  .='
    <script type="text/javascript" language="javascript">
        var bots = new Array();'."\n";
        foreach($bots as $key => $val){
            $_custom_script .= "           bots.push('".$val."');\n";
        }         

        $_custom_script  .='    </script>';

        if(isset($_config['apache_mod_rewrite'])){
            $this_page = preg_replace('/\/go.php/','',$_SERVER['PHP_SELF']);
             $this_page = preg_replace('/content.php/','content',$this_page);
             $this_page = preg_replace('/cid\//','',$this_page);
        } else {
            $this_page = $_SERVER['PHP_SELF'];
        }
        $_custom_script  .= '
    <script type="text/javascript">
        for (var i = 0; i < bots.length; i++) {
            var thisbot = new RegExp(bots[i], \'i\');
            if(navigator.userAgent.match(thisbot) ){
                var is_bot = true;
            }  else {
                var is_bot = false;
            }
        }  
        var url = window.location.href;
        if(url.match(/botcopy/)){ 
            if(is_bot === false){
                if(url.match(/index.html/)){
                    url = url.replace(\'index\', \'\');
                    url = url.replace(\'.php\', \'\');
                    url = url.replace(\'.html\', \'\');
                } else {
                     url = url.replace(\'.html\', \'.php\');
                }
                url = url.replace(\'/botcopy/atsp.atutorspaces.com\',\'\');
                console.log(url);
                window.location = url;
            }  
        }    
    </script>
        ';
    }
}


// End ATutorSpaces custom 
////////

?>