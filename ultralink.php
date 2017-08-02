<?php
/*
Plugin Name: Ultralink
Plugin URI: https://ultralink.me
Description: The Hyperlink, 2.0. Add rich context to your writing, create a better experience for your readers and make more revenue doing it.
Version: 1.0.8
Author: Ultralink Inc.
Author URI: http://ultralink.me
License: Ultralink License
License URI: https://ultralink.me/w/license.txt
*/

//require_once('ultralink-actions.php'); //*
require_once('headers/globals.php'); //*

global $ultralink_db_version;     $ultralink_db_version = "1.0.8";

global $calloutType;              $calloutType = 'none';
global $previewRebuild;           $previewRebuild = 'no';
global $previewInfo;              $previewInfo = 'no';
global $plinkOverride;            $plinkOverride = '';

global $wpdb;         //*
$wpdb->show_errors(); //*

$dbPrefix = $wpdb->prefix;

$wpdb->query( "SHOW tables LIKE '" . $wpdb->prefix . "ultralink_config'" );

if( $wpdb->num_rows > 0 )
{
    if( $wpdb->get_var( "SELECT useMultisiteDatabase FROM `" . $wpdb->prefix . "ultralink_config`" ) == '1' ){ $dbPrefix = "wp_ms_"; }
}

class Ultralink
{
//    function cleanContentCache() //*
//    {
//        set_time_limit(0);
//        
//        ULCleanContentCache();        
//    }
//
//    function ultralinkCheckUpdates()
//    {
//        set_time_limit(0);
//
//        ULCheckUpdates();
//    }
//
//    function ultralinkMeSync()
//    {
//        set_time_limit(0);
//        
//        ULSubmitHoldingTank();
//		ULGetUpdatesForChangedContent();
//    }
//
//    function ultralinkMeCompleteSync()
//    {
//        set_time_limit(0);
//        
//		ULGetUpdatesForEverything();
//    }
//
//    function ultralinkMeSyncProcess()
//    {
//        set_time_limit(0);
//
//        ULGetLatestSyncContent();
//        ULProcessLatestSyncContent();
//    }

	function injectJavascriptLibraries()
	{
        wp_register_script('raphael', plugins_url('ultralinkLibraries/raphael+patch-min.js', __FILE__));
        wp_enqueue_script('raphael');        
        wp_enqueue_script('jquery');
        wp_register_script('ultralink', plugins_url('ultralink.js', __FILE__), array('jquery', 'raphael'));
        wp_enqueue_script('ultralink');
    }
    
    function injectJavascript($adminOptions)
	{    
        global $wpdb;
        global $dbPrefix;

        $scanFirst = 'false';
        $databaseOption = '';

        $categoryWhitelist = array();
        $categoryWhitelistResult = $wpdb->get_results("SELECT * FROM " . $dbPrefix . "ultralink_category_whitelist");
        foreach ( $categoryWhitelistResult as $categoryWhitelistEntry ){ array_push( $categoryWhitelist, $categoryWhitelistEntry->whitestring ); }

        $categoryBlacklist = array();
        $categoryBlacklistResult = $wpdb->get_results("SELECT * FROM " . $dbPrefix . "ultralink_category_blacklist");
        foreach ( $categoryBlacklistResult as $categoryBlacklistEntry ){ array_push( $categoryBlacklist, $categoryBlacklistEntry->blackstring ); }

        $options = $wpdb->get_row("SELECT * FROM " . $dbPrefix . "ultralink_config");
        if( !is_null($options) )
        {
            if( $options->alwaysSearch          == 1 ){ $addSearch             = "true"; }else{ $addSearch             = "false"; }

            if( $options->combineSimilarButtons == 1 ){ $combineSimilarButtons = "true"; }else{ $combineSimilarButtons = "false"; }
            if( $options->multipleSearchOptions == 1 ){ $multipleSearchOptions = "true"; }else{ $multipleSearchOptions = "false"; }
            if( $options->linksMakeNewWindows   == 1 ){ $linksMakeNewWindows   = "true"; }else{ $linksMakeNewWindows   = "false"; }
            if( $options->mouseProximityFade    == 1 ){ $mouseProximityFade    = "true"; }else{ $mouseProximityFade    = "false"; }

            $hoverTime         = $options->hoverTime;
            $popupRecoveryTime = $options->popupRecoveryTime;

            $sourceType        = $options->sourceType;
            $source            = $options->source;

            $amazonAffiliateTag = $options->amazonAffiliateTag;
            $linkshareID        = $options->linkshareID;
            $phgID              = $options->phgID;
            $ebayCampaign       = $options->ebayCampaign;

            if( $sourceType == 0 )
            {
                $scanFirst = 'true';
                
                if( ($source != '') && ($source != 'ultralink.me') )
                {
                    $databaseOption = "'database':'$source', ";
                }
            }

            if( $options->hasHoverTime          == 0 ){ $hoverTime         = 100000; }
            if( $options->hasPopupRecoveryTime  == 0 ){ $popupRecoveryTime =      0; }

            if( $options->ultralinkMeAnalytics  == 1 ){ $UMAnalytics           = "true"; }else{ $UMAnalytics           = "false"; }
            
                 if( $options->defaultSearch == 'google' ){ $searchURL = "http://www.google.com/search?q="; }
            else if( $options->defaultSearch ==   'bing' ){ $searchURL = "http://www.bing.com/search?q=";   }
                                                      else{ $searchURL = "http://www.google.com/search?q="; }

            $imagesURL = plugin_dir_url( __FILE__ ) . "ultralinkImages/";
            
            echo "<script type='text/javascript'>Ultralink.startUltralink( { $databaseOption 'operationalEnv':'wordpress', 'scanFirst':'$scanFirst', 'sectionSelector':'div.entry-content, div.entry_content, div.post-entry', 'combineLikeButtons':'$combineSimilarButtons', 'seperateSearch':'$multipleSearchOptions', 'newWindows':'$linksMakeNewWindows', 'proximityFade':'$mouseProximityFade', 'hoverTime':'$hoverTime', 'hoverRecoverTime':'$popupRecoveryTime', 'addSearch':'$addSearch', 'searchURL':'$searchURL', 'imagesURL':'$imagesURL', 'inlinePopups':'true', 'UMAnalytics':'$UMAnalytics'$adminOptions, 'iconSide' : 'right', 'affiliateInfo' : { 'buyamazon': '$amazonAffiliateTag', 'buyapple': '$phgID', 'buyebay': '$ebayCampaign' }, 'categoryWhitelist': " . json_encode($categoryWhitelist) . ", 'categoryBlacklist': " . json_encode($categoryBlacklist) . "  } );</script>";
        }        
	}

    function injectPostAdminJavascriptLibraries()
    {        
        echo "<script type='text/javascript' src='" . plugins_url('libraries/badger.min.js', __FILE__) . "'></script>";
//        echo "<style type='text/css' src='" . plugins_url('libraries/badger.min.css', __FILE__) . "'></style>";
        echo "<link rel='stylesheet' id='badger' href='" . plugins_url('libraries/badger.min.css', __FILE__) . "' type='text/css' media='all'>";

        echo "<script type='text/javascript' src='" . plugins_url('ultralinkLibraries/raphael+patch-min.js', __FILE__) . "'></script>";
        echo "<script type='text/javascript' src='" . plugins_url('ultralink.js', __FILE__) . "'></script>";
    }
    
    function injectPostAdminJavascript()
    {
        Ultralink::injectJavascript(", 'notLivePage':'true', 'noHover':'true', 'inlinePopups':'false', 'seperateSearch':'false', 'previewCallback':previewCallback ");
    }

//	function postEditBox( $post ) //*
//	{
//		require_once('ultralink-postedit.php');
//	}

    function ultralink_menu()
    {
        if( function_exists('add_menu_page') ){ add_menu_page(__('Ultralink', 'wp-ultralink'), __('Ultralink', 'wp-ultralink'), 'manage_options', plugin_dir_path(__FILE__) . 'ultralink-manager.php', '', plugins_url('images/logo16.png', __FILE__)); }
    }

    function network_ultralink_menu()
    {
        if( function_exists('add_menu_page') ){ add_menu_page(__('Ultralink', 'wp-ultralink'), __('Ultralink', 'wp-ultralink'), 'manage_network_options', plugin_dir_path(__FILE__) . 'ultralink-networkmanager.php', '', plugins_url('images/logo16.png', __FILE__)); }
    }

//    function metaBoxes() //*
//    {
//        global $wpdb;
//        global $dbPrefix;
//
//        $scanFirst = 'false';
//        $databaseOption = '';
//        
//        $sourceType = $wpdb->get_var("SELECT sourceType FROM " . $dbPrefix . "ultralink_config");
//
//        if( $sourceType == 1 )
//        {
//            add_meta_box( 'postEditBox', __( 'Ultralink', 'wp-ultralink' ), array('Ultralink', 'postEditBox'), 'post', 'normal', 'high' );
//            add_meta_box( 'postEditBox', __( 'Ultralink', 'wp-ultralink' ), array('Ultralink', 'postEditBox'), 'page', 'normal', 'high' );
//        }
//    }
    
//     function cron_add_weekly( $schedules ) //*
//     {
//        $schedules['weekly'] = array( 'interval' => 604800, 'display' => __( 'Once Weekly' ) );
//        return $schedules;
//    }

//    function addTags($content) //*
//    {
//        global $previewRebuild;
//        global $plinkOverride;
//        
//        global $wpdb;
//        global $dbPrefix;
//        
//        global $post;
//        global $more;
//        global $page;
//        
////        if( strstr( $content, "ULTRALINKTEST" ) != FALSE )
////        {
//////            global $permalink;
//////            echo get_sample_permalink($post->ID);
//////            echo get_permalink($post->ID);
//////            echo get_permalink(20);
//////            echo the_permalink();
//////            echo post_permalink();
//////echo esc_url( wp_logout_url( $_SERVER['REQUEST_URI'] ) );
//////            echo $permalink;
//////            print_r($post);
////            echo "MORE: " . $more;
////        }
//        
//        $options = $wpdb->get_row( $wpdb->prepare("SELECT ultralinkEnabled, sourceType FROM " . $dbPrefix . "ultralink_config", null) );
//
//        if( ($options->ultralinkEnabled == 1) && ($options->sourceType == 1) )
//        {
////            if( strstr( $content, "ULTRALINKTEST" ) != FALSE )
//            {
//                if( strstr( $content, "<!--noultralink-->" ) == FALSE ) // Don't add any tags or do anything at all to this content
//                {
//                    $contentHash = sha1($content);
//                    
//                    if( (strstr( $content, "<!--alwaysultralink-->" ) == TRUE) || ($previewRebuild == "yes") ){ $filteredContent = null; } // Ignore the cache and always rebuild from scratch every time
//                    else
//                    {
////                        $filteredContent = $wpdb->get_var( $wpdb->prepare("SELECT content_filtered FROM " . $dbPrefix . "ultralink_content" . " WHERE content_hash=UNHEX('$contentHash')") );
//                        $filteredContent = $wpdb->get_var( $wpdb->prepare("SELECT content_filtered FROM " . $dbPrefix . "ultralink_content" . " WHERE content_hash='%s'", $contentHash) );
//                    }
//                    
//                    if( is_null($filteredContent) )
//                    {
//                        $plink = get_permalink($post->ID);
//                        if( !empty($plinkOverride) ){ $plink = $plinkOverride; }
//                        
//                        $localReplacements = 0;
//                        $canonReplacements = 0;
//                        $wordCount = 0;
//                        $hyperlinkCount = 0;
//                        $filteredResponse = ULFilterContent($content, $plink, $localReplacements, $canonReplacements, $wordCount, $hyperlinkCount);
//
//                        if( $previewRebuild != "yes" )
//                        {
////                            $wpdb->query("INSERT INTO " . $dbPrefix . "ultralink_content" . " (content_hash, content_filtered, content_unfiltered, permalink, more, page) VALUES( 'UNHEX('$contentHash')', '" . esc_sql($filteredResponse) . "', '" . esc_sql($content) . "', '" . esc_sql($plink) . "', '" . $more . "', '" . $page . "')");
//                            $wpdb->query("INSERT INTO " . $dbPrefix . "ultralink_content" . " (post_ID, content_hash, content_filtered, content_unfiltered, localReplacements, canonReplacements, wordCount, hyperlinkCount, permalink, more, page) VALUES( '" . $post->ID . "', '$contentHash', '" . esc_sql($filteredResponse) . "', '" . esc_sql($content) . "', '$localReplacements', '$canonReplacements', '$wordCount', '$hyperlinkCount', '" . esc_sql($plink) . "', '" . $more . "', '" . $page . "')");
//							
//							$numInChangedRecord = $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM " . $dbPrefix . "ultralink_changed_content" . " WHERE permalink='%s' AND more='%s' AND page='%s'", $plink, $more, $page) );
//							if( $numInChangedRecord == 0 )
//							{
//								$wpdb->query("INSERT INTO " . $dbPrefix . "ultralink_changed_content" . " (permalink, more, page) VALUES( '" . esc_sql($plink) . "', '" . $more . "', '" . $page . "')");
//							}
//                            
////							ULGetUpdatesForChangedContent(); // This called here will always be once behind because we already performed the filter.
//                        }
//                        
//                        return stripslashes($filteredResponse);
//                    }
//                    else
//                    {
//                        return $filteredContent;
//                    }
//                }
//            }
//        }
//        
//        return $content;
//    }
        
    function makeTables( $prefix )
    {
        global $ultralink_version;

        // Stupid dbDelta falls over at undocumented deviations. DON'T TOUCH THE BROKEN SPACING! dbDelta needs it exactly like this for some reason.

        $sql = "
        CREATE TABLE " . $prefix . "ultralink_descriptions" . " (
        ID bigint(20) NOT NULL AUTO_INCREMENT,
        time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
        category text NOT NULL,
        config mediumtext NOT NULL,
        PRIMARY KEY  (ID)
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";

        $sql2 = "
        CREATE TABLE " . $prefix . "ultralink_words" . " (
        word char(128) NOT NULL,
        scope char(255) NOT NULL,
        description_ID bigint(20) NOT NULL,
        caseSensitive boolean DEFAULT 0,
        PRIMARY KEY  (word,scope,description_ID)
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";
// dbDelta can't handle foreign keys
//        FOREIGN KEY (description_ID)
//          REFERENCES " . $prefix . "ultralink_descriptions(ID)
//          ON UPDATE CASCADE ON DELETE RESTRICT

        $sql3 = "
        CREATE TABLE " . $prefix . "ultralink_descriptions_canon" . " (
        ID bigint(20) NOT NULL AUTO_INCREMENT,
        time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
        category text NOT NULL,
        config mediumtext NOT NULL,
        PRIMARY KEY  (ID)
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";

        $sql4 = "
        CREATE TABLE " . $prefix . "ultralink_descriptions_canon_overlays" . " (
        description_ID bigint(20) NOT NULL,
        config mediumtext NOT NULL,
        PRIMARY KEY  (description_ID)
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";
        
        $sql5 = "
        CREATE TABLE " . $prefix . "ultralink_words_canon" . " (
        word char(128) NOT NULL,
        scope char(255) NOT NULL,
        description_ID bigint(20) NOT NULL,
        caseSensitive boolean DEFAULT 0,
        overlay boolean DEFAULT 0,
        PRIMARY KEY  (word,scope,description_ID,overlay)
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";
// dbDelta can't handle foreign keys
//        FOREIGN KEY (description_ID)
//          REFERENCES " . $prefix . "ultralink_descriptions_canon(ID)
//          ON UPDATE CASCADE ON DELETE RESTRICT

        $sql6 = "
        CREATE TABLE " . $prefix . "ultralink_content" . " (
        ID bigint(20) NOT NULL AUTO_INCREMENT,
        post_ID bigint(20) UNSIGNED NOT NULL, 
        permalink text NOT NULL,
        time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
        content_hash TINYTEXT NOT NULL,
        content_filtered longtext NOT NULL,
        content_unfiltered longtext NOT NULL,
        localReplacements int DEFAULT 0,
        canonReplacements int DEFAULT 0,
        wordCount int DEFAULT 0,
        hyperlinkCount int DEFAULT 0,
        more tinyint(1) DEFAULT 1,
        page int(11) DEFAULT 1,
        UNIQUE KEY  (ID)
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";

        $multiSiteDefault = '0'; if( $prefix == "wp_ms_" ){ $multiSiteDefault = '1'; }
        
        $sql7 = "
        CREATE TABLE " . $prefix . "ultralink_config" . " (
        ultralinkEnabled boolean DEFAULT 1,
        alwaysSearch boolean DEFAULT 1,
        combineSimilarButtons boolean DEFAULT 1,
        multipleSearchOptions boolean DEFAULT 0,
        linksMakeNewWindows boolean DEFAULT 0,
        mouseProximityFade boolean DEFAULT 1,
        hasHoverTime boolean DEFAULT 0,
        hasPopupRecoveryTime boolean DEFAULT 1,
        hoverTime int(11) DEFAULT 250,
        popupRecoveryTime int(11) DEFAULT 100,
        defaultSearch tinytext,
        useMultisiteDatabase boolean DEFAULT $multiSiteDefault,
        amazonAffiliateTag tinytext,
        linkshareID tinytext,
        phgID tinytext,
        ebayCampaign tinytext,
        ultralinkMeEmail tinytext,
        ultralinkMeAPIKey tinytext,
        ultralinkMeStaticContentKey tinytext,
        ultralinkMeWebsiteVerifier tinytext,
        ultralinkMeLastSync timestamp NOT NULL,
        mergeUltralinkMeLinks boolean DEFAULT 1,
        latestAvailableVersion int(11) DEFAULT $ultralink_version,
        latestAvailableVersionString tinytext,
        ultralinkMeAnalytics boolean DEFAULT 1,
        ultralinkMeLastSyncContents longtext NOT NULL,
        sourceType int(11) DEFAULT 0,
        source tinytext
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";

        $sql8 = "
        CREATE TABLE " . $prefix . "ultralink_holdingtank" . " (
        ID bigint(20) NOT NULL AUTO_INCREMENT,
        changeEntry mediumtext NOT NULL,
        time timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (ID)
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";

        $sql9 = "
        CREATE TABLE " . $prefix . "ultralink_changed_content" . " (
        permalink text NOT NULL,
        more tinyint(1) DEFAULT 1,
        page int(11) DEFAULT 1
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";

        $sql10 = "
        CREATE TABLE " . $prefix . "ultralink_category_whitelist" . " (
        whitestring text NOT NULL
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";

        $sql11 = "
        CREATE TABLE " . $prefix . "ultralink_category_blacklist" . " (
        blackstring text NOT NULL
        ) CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
        dbDelta($sql2);
        dbDelta($sql3);
        dbDelta($sql4);
        dbDelta($sql5);
        dbDelta($sql6);
        dbDelta($sql7);
        dbDelta($sql8);
        dbDelta($sql9);
        dbDelta($sql10);
        dbDelta($sql11);
    }
    
    function ultralink_activate()
    {
        global $wpdb;
        global $ultralink_db_version;

        Ultralink::makeTables( $wpdb->prefix );
        
        update_option("ultralink_db_version", $ultralink_db_version);

//        wp_schedule_event(current_time('timestamp'), 'daily', 'ultralink_clean_content_cache'); //*
//        wp_schedule_event(current_time('timestamp'), 'hourly', 'ultralink_check_updates');
//        wp_schedule_event(current_time('timestamp'), 'twicedaily', 'ultralink_me_sync');
//        wp_schedule_event(current_time('timestamp') + 1800, 'twicedaily', 'ultralink_me_sync_process'); // Plus .5 hours
//        wp_schedule_event(current_time('timestamp') + 21600, 'weekly', 'ultralink_me_complete_sync'); // Plus 6 hours
//        wp_schedule_event(current_time('timestamp') + 23400, 'weekly', 'ultralink_me_complete_sync_process'); // Plus 6.5 hours
    }
    
    function ultralink_activation( $networkwide )
    {
        global $wpdb;

        if (function_exists('is_multisite') && is_multisite() )
        {
            Ultralink::makeTables("wp_ms_");
            
            if( $networkwide )
            {            
                $thisBlog = $wpdb->blogid;

                $blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs", null));
                foreach( $blogids as $bid ){ switch_to_blog($bid); Ultralink::ultralink_activate(); }
                
                switch_to_blog($thisBlog);
                return;
            }   
        }

        Ultralink::ultralink_activate();
    }

    function ultralinkDeactivate()
    {
//        wp_clear_scheduled_hook('ultralink_clean_content_cache'); //*
//        wp_clear_scheduled_hook('ultralink_check_updates');
//        wp_clear_scheduled_hook('ultralink_me_sync');
//        wp_clear_scheduled_hook('ultralink_me_sync_process');
//        wp_clear_scheduled_hook('ultralink_me_complete_sync');
//        wp_clear_scheduled_hook('ultralink_me_complete_sync_process');
    }

    function ultralink_deactivation( $networkwide )
    {
        global $wpdb;

        if( function_exists('is_multisite') && is_multisite() )
        {
            if( $networkwide )
            {
                $thisBlog = $wpdb->blogid;
                
                $blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs", null));
                foreach( $blogids as $bid ){ switch_to_blog($bid); Ultralink::ultralinkDeactivate(); }
                
                switch_to_blog($thisBlog);
                return;
            }   
        }

        Ultralink::ultralinkDeactivate();
    }
}

//add_filter( 'cron_schedules',                     array('Ultralink', 'cron_add_weekly')                    ); //*
//add_filter( 'the_content',                        array('Ultralink', 'addTags')                            );
    
add_action( 'get_header',                         array('Ultralink', 'injectJavascriptLibraries')          );
add_action( 'get_footer',                         array('Ultralink', 'injectJavascript')                   );
add_action( 'admin_menu',                         array('Ultralink', 'ultralink_menu')                     );
add_action( 'network_admin_menu',                 array('Ultralink', 'network_ultralink_menu')             );
//add_action( 'add_meta_boxes',                     array('Ultralink', 'metaBoxes')                          ); //*

//add_action( 'admin_head',                         array('Ultralink', 'injectPostAdminJavascriptLibraries') ); //*

//add_action( 'admin_footer-post-new.php',          array('Ultralink', 'injectPostAdminJavascript')          ); //*
//add_action( 'admin_footer-post.php',              array('Ultralink', 'injectPostAdminJavascript')          );
//add_action( 'admin_footer-page-new.php',          array('Ultralink', 'injectPostAdminJavascript')          );
//add_action( 'admin_footer-page.php',              array('Ultralink', 'injectPostAdminJavascript')          );

//add_action( 'ultralink_clean_content_cache',      array('Ultralink', 'cleanContentCache')                  ); //*
//add_action( 'ultralink_check_updates',            array('Ultralink', 'ultralinkCheckUpdates')              );
//add_action( 'ultralink_me_sync',                  array('Ultralink', 'ultralinkMeSync')                    );
//add_action( 'ultralink_me_sync_process',          array('Ultralink', 'ultralinkMeSyncProcess')             );
//add_action( 'ultralink_me_complete_sync',         array('Ultralink', 'ultralinkMeCompleteSync')            );
//add_action( 'ultralink_me_complete_sync_process', array('Ultralink', 'ultralinkMeSyncProcess')             );

function update_db_check()
{
    global $ultralink_db_version;

    if( get_site_option( 'ultralink_db_version' ) != $ultralink_db_version ){ Ultralink::ultralink_activate(); }
}

add_action( 'plugins_loaded', 'update_db_check' );

register_activation_hook( __FILE__,               array('Ultralink', 'ultralink_activation')               );
register_deactivation_hook( __FILE__,             array('Ultralink', 'ultralink_deactivation')             );

function saveSettings()
{
    global $wpdb;

    $dbPrefix = $wpdb->prefix;
    if( (!empty($_POST['networkAdmin'])) && ($_POST['networkAdmin'] == 'true') ){ $dbPrefix = "wp_ms_"; }
    else
    {
        $wpdb->query( "SHOW tables LIKE '" . $wpdb->prefix . "ultralink_config'" );

        if( $wpdb->num_rows > 0 )
        {
            if( $wpdb->get_var( "SELECT useMultisiteDatabase FROM `" . $wpdb->prefix . "ultralink_config`" ) == '1' ){ $dbPrefix = "wp_ms_"; }
        }
    }

    $categoryWhitelist     = ""; if( !empty($_POST['ultralink_categoryWhitelist']) ){ $categoryWhitelist = trim(urldecode($_POST['ultralink_categoryWhitelist'])); }
    $categoryBlacklist     = ""; if( !empty($_POST['ultralink_categoryBlacklist']) ){ $categoryBlacklist = trim(urldecode($_POST['ultralink_categoryBlacklist'])); }

    $enabled               = 0; if( $_POST['ultralink_ultralinkEnabled']      == 'true' ){ $enabled               = 1; }
    $alwaysSearch          = 0; if( $_POST['ultralink_alwaysSearch']          == 'true' ){ $alwaysSearch          = 1; }

    $combineSimilarButtons = 0; if( $_POST['ultralink_combineSimilarButtons'] == 'true' ){ $combineSimilarButtons = 1; }
    $multipleSearchOptions = 0; if( $_POST['ultralink_multipleSearchOptions'] == 'true' ){ $multipleSearchOptions = 1; }
    $linksMakeNewWindows   = 0; if( $_POST['ultralink_linksMakeNewWindows']   == 'true' ){ $linksMakeNewWindows   = 1; }
    $mouseProximityFade    = 0; if( $_POST['ultralink_mouseProximityFade']    == 'true' ){ $mouseProximityFade    = 1; }

    $hasHoverTime          = 0; if( $_POST['ultralink_hasHoverTime']          == 'true' ){ $hasHoverTime          = 1; }
    $hasPopupRecoveryTime  = 0; if( $_POST['ultralink_hasPopupRecoveryTime']  == 'true' ){ $hasPopupRecoveryTime  = 1; }

    $hoverTime             = $_POST['ultralink_hoverTime'];
    $popupRecoveryTime     = $_POST['ultralink_popupRecoveryTime'];

    $mergeLinks            = 0; if( $_POST['ultralink_mergeUltralinkMeLinks'] == 'true' ){ $mergeLinks            = 1; }

    $analytics             = 0; if( $_POST['ultralink_ultralinkMeAnalytics']  == 'true' ){ $analytics             = 1; }
    
    $source                = esc_sql($_POST['ultralink_source']);
    
    $defaultSearch = esc_sql($_POST['ultralink_defaultSearch']);
    
//    $useMultisiteDatabase  = 0; if( $_POST['ultralink_useMultisiteDatabase']  == 'true' ){ $useMultisiteDatabase  = 1; }
    
    $amazonAffiliateTag = esc_sql($_POST['ultralink_amazonAffiliateTag']);
    $linkshareID        = esc_sql($_POST['ultralink_linkshareID']);
    $phgID              = esc_sql($_POST['ultralink_phgID']);
    $ebayCampaign       = esc_sql($_POST['ultralink_ebayCampaign']);

//        $wpdb->query("DELETE FROM " . $dbPrefix . "ultralink_config");
//        $wpdb->query("INSERT INTO " . $dbPrefix . "ultralink_config (ultralinkEnabled, alwaysSearch, defaultSearch, amazonAffiliateTag, linkshareID) VALUES('$enabled', '$alwaysSearch', '$defaultSearch', '$amazonAffiliateTag', '$linkshareID')");
//    $wpdb->query("UPDATE " . $dbPrefix . "ultralink_config SET ultralinkEnabled='$enabled', alwaysSearch='$alwaysSearch', combineSimilarButtons='$combineSimilarButtons', multipleSearchOptions='$multipleSearchOptions', linksMakeNewWindows='$linksMakeNewWindows', mouseProximityFade='$mouseProximityFade', hasHoverTime='$hasHoverTime', hasPopupRecoveryTime='$hasPopupRecoveryTime', hoverTime='$hoverTime', popupRecoveryTime='$popupRecoveryTime', defaultSearch='$defaultSearch', useMultisiteDatabase='$useMultisiteDatabase', amazonAffiliateTag='$amazonAffiliateTag', linkshareID='$linkshareID', ebayCampaign='$ebayCampaign', mergeUltralinkMeLinks='$mergeLinks', ultralinkMeAnalytics='$analytics' WHERE 1");
    $wpdb->query("UPDATE " . $dbPrefix . "ultralink_config SET ultralinkEnabled='$enabled', alwaysSearch='$alwaysSearch', combineSimilarButtons='$combineSimilarButtons', multipleSearchOptions='$multipleSearchOptions', linksMakeNewWindows='$linksMakeNewWindows', mouseProximityFade='$mouseProximityFade', hasHoverTime='$hasHoverTime', hasPopupRecoveryTime='$hasPopupRecoveryTime', hoverTime='$hoverTime', popupRecoveryTime='$popupRecoveryTime', defaultSearch='$defaultSearch', amazonAffiliateTag='$amazonAffiliateTag', linkshareID='$linkshareID', phgID='$phgID', ebayCampaign='$ebayCampaign', mergeUltralinkMeLinks='$mergeLinks', ultralinkMeAnalytics='$analytics', source='$source' WHERE 1");

    $wpdb->query("DELETE FROM "  . $dbPrefix . "ultralink_category_whitelist");
    if( !empty($categoryWhitelist) )
    {
        $cwl = explode("\n", $categoryWhitelist);
        for( $c = 0; $c < count($cwl); $c++ ){ $wpdb->query("INSERT INTO "  . $dbPrefix . "ultralink_category_whitelist (whitestring) VALUES('" . esc_sql($cwl[$c])  . "')"); }
    }

    $wpdb->query("DELETE FROM "  . $dbPrefix . "ultralink_category_blacklist");
    if( !empty($categoryBlacklist) )
    {
        $cbl = explode("\n", $categoryBlacklist);
        for( $c = 0; $c < count($cbl); $c++ ){ $wpdb->query("INSERT INTO "  . $dbPrefix . "ultralink_category_blacklist (blackstring) VALUES('" . esc_sql($cbl[$c])  . "')"); }
    }

    // If WP Super Cache is installed then invalidate entire cache
//            if( function_exists('wp_cache_clear_cache') ){ wp_cache_clear_cache(); }

	die();
}

function toggleMultiSite()
{
    global $wpdb;

    $useMultisiteDatabase = 0; if( $_POST['ultralink_useMultisiteDatabase'] == 'true' ){ $useMultisiteDatabase = 1; }
    
    $wpdb->query("UPDATE " . $wpdb->prefix . "ultralink_config SET useMultisiteDatabase='$useMultisiteDatabase' WHERE 1");

	die();
}

add_action('wp_ajax_saveSettings',    'saveSettings'   ); //*
add_action('wp_ajax_toggleMultiSite', 'toggleMultiSite'); //*

?>