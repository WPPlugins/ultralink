<div>

    <?php require_once('headers/adminheader.php'); ?>

    <script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ) . '/libraries/ultralinkUtilities.js'; ?>"></script>
    <script type="text/javascript">
        var localAPI = "<?php echo plugin_dir_url( __FILE__ ) . 'API/'; ?>";
    </script>

    <link rel="stylesheet" href="<?php echo plugin_dir_url( __FILE__ ) . 'images/tabs.css'; ?>" type="text/css" media="screen" />

    <h1>Ultralink <span style='display: <?php if( empty($networkAdmin) || ((!empty($networkAdmin)) && ($networkAdmin == "false")) ){ echo "none"; } ?>;'>(Multi-Site Settings)</span><span style='display: <?php if( $useMultisiteDatabase == "unchecked" ){ echo "none"; } ?>;'>(Using Multi-Site Settings)</span></h1>

    <ul class="tabs" id="managerTabs" style="display: none;">
        <li id='contentTab'><a href="#content">Content</a></li>
        <li id='wordsTab'><a href="#wordsdatabase" onclick='refreshSpinnerPosition(); setTimeout( function(){ document.getElementById("ultralink_SEARCH").focus(); }, 250 );'>Words Database</a></li>
        <li id='breakdownTab'><a href="#breakdown">Category Breakdown</a></li>
        <li id='settingsTab'><a href="#setup">Setup</a></li>
    </ul>

    <div class="panes" id="managerTabDivs">
        <div id='contentPane'>
            <?php /*require_once('panes/content.php');*/ ?>
        </div>
        <div id='wordsPane'>
            <?php /*require_once('panes/wordsearch.php');*/ ?>
            <?php /*require_once('panes/worddetails.php');*/ ?>
            
            <!--
            <script type="text/javascript">
                wordClearCallback = function(){ if( currentlySelectedWordRow != undefined ){ currentlySelectedWordRow.style.background = previousBGColor; currentlySelectedWordRow = undefined; } }
                wordUpdateCallback = function(){ searchWord(document.getElementById("ultralink_SEARCH")); }
            </script>
            -->
        </div>
        <div id='breakdownPane'>
            <?php /*require_once('panes/breakdown.php');*/ ?>
        </div>
        <div id='settingsPane'>
            <?php require_once('panes/settings.php'); ?>
        </div>
    </div>

    <script type="text/javascript">
        jQuery("ul.tabs").tabs("div.panes > div");
		
//        var pane = '<?php /*echo $_GET['pane'];*/ ?>';
        
//        if( pane )
//        {
//			jQuery("ul.tabs").data("tabs").click(pane);            
//        }
		
        if( ((!(ultralinkMeEmail && ultralinkMeAPIKey)) && (useMultisiteDatabase != "checked")) || (sourceType == 0) )
		{
			jQuery("ul.tabs").data("tabs").click(3);
		}
        
        if( sourceType == 0 )
        {
//            jQuery('#contentTab').hide();
//            jQuery('#wordsTab').hide();
//            jQuery('#breakdownTab').hide();

            jQuery('#managerTabs').hide();
        }
		
    </script>

</div>
