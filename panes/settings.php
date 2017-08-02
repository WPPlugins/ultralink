<style>

    .divider
    {
        content:""; 
        height:1px;
        background:-moz-linear-gradient(left, #EEEEEE 0%,rgb(150,150,150) 33%,rgb(150,150,150) 66%,#EEEEEE 100%);
        background:-webkit-linear-gradient(left, #EEEEEE 0%,rgb(150,150,150) 33%,rgb(150,150,150) 66%,#EEEEEE 100%);
        background:linear-gradient(left, #EEEEEE 0%,rgb(150,150,150) 33%,rgb(150,150,150) 66%,#EEEEEE 100%);
        width:100%;
        display:block;

        margin: auto;
    }

    .settingSection
    {
        background-color: #f8f8f8;
        padding: 10px;
        width: 500px;
        border-radius: 10px;
        -moz-border-radius: 10px;
    }

    .categoryList
    {
        width: 100%;
        height: 70px;
    }

    #ultralinkmeDatabaseDiv
    {
        background: #CFE1FF;
        padding: 10px;
        text-align: center;
        margin-bottom: 10px;
    }

    #ultralinkmeDatabaseInfo
    {
        text-align: left;
    }

</style>
<script type="text/javascript">

    var siteurl = "<?php echo site_url(); ?>";
    var APIversion = "<?php global $APIversion; echo $APIversion; ?>";
    
    function microtime( get_as_float )
    {
        var now = new Date().getTime() / 1000;
        var s = parseInt(now, 10);

        return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
    }
    
    function updateUltralinkSettings()
    {
        var oldAmazonTag    = amazonAffiliateTag;
        var oldLinkshareID  = linkshareID;
        var oldPHGID        = phgID;
        var oldEbayCampaign = ebayCampaign;
    
        jQuery('#ultralink_Settings').hide();
        jQuery('#saving_Settings').show();

        amazonAffiliateTag = document.getElementById('ultralink_amazonAffiliateTag').value;
        linkshareID        = document.getElementById('ultralink_linkshareID').value;
        phgID              = document.getElementById('ultralink_phgID').value;
        ebayCampaign       = document.getElementById('ultralink_ebayCampaign').value;
        
        ultralinkMeEmail    = document.getElementById('ultralinkMeEmail').value;
        ultralinkMePassword = document.getElementById('ultralinkMePassword').value;
        
        var defaultSearchDropdown = document.getElementById('ultralink_defaultSearch');
        var settingsString = "ultralink_save_settings=Yes";
        settingsString += "&ultralink_alwaysSearch=" + document.getElementById('ultralink_alwaysSearch').checked;
        settingsString += "&ultralink_ultralinkEnabled=" + document.getElementById('ultralink_ultralinkEnabled').checked;

        settingsString += "&ultralink_combineSimilarButtons=" + document.getElementById('ultralink_combineSimilarButtons').checked;
        settingsString += "&ultralink_multipleSearchOptions=" + document.getElementById('ultralink_multipleSearchOptions').checked;
        settingsString += "&ultralink_linksMakeNewWindows="   + document.getElementById('ultralink_linksMakeNewWindows').checked;
        settingsString += "&ultralink_mouseProximityFade="    + document.getElementById('ultralink_mouseProximityFade').checked;

        settingsString += "&ultralink_hasHoverTime="          + document.getElementById('ultralink_hasHoverTime').checked;
        settingsString += "&ultralink_hasPopupRecoveryTime="  + document.getElementById('ultralink_hasPopupRecoveryTime').checked;

        settingsString += "&ultralink_hoverTime="             + document.getElementById('ultralink_hoverTime').value;
        settingsString += "&ultralink_popupRecoveryTime="     + document.getElementById('ultralink_popupRecoveryTime').value;

        settingsString += "&ultralink_source="                + document.getElementById('ultralink_source').value;

        settingsString += "&ultralink_defaultSearch=" + defaultSearchDropdown.options[defaultSearchDropdown.selectedIndex].value;

        settingsString += "&ultralink_amazonAffiliateTag=" + encodeURIComponent(amazonAffiliateTag);
        settingsString += "&ultralink_linkshareID=" + encodeURIComponent(linkshareID);
        settingsString += "&ultralink_phgID=" + encodeURIComponent(phgID);
        settingsString += "&ultralink_ebayCampaign=" + encodeURIComponent(ebayCampaign);
        settingsString += "&ultralink_mergeUltralinkMeLinks=" + document.getElementById('ultralink_mergeUltralinkMeLinks').checked;
        settingsString += "&ultralink_ultralinkMeAnalytics=" + document.getElementById('ultralink_ultralinkMeAnalytics').checked;

        settingsString += "&ultralink_categoryWhitelist=" + encodeURIComponent(document.getElementById('ultralink_categoryWhitelist').value);
        settingsString += "&ultralink_categoryBlacklist=" + encodeURIComponent(document.getElementById('ultralink_categoryBlacklist').value);

//        APICall( localAPI + "saveSettings.php", settingsString, function( xhrCall )
        APICall( ajaxurl, settingsString + "&action=saveSettings", function( xhrCall )
        {
            if( xhrCall.status == 200 )
            {
                console.log(xhrCall.responseText);
            }
            else
            {
                alert("Error " + xhrUS.status + " occurred while trying to update the settings: " + xhrCall.responseText);
            }

            jQuery( '#saving_Settings' ).hide();
            jQuery( '#ultralink_Settings' ).show();
        } );
    }

    function refreshUltralinkMeConnection()
    {
        if( sourceType == 0 )
        {
            jQuery('#accountConfig').hide();
//            jQuery('#multisiteToggle').hide();
//            jQuery('#creationSettings').hide();
            jQuery('#ultralinkmeSyncSettings').hide();
//            jQuery('#ultralinkmeSourceSettings').show();
        }
        else
        {
            jQuery('#accountConfig').show();
//            jQuery('#creationSettings').show();
//            jQuery('#ultralinkmeSourceSettings').hide();

            if( ultralinkMeEmail && ultralinkMeAPIKey )
            {
                document.getElementById("connected_Account_email").textContent = "Connected Account: " + ultralinkMeEmail;
                document.getElementById("connected_Account_lastSync").textContent = "Last Sync: " + ultralinkMeLastSync;

                jQuery('#ultralink_Account').hide();
                jQuery('#connected_Account').show();
                
                jQuery('#ultralinkmeSyncSettings').show();
            }
            else
            {
                jQuery('#ultralink_Account').show();
                jQuery('#connected_Account').hide();

                jQuery('#ultralinkmeSyncSettings').hide();
            }
        }
    }

    function connectUltralinkMe()
    {
//        ultralinkMeEmail    = document.getElementById('ultralinkMeEmail').value; //*
//        ultralinkMePassword = document.getElementById('ultralinkMePassword').value;
//
//        if( (ultralinkMeEmail.length > 0) && (ultralinkMePassword.length > 0) )
//        {
//            document.getElementById("connecting_Account_label").textContent = "Connecting Account...";
//        
//            jQuery('#ultralink_Account').hide();
//            jQuery('#connecting_Account').show();
//
//            var defaultSearchDropdown = document.getElementById('ultralink_defaultSearch');
//
//            APICall( APIversion + "plugin/getAPIKey", "email=" + encodeURIComponent(ultralinkMeEmail) + "&hash=" + encodeURIComponent(Crypto.SHA1(ultralinkMePassword + "norainbow42", { asString: true })), function( xhrCall )
//            {
//                if( xhrCall.status == 200 )
//                {                        
//                    var result = JSON.parse(xhrCall.responseText);
//                    ultralinkMeAPIKey = result['apiKey']; // Needs to be scoped so that this resolves to the one defined in header/adminheader.php
//                    var ultralinkMeWebsiteVerifier = result['websiteVerifier'];
//                    var ultralinkMeStaticContentKey = result['staticContentKey'];
//
//                    APICall( localAPI + "storeAPIKey.php", "&ultralinkMeEmail=" + encodeURIComponent(ultralinkMeEmail) + "&ultralinkMeApiKey=" + encodeURIComponent(ultralinkMeAPIKey) + "&ultralinkMeWebsiteVerifier=" + encodeURIComponent(ultralinkMeWebsiteVerifier) + "&ultralinkMeStaticContentKey=" + encodeURIComponent(ultralinkMeStaticContentKey), function( xhrCall2 )
//                    {
//                        jQuery( '#connecting_Account' ).hide();
//
//                        if( xhrCall2.status == 200 )
//                        {
//                            document.getElementById("connected_Account_email").textContent = "Connected Account: " + ultralinkMeEmail;
//                            document.getElementById("connected_Account_lastSync").textContent = "Last Sync: " + ultralinkMeLastSync;
//
//                            jQuery( '#connected_Account' ).show();
////                                    console.log(xhrCUM2.responseText);
//
//                            APICall( APIversion + "storeAPIKey.php", "email=" + encodeURIComponent(ultralinkMeEmail) + "&ultralink_website=" + encodeURIComponent(siteurl) );
//                                                            
//                            updateUltralinkMe('ultralink_initial_scan');                                        
//                        }
//                        else
//                        {
//                            jQuery( '#ultralink_Account' ).show();
//                            alert("Error " + xhrCall2.status + " occurred while trying to store the API Key: " + xhrCall2.responseText);                                    
//                        }
//                    } );
//                }
//                else
//                {
//                    jQuery( '#connecting_Account' ).hide();
//                    jQuery( '#ultralink_Account' ).show();
//
//                    alert("Error " + xhrCall.status + " occurred while trying to connect to ultralink.me: " + xhrCall.responseText);
//                }
//            } );
//        }
//        else
//        {
//            alert("Please enter the email address and password for your ultralink.me account.");                                    
//        }
    }

    function disconnectUltralinkMe()
    {
//        document.getElementById("connecting_Account_label").textContent = "Disconnecting Account..."; //*
//    
//        jQuery('#connected_Account').hide();
//        jQuery('#connecting_Account').show();
//        
//        APICall( localAPI + "removeAPIKey.php", "", function( xhrCall )
//        {
//            jQuery( '#connecting_Account' ).hide();
//
//            if( xhrCall.status == 200 )
//            {
//                APICall( APIversion + "plugin/disconnectWebsite", "email=" + encodeURIComponent(ultralinkMeEmail) + "&apiKey=" + encodeURIComponent(ultralinkMeAPIKey) + "&website=" + encodeURIComponent(siteurl) );
//            
//                document.getElementById("connected_Account_email").textContent    = "Connected Account: " + ultralinkMeEmail;
//                document.getElementById("connected_Account_lastSync").textContent = "Connected Account: " + ultralinkMeLastSync;
//
//                jQuery( '#ultralink_Account' ).show();
////                                    console.log(xhrCall.responseText);
//            }
//            else
//            {
//                jQuery( '#connected_Account' ).show();
//                alert("Error " + xhrCall.status + " occurred while trying to store the API Key: " + xhrCall.responseText);                                    
//            }
//        } );
    }
    
    function processLatestSyncContents(hideProgress, extent)
    {
//        var startTime = microtime(true); //*
//
//        APICall( localAPI + "processLastSync.php", "", function( xhrCall )
//        {
//            if( xhrCall.status == 200 )
//            {
//                document.getElementById("connected_Account_lastSync").textContent = "Last Sync: " + xhrCall.responseText;
//                
//                if( hideProgress == 0 )
//                {
//                    jQuery('#syncButtons').show();
//                    jQuery('#syncProgress').hide();
//                }
//                
//                if( hideProgress == 1 )
//                {
//                    actualUpdateUltralinkMe(extent);
//                }
//            }
//            else
//            {
//                document.getElementById("connected_Account_lastSync").textContent = "processLatestSyncContents Error: " + xhrCall.responseText;
//                
//                if( hideProgress == 0 )
//                {
//                    jQuery('#syncButtons').show();
//                    jQuery('#syncProgress').hide();
//                }
//            }
//            
//            console.log("(" + (microtime(true) - startTime) + ") processLatestSyncContents " + hideProgress + " " + extent);
//        } );
    }
    
    function getLatestSyncContents(hideProgress, extent)
    {
//        var startTime = microtime(true); //*
//
//        APICall( localAPI + "getLastSync.php", "", function( xhrCall )
//        {
//            if( xhrCall.status == 200 )
//            {
//                processLatestSyncContents(hideProgress, extent);
//            }
//            else if( (xhrCall.status == 504) || (xhrCall.status == 404) ) // Looks like some servers incorrectly return 404 on timeout
//            {
//                getLatestSyncContents(hideProgress, extent)
//            }
//            else
//            {
//                document.getElementById("connected_Account_lastSync").textContent = "getLatestSyncContents Error: " + xhrCall.responseText;
//                
//                jQuery('#syncButtons').show();
//                jQuery('#syncProgress').hide();
//            }
//            
//            console.log("(" + (microtime(true) - startTime) + ") getLatestSyncContents " + hideProgress + " " + extent);
//        } );
    }
    
    function actualUpdateUltralinkMe(extent)
    {
//        var startTime = microtime(true); //*
//
//        var apiCall = "sync.php"; if( extent == "ultralink_initial_scan" ){ apiCall = "initialScan.php"; } // ultralink_sync, ultralink_initial_scan
//
//        APICall( localAPI + apiCall, "", function( xhrCall )
//        {
////                    if( xhrCall.status == 200 )
////                    {
////                        processLatestSyncContents(0, '');
////                    }
////                    else if( xhrCall.status == 504 )
////                    {
////                        getLatestSyncContents(0, '')
////                    }
//            if( (xhrCall.status == 200) || (xhrCall.status == 504) || (xhrCall.status == 404) ) // Looks like some servers incorrectly return 404 on timeout
//            {
//                getLatestSyncContents(0, '');
//            }
//            else
//            {
//                document.getElementById("connected_Account_lastSync").textContent = "actualUpdateUltralinkMe Error: " + xhrCall.responseText;
//                
//                jQuery('#syncButtons').show();
//                jQuery('#syncProgress').hide();
//            }
//            
//            console.log("(" + (microtime(true) - startTime) + ") actualUpdateUltralinkMe " + extent);
//        } );
    }
    
    function updateUltralinkMe(extent)
    { //console.log("updateUltralinkMe " + extent);
        jQuery('#syncButtons').hide();
        jQuery('#syncProgress').show();
        
        getLatestSyncContents(1, extent);            
    }
    
    function mergeIdenticalLinksNow()
    {
//        APICall( localAPI + "mergeIdenticalLinks.php", "", function( xhrCall ) //*
//        {
//            console.log(xhrCall.responseText);
//        } );
    }
    
    function upgradePlugin(version)
    {
//        APICall( localAPI + "upgradePlugin.php", "&version=" + encodeURIComponent(version), function( xhrCall ) //*
//        {
//            console.log(xhrCall.responseText);                
//            window.location.reload();
//        } );
    }

    function checkForUpdates()
    {
//        APICall( localAPI + "checkForUpdates.php", "&version=" + encodeURIComponent(version), function( xhrCall ) //*
//        {
//            console.log(xhrCall.responseText);                
//            window.location.reload();                
//        } );
    }
    
    function toggleMultiSite()
    {
        jQuery("#sourceToggle").hide();
        jQuery("#multisiteToggle").hide();
        jQuery("#siteConfig").hide();
        jQuery("#multisiteProgress").show();
        
        setTimeout( function()
        {
//            APICall( localAPI + "toggleMultiSite.php", "&ultralink_useMultisiteDatabase=" + document.getElementById('ultralink_useMultisiteDatabase').checked, function( xhrCall )
            APICall( ajaxurl, "&ultralink_useMultisiteDatabase=" + document.getElementById('ultralink_useMultisiteDatabase').checked + "&action=toggleMultiSite", function( xhrCall )
            {
                if( xhrCall.status == 200 )
                {
                    window.location.reload();
                }
                else
                {
                    alert("Error " + xhrUS.status + " occurred while trying to toggle multi-site: " + xhrCall.responseText);
                }
            } );
        }, 100 );
    }

    function toggleSourceType( toType )
    {
//        jQuery("#sourceToggle").hide(); //*
//        jQuery("#multisiteToggle").hide();
//        jQuery("#siteConfig").hide();
//        jQuery("#multisiteProgress").show();
//        
//        setTimeout( function()
//        {
//            APICall( localAPI + "toggleSource.php", "&ultralink_sourceType=" + toType, function( xhrCall )
//            {
//                if( xhrCall.status == 200 )
//                {
//                    window.location.reload();
//                }
//                else
//                {
//                    alert("Error " + xhrUS.status + " occurred while trying to toggle source type: " + xhrCall.responseText);
//                }
//            } );
//        }, 100 );
    }

    var databaseCheckLock = false;

    function enteredDatabase()
    {
        var databaseField = document.getElementById('ultralink_source');

        if( (databaseField.value == '') || (databaseField.value == 'ultralink.me') )
        {
            databaseField.value = 'ultralink.me';
        }
    }

</script>

<div>

    <div>
		<br>
		<div class="settingSection">
            <h2 style="margin-top: 4px;">Ultralink WordPress Plugin Version <?php global $ultralink_version_string; echo $ultralink_version_string; ?></h2>
            <div style='display: none;'>
                <?php
                    global $ultralink_version;
                    
//                    echo "UV : " . $ultralink_version . "<br>";
//                    echo "LAV: " . $latestAvailableVersion . "<br>";

                    $msDisplay = "";
                    if( $useMultisiteDatabase == "checked" ){ $msDisplay = "none"; }

                         if( $ultralink_version == $latestAvailableVersion ){ echo "You are up-to-date."; }
                    else if( $ultralink_version  < $latestAvailableVersion ){ echo "Newer version " . $latestAvailableVersionString . " is available. <input type='button' onclick='upgradePlugin(\"$latestAvailableVersionString\")' value='Upgrade' style='display: " . $msDisplay . ";' />"; }
                    else if( $ultralink_version  > $latestAvailableVersion ){ echo "You are running an unreleased version."; }
                ?>
            </div>
            <div style="display: none;">
                <input type='button' onclick='checkForUpdates()' value='Check For Updates' />
            </div>
        </div>
        <br>
        <div id="multisiteToggle" style="display: <?php if( ($isMultisite == 0) || ((!empty($networkAdmin)) && ($networkAdmin == 'true')) ){ echo 'none'; } ?>; font-size: 1.3em; margin-left: 40px;"><input id='ultralink_useMultisiteDatabase' type='checkbox' <?php if( $useMultisiteDatabase  == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' onclick='toggleMultiSite()' /> Use Multi-Site Settings</div>
        <!-- <div id='sourceToggle' style="width: 500px; display: <?php if( $useMultisiteDatabase == 'checked' ){ echo 'none'; } ?>;"> -->
        <div id='sourceToggle' style="width: 500px; display: none;">
            <center>
                <span style='font-size: 1.4em; font-weight: bold;'>Source Ultralinks From :</span><br><br>
                <span style='font-size: 1.3em;'><span class='settingSection'>ultralink.me <input id='ultralinkmeSource' type='radio' name='ultralinkSource' <?php if( $sourceType == 0 ){ echo "checked='checked'"; } ?> onclick='toggleSourceType(0)' /></span> &nbsp;&nbsp;&nbsp;&nbsp; or &nbsp;&nbsp;&nbsp;&nbsp; <span class='settingSection'>Local Database <input id='localSource' type='radio' name='ultralinkSource' <?php if( $sourceType == 1 ){ echo "checked='checked'"; } ?> onclick='toggleSourceType(1)' /></span></span>
            </center>
        </div>
        <div id="multisiteProgress" style="display: none;"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/loading.gif'; ?>" /></div>
        <div id="siteConfig" style="display: <?php if( $useMultisiteDatabase == 'checked' ){ echo 'none'; } ?>;">
            <div id="accountConfig" class="settingSection" >
                <h2 style="margin-top: 4px;"><a href="https://ultralink.me/dashboard/" target="_blank">ultralink.me</a> Account</h2>
                <div id="connecting_Account" style="display: none;">
                    <table><tr><td><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/loading.gif'; ?>" /></td><td valign="middle"><big><b id="connecting_Account_label">Connecting Account...</b></big></td></tr></table>
                </div>
                <div id="connected_Account" style="display: none;">
                    <table>
                        <tr><td><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/logo16.png'; ?>" /></td><td valign="middle"><big><b id="connected_Account_email">Connected Account: </b></big></td><td><input type='button' onclick="disconnectUltralinkMe()" value="Disconnect" /></td></tr>
                        <tr id="syncButtons"><td colspan='3' align="center"><b id="connected_Account_lastSync">Last Sync: </b> <input type='button' onclick="updateUltralinkMe('ultralink_sync')" value="Sync Now" /> <input type='button' onclick="updateUltralinkMe('ultralink_initial_scan')" value="Complete Re-Sync" /></td></tr>
                        <tr id="syncProgress" style="display: none;"><td colspan='3' align="center"><table><tr><td><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/loading.gif'; ?>" /></td><td valign="middle"><big><b>Syncing with ultralink.me ...</b></big><br><small>(This can take a couple of minutes)</small><br></td></tr></table></td></tr>
                    </table>
                </div>
                <div id="ultralink_Account" style="display: none;">
                    <table>
                    <tr><td colspan="2" align="center"><span style="font-size: 1.2em; font-weight: bold;">Sign up for an account at <a href="https://ultralink.me/dashboard/" target="_blank">ultralink.me</a>.</span></td><tr>
                    <tr><td colspan="2">Connecting your blog with ultralink.me will ensure that your <a onclick='jQuery("ul.tabs").data("tabs").click(1);'>Words Database</a> is always up-to-date and that any words you add to it will get crowdsourced back to ultralink.me and improve the quality of the service.<br><br>Connecting also gives you access to detailed analytics about your site and your content.<br><br></td></tr>
                    <tr><td width="130">Email:</td><td><input id='ultralinkMeEmail' size='40' type='text' value='<?php echo $ultralinkMeEmail; ?>' /></td></tr>
                    <tr><td>Password:</td><td><input id='ultralinkMePassword' size='40' type='password' onkeydown="if( event.keyCode == 13 ){ connectUltralinkMe(); }" /></td></tr>
                    </table>
                    <center><input type='button' onclick="connectUltralinkMe()" value="Connect" style='margin-top: 10px;' /></center>
                </div>
            </div>
            <br>
            <div id="saving_Settings" style="display: none;">
                <table><tr><td><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/loading.gif'; ?>" /></td><td valign="middle"><big><b>Saving settings...</b></big></td></tr></table>
            </div>
            <div id="ultralink_Settings" class="settingSection">

                <div id="experienceSettings">
                    <center><h2 style="margin-top: 0px; margin-bottom: 8px;">Ultralinks Enabled <input id='ultralink_ultralinkEnabled' type='checkbox' <?php if( $ultralinkEnabled == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' style="margin-top: 4px;" onclick='jQuery("#settingsTable, #creationSettings, #ultralinkmeSourceSettings").toggle();' /></h2></center>
                    <table id="settingsTable" style='<?php if( $ultralinkEnabled != "checked"){ echo "display: none"; } ?>'>

                        <tr style="display: none; height: 28px;">
                            <td colspan="2">
                                <input id='ultralink_alwaysSearch' type='checkbox' <?php if( $alwaysSearch == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' onclick='jQuery("#ultralink_multipleSearchOptionsRow").toggle();' /> Automatically add "Search" to every word using engine: 
                                <select id='ultralink_defaultSearch'>
                                    <option value='google' <?php if( $defaultSearch == 'google' ){ echo "SELECTED"; } ?> >Google</option>
                                    <option value='bing'   <?php if( $defaultSearch ==   'bing' ){ echo "SELECTED"; } ?> >Bing</option>
                                </select>
                            </td>
                        </tr>

                        <tr id='ultralink_multipleSearchOptionsRow' style='display: none; height: 28px;'><td  style="padding-left: 20px;"><input id='ultralink_multipleSearchOptions' type='checkbox' <?php if( $multipleSearchOptions == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' /> Multiple Search Options</td></tr>

                        <tr style="height: 28px; display: none;"><td><input id='ultralink_combineSimilarButtons' type='checkbox' <?php if( $combineSimilarButtons == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' /> Combine Similar Buttons</td></tr>
                        <tr style="height: 28px;"><td><input id='ultralink_mouseProximityFade'    type='checkbox' <?php if( $mouseProximityFade    == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' /> Cursor Proximity Fade</td></tr>

                        <tr style="height: 28px;"><td><input id='ultralink_hasHoverTime'          type='checkbox' <?php if( $hasHoverTime          == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' onclick='jQuery("#ultralink_hoverTimeCell").toggle();' /> Trigger on Cursor Hover</td><td id='ultralink_hoverTimeCell' style='<?php if( $hasHoverTime != "checked"){ echo "display: none"; } ?>'><input id='ultralink_hoverTime' type='text' size='3' value='<?php echo $hoverTime; ?>' style="text-align: right;" /> mS</td></tr>
                        <tr style="height: 28px; display: none;"><td><input id='ultralink_hasPopupRecoveryTime'  type='checkbox' <?php if( $hasPopupRecoveryTime  == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' onclick='jQuery("#ultralink_popupRecoveryTimeCell").toggle();' /> Popup Recovery Time</td><td id='ultralink_popupRecoveryTimeCell' style='<?php if( $hasPopupRecoveryTime != "checked"){ echo "display: none"; } ?>'><input id='ultralink_popupRecoveryTime' type='text' size='3' value='<?php echo $popupRecoveryTime; ?>' style="text-align: right;" /> mS</td></tr>

                        <tr style="height: 28px;"><td><input id='ultralink_linksMakeNewWindows'   type='checkbox' <?php if( $linksMakeNewWindows   == "checked"){ echo "checked=\"checked\""; } ?> value='Yes' /> Open Links in New Windows</td></tr>

                    </table>
                </div>

                <div id="creationSettings" style='<?php if( $ultralinkEnabled != "checked"){ echo "display: none"; } ?>'>
                    <h2 style="margin-top: 10px;">Affiliate Keys</h2>
                    <table>
                    <tr><td width="130">Amazon Affiliate Tag:</td><td><input id='ultralink_amazonAffiliateTag' size='40' type='text' value='<?php echo $amazonAffiliateTag; ?>' /></td></tr>
                    <tr><td>Linkshare ID:</td><td><input id='ultralink_linkshareID' size='40' type='text' value='<?php echo $linkshareID; ?>' /></td></tr>
                    <tr><td>PHG ID:</td><td><input id='ultralink_phgID' size='40' type='text' value='<?php echo $phgID; ?>' /></td></tr>
                    <tr><td>eBay Campaign:</td><td><input id='ultralink_ebayCampaign' size='40' type='text' value='<?php echo $ebayCampaign; ?>' /></td></tr>
                    </table>
                </div>

                <div id="categoryWhitelist" style='<?php if( $ultralinkEnabled != "checked"){ echo "display: none"; } ?>'>
                    <h2 style="margin-top: 10px;">Category Whitelist</h2>
                    <textarea id="ultralink_categoryWhitelist" class='categoryList'><?php echo $categoryWhitelist; ?></textarea>
                </div>

                <div id="categoryBlacklist" style='<?php if( $ultralinkEnabled != "checked"){ echo "display: none"; } ?>'>
                    <h2 style="margin-top: 10px;">Category Blacklist</h2>
                    <textarea id="ultralink_categoryBlacklist" class='categoryList'><?php echo $categoryBlacklist; ?></textarea>
                </div>

                <div id="ultralinkmeSyncSettings">
                    <h2 style="margin-top: 10px;">ultralink.me Interaction</h2>
                    <table>
                    <tr><td><input id='ultralink_mergeUltralinkMeLinks' type='checkbox' <?php if( $mergeUltralinkMeLinks == "checked" ){ echo "checked=\"checked\""; } ?> value='Yes' /> Merge with identical Ultralinks from ultralink.me</td><td style="display: none;"><input type='button' onclick="mergeIdenticalLinksNow()" value="Merge Now" /></td></tr>
                    <tr><td><input id='ultralink_ultralinkMeAnalytics'  type='checkbox' <?php if(  $ultralinkMeAnalytics == "checked" ){ echo "checked=\"checked\""; } ?> value='Yes' /> Record analytics data</td></tr>
                    </table>
                </div>

                <div id="ultralinkmeSourceSettings" style='<?php if( $ultralinkEnabled != "checked"){ echo "display: none"; } ?>'>
                    <h2 style="margin-top: 10px;">ultralink.me</h2>
                    <div id="ultralinkmeDatabaseDiv" style='<?php if( !empty($source) && ($source != "ultralink.me") ){ echo "display: none"; } ?>'><div id="ultralinkmeDatabaseInfo">To create and manage your own seperate ultralink database, create an account at ultralink.me. Once you have created your own <b>Hosted Database</b>, you can enter it's name below to maintain complete control over the ultralinks on your site. The <a href="https://ultralink.me/w/umdatabase.html" target="_blank">Mainline Database</a> is used by default.</div><a href='https://ultralink.me/dashboard' target='_blank'><input type="button" value='ultralink.me Dashboard' /></a></div>
                    <table>
                    <tr><td>Database: </td><td><input id='ultralink_source' size='20' type='text' value='<?php echo $source; ?>' onblur='enteredDatabase()' onkeydown='if( event.keyCode == 13 ){ jQuery("#ultralink_source").blur(); }' /></td></tr>
                    </table>
                </div>

                <section class='divider' style='margin-top: 15px; margin-bottom: 15px;'></section>

                <center><input type='button' onclick="updateUltralinkSettings()" value="Update Settings" style='margin-bottom: 5px;' /></center>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        refreshUltralinkMeConnection();
    </script>
</div>
